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

/* enom.whois 1.0 stephen leavitt 2000/12/09 */
/* enom.whois 2.0 tim schulte 2001/03/21 */
/* enom.whois 3.1 david@ols.es 2003/02/16 */

if (!defined("__ENOM_HANDLER__"))
	define("__ENOM_HANDLER__", 1);

require_once('whois.parser.php');

class enom_handler
	{

	function parse($data_str, $query)
		{

		$items = array(
                  "owner" => "Registrant Contact",
                  "admin" => "Administrative Contact",
                  "tech" => "Technical Contact",
                  "billing" => "Billing Contact",
                  "domain.nserver" => "Nameservers",
                  "domain.name#0" => "Domain name:",
                  "domain.name#1" => "Domain name-",
                  "domain.status" => "Status:",
                  "domain.created#0" => "Creation date:",
                  "domain.expires#0" => "Expiration date:",
                  "domain.created#1" => "Created:",
                  "domain.expires#1" => "Expires:",
                  "domain.created#2" => "Start of registration-",
                  "domain.expires#2" => "Registered through-"
                  );

		$r = get_blocks($data_str, $items);
		$r["owner"] = get_contact($r["owner"]);
		$r["admin"] = get_contact($r["admin"]);
		$r["tech"] = get_contact($r["tech"]);
		$r["billing"] = get_contact($r["billing"]);
		$r = format_dates($r, 'dmy');
		return ($r);
		}
	}

?>
