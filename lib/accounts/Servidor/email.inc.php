<?
class Email{
	
	var $_from;
	var $_to;
	var $_subject;
	var $_message;
	var $_is_html;
	
	var $_countAdd = 0;
	var $_conexionSMTP;
	var $_server = "64.87.104.135";
	var $_dns_server = "dserver.net";
	
	function Email($from, $to, $subject, $message, $is_html){
		$this->_from = $from;
		$this->add_to($to);
		$this->_subject = $subject;
		$this->set_message($message);
		if ($is_html == 1){
			$this->_is_html = true;
		}else{
			$this->_is_html = false;
		}
	}
	
	function set_message($message){
		$this->_message = $message;
	}
	
	function add_to($address){
		$this->_to[$this->_countAdd] = $address;
		$this->_countAdd++;
	}
	
	function send(){		
		$this->_conexionSMTP = fsockopen($this->_dns_server,25);
		$strEHLO = "EHLO ".$this->_server."\r\n";
//		$strEHLO = "EHLO 64.87.104.135\r\n";
		fputs($this->_conexionSMTP,$strEHLO);
//		if (ereg("^220", fgets($this->_conexionSMTP,512));
		fgets($this->_conexionSMTP,512);
//		if (ereg("^250", fgets($this->_conexionSMTP,512));
		fgets($this->_conexionSMTP,512);
		fgets($this->_conexionSMTP,512);
		fgets($this->_conexionSMTP,512);
		fgets($this->_conexionSMTP,512);
		fgets($this->_conexionSMTP,512);
		fgets($this->_conexionSMTP,512);
		fgets($this->_conexionSMTP,512);
		fgets($this->_conexionSMTP,512);
		fgets($this->_conexionSMTP,512);
		fgets($this->_conexionSMTP,512);
//		if (ereg("^250", fgets($this->_conexionSMTP,512));

		$strMAIL = "MAIL FROM: <".$this->_from.">\r\n";
		fputs($this->_conexionSMTP,$strMAIL);
		fgets($this->_conexionSMTP,512);
//		if (ereg("^250", fgets($this->_conexionSMTP,512));		
		
		$strRCPT = "";
		for($i=0;$i<$this->_countAdd;$i++){
			$strRCPT .= "RCPT TO: <".$this->_to[$i].">\r\n";			
		}
//fputs ( $Connect, "RCPT TO: <{$Email}>\r\n" );
		fputs($this->_conexionSMTP,$strRCPT);
//		fgets($this->_conexionSMTP,512);
		if (substr(trim(fgets($this->_conexionSMTP,512)), 0, 3) != '250'){			
			return FALSE;
		}		
		
		$strDATA1 = "DATA\r\n";
		fputs($this->_conexionSMTP,$strDATA1);
		fgets($this->_conexionSMTP,512);
//		if (ereg("^354", fgets($this->_conexionSMTP,512));		
		
		fputs($this->_conexionSMTP,"From: ".$this->_from."\r\n");
		fputs($this->_conexionSMTP,"To: ".$this->_to[0]."\r\n");
//		fputs($this->_conexionSMTP,"Cc: ".$this->_to[0]."\r\n");
//		fputs($this->_conexionSMTP,"Bcc: ".$this->_to[0]."\r\n");
		fputs($this->_conexionSMTP,"Subject: ".$this->_subject."\r\n");
		if ($this->_is_html == true){
			fputs($this->_conexionSMTP,"Content-type: text/html\r\n");
		}
		
		$strDATA2 = $this->_message."\r\n.\r\n";
		fputs($this->_conexionSMTP,$strDATA2);
		fgets($this->_conexionSMTP,512);
//		if (ereg("^250", fgets($this->_conexionSMTP,512));		
		
		fputs($this->_conexionSMTP,"QUIT\r\n");
		fgets($this->_conexionSMTP,512);
//		if (ereg("^221", fgets($this->_conexionSMTP,512));		

		fclose($this->_conexionSMTP);

/*
$fp=fsockopen("dserver.net",25);

//The GET request must be followed by a blank line as required in the relevant RFC thus - \n\n
fputs($fp,"EHLO 64.87.104.135\r\n");
/*$buf ="";
		$buf .= fgets($fp,512);
		$buf .= fgets($fp,512);
		$buf .= fgets($fp,512);
		$buf .= fgets($fp,512);
		$buf .= fgets($fp,512);
		$buf .= fgets($fp,512);
		$buf .= fgets($fp,512);
		$buf .= fgets($fp,512);
		$buf .= fgets($fp,512);
		$buf .= fgets($fp,512);
		$buf .= fgets($fp,512);
	
echo fgets($fp,512); //Displays first line of response from the server

echo fgets($fp,512);
echo fgets($fp,512);
echo fgets($fp,512);
echo fgets($fp,512);
echo fgets($fp,512);
echo fgets($fp,512);
echo fgets($fp,512);
echo fgets($fp,512);
echo fgets($fp,512);
echo fgets($fp,512);

fputs($fp,"MAIL FROM:dserver@dserver.net\r\n");
//$buf .=fgets($fp,512);
echo fgets($fp,512);
//echo "<br>\n";
fputs($fp,"RCPT TO:vgarcia@dserver.net\r\n");
//$buf .=fgets($fp,512);
echo fgets($fp,512);
//echo "<br>\n";
fputs($fp,"DATA\r\n");
//$buf .=fgets($fp,512);
echo fgets($fp,512);
//echo "<br>\n";
fputs($fp,"From: dserver2@dserver.net\r\n");
fputs($fp,"To: virgilio_2000es@yahoo.es\r\n");
fputs($fp,"Subject: Prueba desde email.inc.php\r\n");

fputs($fp,"texto escrito\r\n.\r\n");
//$buf .=fgets($fp,512);
echo fgets($fp,512);
//echo "<br>\n";
fputs($fp,"QUIT \r\n");
//$buf .=fgets($fp,512);
echo fgets($fp,512);
//echo "<br>\n";
//echo fgets($fp,512);
//echo "<br>\n";

fclose($fp); //Closes the connection
*/	
		return TRUE;
	}
}	

?>