<?php
/*
Whois.php        PHP classes to conduct whois queries

Copyright (C)1999,2005 easyDNS Technologies Inc. & Mark Jeftovic

Maintained by David Saez (david@ols.es)

For the most recent version of this package visit:

http://www.phpwhois.org

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/

class WhoisClient {

	// Recursion allowed ?
	var $gtld_recurse = false;

	// Default WHOIS port
	var $PORT = 43;

	// Maximum number of retries on connection failure
	var $RETRY = 0;

	// Time to wait between retries
	var $SLEEP = 2;

	// Read buffer size (0 == char by char)
	var $BUFFER = 255;
	
	// Communications timeout
	var $STIMEOUT = 20;

	// List of servers and handlers (loaded from servers.whois)
	var $DATA = array(); 	
	
	// Array to contain all query variables
	var $Query = array(
		'tld' => '',
		'type' => 'domain',
		'string' => '',
		'status',
		'server'
		);
	
	/*
	 * Constructor function
	 */
	function WhoisClient () {
		// Load DATA array
		@require('whois.servers.php');		
	}
		
	/*
	 * Perform lookup. Returns an array. The 'rawdata' element contains an
	 * array of lines gathered from the whois query. If a top level domain
	 * handler class was found for the domain, other elements will have been
	 * populated too.
	 */

	function GetData ($query='') {
		// If domain to query passed in, use it, otherwise use domain from initialisation
		$string = !empty($query) ? $query : $this->Query['string'];
		
		$this->Query['string'] = $string;
		
		if (!isset($this->Query['server'])) {
			$this->Query['status'] = -1;
			$this->Query['errstr'][] = 'No server specified';
			return(array());
			}

		// Check if protocol is http
		if (substr($this->Query['server'],0,7)=='http://' ||
			substr($this->Query['server'],0,8)=='https://')
			{
			$output = $this->httpQuery($this->Query['server']);
			}
		else
			{
			// Connect to whois server, or return if failed
			$ptr = $this->Connect();
		
			if($ptr < 0) {
				$this->Query['status'] = -1;
				$this->Query['errstr'][] = 'Connect failed to: '.$this->Query['server'];
				return(array());
				}

			if (version_compare(phpversion(),'4.3.0')>=0)
				stream_set_timeout($ptr,$this->STIMEOUT);

			if (isset($this->WHOIS_PARAM[$this->Query['server']]))
				fputs($ptr, $this->WHOIS_PARAM[$this->Query['server']].trim($string)."\r\n");
			else
				fputs($ptr, trim($string)."\r\n");

			// Prepare to receive result
			$raw = '';
			$output = array();
			while(!feof($ptr)) {
				// If a buffer size is set, fetch line-by-line into an array
				if($this->BUFFER)
					$output[] = trim(fgets($ptr, $this->BUFFER));
				// If not, fetch char-by-char into a string
				else
					$raw .= fgetc($ptr);
				}

			// If captured char-by-char, convert to an array of lines
			if(!$this->BUFFER)
				$output = explode("\n", $raw);

			// Drop empty last line
			unset($output[count($output)-1]);
			}
			
		// Create result and set 'rawdata'
		$result = array();			
		$result['rawdata'] = $output;

		// If we have a handler, post-process it with that

		if(isSet($this->Query['handler']))
			$result = $this->Process($result);

		// Set whois server
		$result['regyinfo']['whois'] = $this->Query['server'];

		// Type defaults to domain
		if (!isset($result['regyinfo']['type']))
			$result['regyinfo']['type'] = 'domain';	
		
		// Add error information if any
		if (isset($this->Query['errstr']))
			$result['errstr'] = $this->Query['errstr'];

		// If no rawdata use rawdata from first whois server
		if (!isset($result['rawdata']))
			$result['rawdata'] = $output;
		
		// Fix/add nameserver information
		if (method_exists($this,'FixResult') && $this->Query['tld']!='ip')
			$this->FixResult($result,$string);
			
		return($result);
	}
	
	/*
	*   Convert html output to plain text
	*/
	function httpQuery ($query) {
		$lines = file($this->Query['server']);
		$output = '';
		$pre = '';

		while (list($key, $val)=each($lines)) {
			$val = trim($val);

			$pos=strpos(strtoupper($val),'<PRE>');
			if ($pos!==false) {
				$pre = "\n";
				$output.=substr($val,0,$pos)."\n";
				$val = substr($val,$pos+5);
				}
			$pos=strpos(strtoupper($val),'</PRE>');
			if ($pos!==false) {
				$pre = '';
				$output.=substr($val,0,$pos)."\n";
				$val = substr($val,$pos+6);
				}
			$output.=$val.$pre;
			}
			
		$search = array (
				'<BR>', '<P>', '</TITLE>',
				'</H1>', '</H2>', '</H3>',
				'<br>', '<p>', '</title>',
				'</h1>', '</h2>', '</h3>'  );

		$output = str_replace($search,"\n",$output);
		$output = str_replace('<TD',' <td',$output);
		$output = str_replace('<td',' <td',$output);
		$output = str_replace('<tr',"\n<tr",$output);
		$output = str_replace('<TR',"\n<tr",$output);
		$output = str_replace('&nbsp;',' ',$output);
		
		//$output = html_entity_decode($output); needs 4.3.0
		$trans_tbl = get_html_translation_table (HTML_ENTITIES); 
		$trans_tbl = array_flip ($trans_tbl); 
		$output = strtr($output, $trans_tbl);		
			
		$output = explode("\n",strip_tags($output));

		$rawdata = array();
		$null = 0;

		while (list($key, $val)=each($output)) {
			$val=trim($val);
			if ($val=='') {
				if (++$null>2) continue;
			}
			else $null=0;
			$rawdata[]=$val;
		}
		return $rawdata;
	}
	
	/*
	 * Open a socket to the whois server.
	 *
	 * Returns a socket connection pointer on success, or -1 on failure.
	 */
	function Connect ($server = '') {
	
		if ($server == '')
			$server = $this->Query['server'];
			
		// Fail if server not set
		if($server == '')
			return(-1);

		// Get rid of protocol and/or get port
		$port = $this->PORT;
		
		$pos = strpos($server,'://');
		
		if ($pos !== false)
			$server = substr($server, $pos+3);
			
		$pos = strpos($server,':');
		
		if ($pos !== false)
			{
			$port = substr($server,$pos+1);
			$server = substr($server,0,$pos);			
			}
			
		// Enter connection attempt loop
		$retry = 0;
		
		while($retry <= $this->RETRY) {
			// Set query status
			$this->Query['status'] = 'ready';

			// Connect to whois port
			$ptr = @fsockopen($server, $port);
			if($ptr > 0) {
				$this->Query['status']='ok';
				return($ptr);
			}
			
			// Failed this attempt
			$this->Query['status'] = 'error';
			$retry++;

			// Sleep before retrying
			sleep($this->SLEEP);
		}
		
		// If we get this far, it hasn't worked
		return(-1);
	} 	
	
	/*
	 * Post-process result with handler class. On success, returns the result
	 * from the handler. On failure, returns passed in result unaltered.
	 */
	function Process (&$result) {

		// If the handler has not already been included somehow, include it now
		$HANDLER_FLAG = sprintf("__%s_HANDLER__", strtoupper($this->Query['handler']));

		if(!defined($HANDLER_FLAG))
			include($this->Query['file']);

		// If the handler has still not been included, append to query errors list and return
		if(!defined($HANDLER_FLAG)) {
			$this->Query['errstr'][] = "Can't find ".$this->Query['tld'].' handler: '.$this->Query["file"];
			return($result);
		}

		if (!$this->gtld_recurse && $this->Query['file']=='whois.gtld.php')
			return $result;

		// Pass result to handler
		$object = $this->Query['handler'].'_handler';

		$handler = new $object('');

		// If handler returned an error, append it to the query errors list
		if(isSet($handler->Query['errstr']))
			$this->Query['errstr'][] = $handler->Query['errstr'];

		// Return the result
		return $handler->parse($result,$this->Query['string']);
	}	
}
