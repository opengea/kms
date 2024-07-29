<?php

namespace App\Modules;

use App\Api\OP_API_Exception;
use App\Api\OP_Request;

class Customer extends Authentication
{

    /**
     * Class Domain
     * @package App\Modules
     * @method array APISearchCustomer()
     * @method array APICreateCustomer()
     * @method array APIModifyCustomer()
     * @method array APIDeleteCustomer()
     */

    private $cfg;
    private $api;
    private $request;

    /**
     * domain constructor.
     * @param Authentication $authentication
     */
    public function __construct()
    {

        global $cfg;
        $authentication = new Authentication();
        $this->api = $authentication->setApi();
        $this->cfg = $cfg;

        $this->request = new OP_Request();
        $this->request->setAuth(array('username' => $this->cfg['username'], 'password' => $this->cfg['password']));
    }


    /**
     * @param array $data
     * @return mixed
     * @throws OP_API_Exception
     */
    function APISearchCustomer($data)
    {

        $this->request->setCommand('searchCustomerRequest')
            ->setArgs(array(
                'emailPattern' => (isset($data['email_pattern'])) ? '*'.$data['email_pattern'].'*' : null, // (string) 'email'
                'lastNamePattern' => (isset($data['last_name_pattern'])) ? '*'.$data['last_name_pattern'].'*' : null , // (string) 'lastname'
                'companyNamePattern' => (isset($data['company_name_pattern'])) ? '*'.$data['company_name_pattern'].'*' : null // (string) 'nombre'
            ));

        $reply = $this->api->process($this->request);

        $response = $reply->getValue();
        return $response;

    }


    /**
     * @param array $data
     * @return string (Open Provider Handle of new customer)
     * @throws OP_API_Exception
     */
    function APICreateCustomer($data)
    {

        $this->request->setCommand('createCustomerRequest')
            ->setArgs(array(
                'name' => array(
                    'initials' => $data['initials'],
                    'firstName' => $data['first_name'],
                    'prefix' => $data['prefix'],
                    'lastName' => $data['last_name'],
                ),
                'gender' => $data['gender'], // 'M' Male - 'F' Female
                'phone' => array(
                    'countryCode' => $data['phone_country_code'], // +34 (Spain)
                    'areaCode' => $data['phone_area_code'], // 93 (Barcelona)
                    'subscriberNumber' => $data['phone_subscriber_number'] // 4426787 (Intergrid)
                ),
                'fax' => array(
                    'countryCode' => $data['fax_country_code'],
                    'areaCode' => $data['fax_area_code'],
                    'subscriberNumber' => $data['fax_subscriber_number']
                ),
                'address' => array(
                    'street' => $data['street'], // (string)
                    'number' => $data['street_number'], // (string)
                    'suffix' => $data['street_suffix'], // Door, Stair, etc (integer)
                    'zipcode' => $data['zip_code'], // (string)
                    'city' => $data['city'], // (string)
                    'state' => $data['state'], // (string)
                    'country' => $data['country'], // (String) 2 Letters Code
                ),
                'email' => $data['email'], // (string)
                'locale' => $data['locale'], // es_ES (string) ca_CAT (string) eu_EUS (string) en_GB (string)
                'additionalData' => array(
                    'birthCity' => $data['additional_birth_city'], // (String)
                    'birthDate' => $data['additional_birth_date'], // 1975-01-01 (string)
                    'socialSecurityNumber' => $data['additional_social_security_number'], // (string?)
                    'companyRegistrationNumber' => $data['additional_company_registration_number'] // (string?)
                ),
                'extensionAdditionalData' => array(
                    array(
                        'name' => 'es',
                        'data' => array(
                            'companyRegistrationNumber' => $data['extension_additional_data_company_registration_number'], // NIF
                            'passportNumber' => $data['extension_additional_data_passport_number'], // DNI if is private or individual
                            'socialSecurityNumber' => $data['extension_additional_data_social_security_number'], // Alternative to passport number if is private or individual
                        )
                    ),
                ),
            ));

        $reply = $this->api->process($this->request);

        $response = $reply->getValue();

        $handle = $response['handle'];

        if (preg_match('/^[A-Z]{2}\d{6}\-[A-Z]{2}$/', $handle)) {

            return $handle;

        } else {

            $code = $reply->getFaultCode();
            $error = $reply->getFaultString();
            return 'Error ' . $code . ': ' . $error;

        }
    }


    /**
     * @param array $data
     * @return array
     * @throws OP_API_Exception
     */
    function APIModifyCustomer($data)
    {

        $this->request->setCommand('modifyCustomerRequest')
            ->setArgs(array(
                'handle' => $data['handle'], // Customer Handle

                'phone' => array(
                    'countryCode' => $data['phone_country_code'], // +34 (Spain)
                    'areaCode' => $data['phone_area_code'], // 93 (Barcelona)
                    'subscriberNumber' => $data['phone_subscriber_number'] // 4426787 (Intergrid)
                ),

                'fax' => array(
                    'countryCode' => $data['fax_country_code'],
                    'areaCode' => $data['fax_area_code'],
                    'subscriberNumber' => $data['fax_subscriber_number']
                ),

                'address' => array(
                    'street' => $data['street'], // (string)
                    'number' => $data['street_number'], // (string)
                    'suffix' => $data['street_suffix'], // Door, Stair, etc (integer)
                    'zipcode' => $data['zip_code'], // (string)
                    'city' => $data['city'], // (string)
                    'state' => $data['state'], // (string)
                    'country' => $data['country'], // (String) 2 Letters Code
                ),

                'email' => $data['email'], // (string)

                'additionalData' => array(
                    'birthCity' => $data['additional_birth_city'], // (String)
                    'birthDate' => $data['additional_birth_date'], // 1975-01-01 (string)
                    'socialSecurityNumber' => $data['additional_social_security_number'], // (string?)
                    'companyRegistrationNumber' => $data['additional_company_registration_number'] // (string?)
                ),
                'extensionAdditionalData' => array(
                    'extensionAdditionalData' => array(
                        array(
                            'name' => 'es',
                            'data' => array(
                                'companyRegistrationNumber' => $data['extension_additional_data_company_registration_number'], // NIF
                                'passportNumber' => $data['extension_additional_data_passport_number'], // DNI if is private or individual
                                'socialSecurityNumber' => $data['extension_additional_data_social_security_number'], // Alternative to passport number if is private or individual
                            )
                        ),
                    ),
                ),
            ));

        $reply = $this->api->process($this->request);
        $code = $reply->getFaultCode();
        if ($code == 0) {
            return array(
                'result' => true,
            );
        } else {
            $message = $reply->getValue();
            $error = $reply->getFaultString();
            return array(
                'result' => false,
                'error' => 'Error ' . $code . ': ' . $error . ($message ? ' (' . $message . ')' : ''),
            );
        }

    }

    /**
     * @param array $data
     * @return array
     * @throws OP_API_Exception
     */
    function APIDeleteCustomer($data)
    {

        $this->request->setCommand('modifyCustomerRequest')
            ->setArgs(array(
                'handle' => $data['handle'], // Customer Handle
            ));

        $reply = $this->api->process($this->request);
        $code = $reply->getFaultCode();
        if ($code == 0) {
            return array(
                'result' => true,
            );
        } else {
            $message = $reply->getValue();
            $error = $reply->getFaultString();
            return array(
                'result' => false,
                'error' => 'Error ' . $code . ': ' . $error . ($message ? ' (' . $message . ')' : ''),
            );
        }
    }

}