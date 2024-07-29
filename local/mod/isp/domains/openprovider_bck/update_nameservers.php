<?php
require __DIR__ . '/app/Config/cfg.inc.php';
require __DIR__ . '/vendor/autoload.php';

use App\Modules\Customer;
use App\Modules\Domain;
use App\Modules\Email;
use App\Modules\EmailTemplates;
use App\Modules\Nameserver;

if (!isset($domain_name)||!isset($tld)||!isset($nameserver1)||!isset($nameserver2)) {
	echo "ERROR. Can't update nameservers.";
} else {

	//Modificar DNS
// ApiModifyDomainNameserver('domini','extensio', $nameservers);
// Response: Array
//  (
//    [id] => 1669894
//    [status] => ACT
//  )

$nameservers = [
    ['name' => $nameserver1],
    ['name' => $nameserver2]
];

$request = new Domain();
$response = $request->APIModifyDomainNameserver($domain_name, $tld, $nameservers);
print_r($response);

}
