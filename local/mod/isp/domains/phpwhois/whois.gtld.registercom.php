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

/* registercom.whois	1.0	mark jeftovic	1999/12/26 */
/* registercom.whois    2.1     david@ols.es    2003/02/18 */

if (!defined("__REGISTERCOM_HANDLER__"))
	define("__REGISTERCOM_HANDLER__", 1);

require_once('whois.parser.php');

class registercom_handler
	{

	function parse($data_str, $query)
		{

		$items = array(
                  "owner" => "Organization:",
                  "admin" => "Administrative Contact",
                  "tech" => "Technical Contact",
                  "zone" => "Zone Contact",
                  "" => "Registrar Name....:",
                  "domain.nserver" => "Domain servers in listed order:",
                  "domain.name" => "Domain name:",
                  "domain.created" => "Created on..............:",
                  "domain.expires" => "Expires on..............:",
                  "domain.changed" => "Record last updated on..:"
		            );

		$r = get_blocks($data_str, $items);
		$r["owner"] = get_contact($r["owner"]);
		$r["admin"] = get_contact($r["admin"]);
		$r["tech"] = get_contact($r["tech"]);
		$r["zone"] = get_contact($r["zone"]);
		$r = format_dates($r, '-mdy');
		return ($r);
		}
	}

?>
