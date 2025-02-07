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

/* org.whois	1.0	David Saez */

if (!defined("__ORG_HANDLER__"))
	define("__ORG_HANDLER__", 1);

require_once('whois.parser.php');

class org_handler
	{

	function parse($data_str, $query)
		{
		$items = array(
                    "Domain Name:" => "domain.name",
                    "Status:" => "domain.status",
                    "Name Server:" => "domain.nserver.",
                    "Created On:" => "domain.created",
                    "Last Updated On:" => "domain.changed",
                    "Expiration Date:" => "domain.expires",
                    "Sponsoring Registrar:" => "domain.sponsor",
                    "Registrant Name:" => "owner.name",
                    "Registrant ID:" => "owner.handle",
                    "Registrant Street1:" => "owner.address.address.0",
                    "Registrant Street2:" => "owner.address.address.1",
                    "Registrant Postal Code:" => "owner.address.pcode",
                    "Registrant City:" => "owner.address.city",
                    "Registrant Country:" => "owner.address.country",
                    "Registrant Email:" => "owner.email",
                    "Admin Name:" => "admin.name",
                    "Admin ID:" => "admin.handle",
                    "Admin Street1:" => "admin.address.address.0",
                    "Admin Street2:" => "admin.address.address.1",
                    "Admin Postal Code:" => "admin.address.pcode",
                    "Admin City:" => "admin.address.city",
                    "Admin Country:" => "admin.address.country",
                    "Admin Email:" => "admin.email",
                    "Tech Name:" => "tech.name",
                    "Tech ID:" => "tech.handle",
                    "Tech Street1:" => "tech.address.address.0",
                    "Tech Street2:" => "tech.address.address.1",
                    "Tech Postal Code:" => "tech.address.pcode",
                    "Tech City:" => "tech.address.city",
                    "Tech Country:" => "tech.address.country",
                    "Tech Email:" => "tech.email",
                    "Technical Phone Number:" => "tech.phone"
		              );

		$r["regrinfo"] = generic_parser_b($data_str["rawdata"], $items);
		$r['regyinfo']['referrer'] = 'http://www.pir.org/';
		$r['regyinfo']['registrar'] = 'Public Interest Registry';
		return ($r);
		}
	}

?>
