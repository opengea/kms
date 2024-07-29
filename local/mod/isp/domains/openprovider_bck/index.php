<?php
require __DIR__ . '/app/Config/cfg.inc.php';
require __DIR__ . '/vendor/autoload.php';

use App\Modules\Customer;
use App\Modules\Domain;
use App\Modules\Email;
use App\Modules\EmailTemplates;
use App\Modules\Nameserver;

$data = [];
$domain = '';
$extension = '';

/*
$request = new Customer();
$response = $request->APISearchCustomer($data); // response returns array 'results' + 'total'
$response = $request->APICreateCustomer($data); // response returns new customer handle or error code
$response = $request->APIModifyCustomer($data); // response returns array with 'result' true or 'result' false + 'error' error code
$response = $request->APIDeleteCustomer($data); // response returns array with 'result' true or 'result' false + 'error' error code
*/

/*
$request = new Domain();
$response = $request->APICheckDomain($domain, $extension); // response returns array
$response = $request->APICreateDomain($data);
*/

/*
$request = new Nameserver();
$response = $request->searchNsRequest('intergrid.cat');
$response = $request->modifyNsRequest('ns1.intergrid.cat','1.2.3.4', 'FE80::0202:B3FF:FE1E:8329');
$response = $request->retrieveNSRequest('ns1.intergrid.cat');
$response = $request->deleteNsRequest('ns5.intergrid.cat');
*/

/*
$request = new EmailTemplates();
$response = $request->searchEmailTemplateRequest();
$response = $request->createEmailTemplateRequest();
$response = $request->modifyEmailTemplateRequest();
$response = $request->deleteEmailTemplateRequest();
*/

/*
$request = new Email();
$response = $request->searchEmailVerificationDomainRequest('registres@intergrid.cat');
$response = $request->startCustomerEmailVerificationRequest('registres@intergrid.cat');
$response = $request->restartCustomerEmailVerificationRequest('registres@intergrid.cat');
*/

/*
$data = array(
  'id' => '3869'
);
$request = new EmailTemplates();
$response = $request->searchEmailTemplateRequest($data);
print_r($response);
*/

//$request = new Email();
//$response = $request->searchEmailVerificationDomainRequest('dbardaji@gmail.com');

//$request = new Customer();
//$response = $request->APICreateCustomer();

//Modificar DNS
// ApiModifyDomainNameserver('domini','extensio', $nameservers);
// Response: Array
//  (
//    [id] => 1669894
//    [status] => ACT
//  )

$nameservers = [
    ['name' => 'ns1.intergridnetwork.net'],
    ['name' => 'ns2.intergridnetwork.net']
];

$request = new Domain();
$response = $request->APIModifyDomainNameserver('opengea', 'org', $nameservers);
$response = $request->APIModifyDomainAutorenew('opengea','org', 'on'); // on | off | default
$response = $request->APIModifyDomainLock('opengea','org', 1); // boolean default 0
$response = $request->APIModifyDomainPrivateWhois('opengea', 'org', 0); // boolean default 0
print_r($response);