<?php
require __DIR__ . '/app/Config/cfg.inc.php';
require __DIR__ . '/vendor/autoload.php';

use App\Modules\Customer;

$data = [

    'initials' => 'MMM',
    'first_name' => 'Manel',
    'prefix' => 'Sr.',
    'last_name' => 'Manolius Montoliu',
    'gender' => 'M',

    'street' => 'Vermell',
    'street_number' => 15,
    'street_suffix' => 'Àtic',
    'zipcode' => '08010',
    'city' => 'Barcelona',
    'state' => 'Barcelona',
    'country' => 'ES',

    'phone_country_code' => '+34',
    'phone_area_code' => '93',
    'phone_subscriber_phone' => '4426788',

    'fax_country_code' => '+34',
    'fax_area_code' => '93',
    'fax_subscriber_number' => '4426788',

    'email' => 'info@intergrid.cat',
    'locale' => 'ca_CAT', // es_ES (string) ca_CAT (string) eu_EUS (string) en_GB (string)

    'additional_birth_city' => 'Barcelona',
    'additional_birth_date' => '1975-01-02',
    'additional_social_secutity_number' => 'E344543234', // (string?)
    'additional_registration_number' => 'A67237824', // DIN/NIF? (string?)

    'extension_additional_data_company_registration_number' => 'C34893424', // NIF
    'extension_additional_data_passport_number' => 'A67237824', // DNI if is private or individual
    'extension_additional_data_social_security_number' => 'E344543234', // Alternative to passport number if is private or individual

];

$request = new Customer();
$response = $request->APICreateCustomer($data);

print_r($response);