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

/* arin.whois	1.0 	David Saez 7/6/2002 */

if (!defined("__ARIN_HANDLER__"))
	define("__ARIN_HANDLER__", 1);

require_once('whois.parser.php');

class arin_handler
	{

	function parse($data_str, $query)
		{
		$items = array(
                  "OrgName:" => "owner.organization",
                  "OrgID:" => "owner.handle",
                  "Address:" => "owner.address.street",
                  "City:" => "owner.address.city",
                  "StateProv:" => "owner.address.state",
                  "PostalCode:" => "owner.address.pcode",
                  "Country:" => "owner.address.country",
                  "NetRange:" => "network.inetnum",
                  "NetName:" => "network.name",
                  "NetHandle:" => "network.handle",
                  "NetType:" => "network.status",
                  "NameServer:" => "network.nserver.",
                  "Comment:" => "network.desc.",
                  "RegDate:" => "network.created",
                  "Updated:" => "network.changed",
                  'ASHandle:' => 'AS.handle',
                  'ASName:' => 'network.name',
                  'NetHandle:' => 'network.handle',
                  'NetName:' => 'network.name',
                  "TechHandle:" => "tech.handle",
                  "TechName:" => "tech.name",
                  "TechPhone:" => "tech.phone",
                  "TechEmail:" => "tech.email",
                  "OrgAbuseName:" => "abuse.name",
                  "OrgAbuseHandle:" => "abuse.handle",
                  "OrgAbusePhone:" => "abuse.phone",
                  "OrgAbuseEmail:" => "abuse.email",
                  'ReferralServer:' => 'rwhois'
		              );

		$r = generic_parser_b($data_str, $items, 'ymd', false);
		
		if (isset($r['AS']))
			{
			$ash = $r['AS']['handle'];
			$r['AS'] = $r['network'];
			$r['AS']['handle'] = $ash;
			unset($r['network']);			
			}
			
		return $r;
		}

	}
?>
