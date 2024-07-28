<?php

namespace App\Modules;

use App\Api\OP_Request;
use App\Api\OP_API_Exception;

class Email extends authentication
{


    /**
     * Class Domain
     * @package App\Modules
     * @method string startCustomerEmailVerificationRequest()
     * @method string restartCustomerEmailVerificationRequest()
     * @method string searchEmailVerificationDomainRequest()
     */

    private $cfg;
    private $api;
    private $request;

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
     * @param string $email
     * @return mixed
     * @throws OP_API_Exception
     */
    function startCustomerEmailVerificationRequest($email)
    {

        $this->request->setCommand('searchEmailTemplateRequest')
            ->setArgs(array(
                'email' => $email, // (string) 'validatemail@gmail.com'
            ));

        $reply = $this->api->process($this->request);
        if ($reply->getFaultCode() != 0) {
            $response = 'Error [' . $reply->getFaultCode() . '] occurred: ' . $reply->getFaultString();
        } else {
            $response = $reply->getValue();
        }

        return $response;
    }

    /**
     * @param string $email
     * @return mixed
     * @throws OP_API_Exception
     */
    function restartCustomerEmailVerificationRequest($email)
    {

        $this->request->setCommand('restartCustomerEmailVerificationRequest')
            ->setArgs(array(
                'email' => $email, // (string) 'validatemail@gmail.com'
            ));

        $reply = $this->api->process($this->request);

        if ($reply->getFaultCode() != 0) {
            $response = 'Error [' . $reply->getFaultCode() . '] occurred: ' . $reply->getFaultString();
        } else {
            $response = $reply->getValue();
        }

        return $response;
    }


    /**
     * @param string $email
     * @return mixed
     * @throws OP_API_Exception
     */
    function searchEmailVerificationDomainRequest($email)
    {

        $this->request->setCommand('searchEmailVerificationDomainRequest')
            ->setArgs(array(
                'email' => $email, // (string) 'validatemail@gmail.com'
            ));
        $reply = $this->api->process($this->request);

        if ($reply->getFaultCode() != 0) {
            $response = 'Error [' . $reply->getFaultCode() . '] occurred: ' . $reply->getFaultString();
        } else {
            $response = $reply->getValue();
        }

        return $response;
    }

}