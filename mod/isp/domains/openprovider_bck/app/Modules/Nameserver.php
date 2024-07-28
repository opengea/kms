<?php

namespace App\Modules;

use App\Api\OP_Request;
use App\Api\OP_API_Exception;

class Nameserver extends authentication
{


    /**
     * Class Domain
     * @package App\Modules
     * @method string searchNsRequest()
     * @method string retrieveNSRequest()
     * @method string modifyNsRequest()
     * @method string deleteNsRequest()
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
     * @param string $domain
     * @param integer $id
     * @return mixed
     * @throws OP_API_Exception
     */
    function searchNsRequest($domain, $id)
    {

        $this->request->setCommand('searchNsRequest')
            ->setArgs(array(
                    'pattern' => $domain,
                    'id' => $id
                )
            );
        $reply = $this->api->process($this->request);
        $response = $reply->getValue();

        return $response;
    }


    /**
     * @param string $nameserver
     * @return array|string
     * @throws OP_API_Exception
     */
    function retrieveNSRequest($nameserver)
    {

        $this->request->setCommand('retrieveNsRequest')
            ->setArgs(array(
                    'name' => $nameserver
                )
            );
        $reply = $this->api->process($this->request);

        if ($reply->getFaultCode() != 0) {
            $response = 'Error [' . $reply->getFaultCode() . '] occurred: ' . $reply->getFaultString();
        } else {
            $response = $reply->getValue();
        }

        return $response;
    }


    /**
     * @param string $nameserver
     * @param string $ip
     * @param string||null $ip6
     * @return mixed
     * @throws OP_API_Exception
     */
    function modifyNsRequest($nameserver, $ip, $ip6 = null)
    {

        $this->request->setCommand('modifyNsRequest')
            ->setArgs(array(
                'name' => $nameserver,
                'ip' => $ip,
                ($ip6) ? ['ip6' => $ip6] : null
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
     * @param string $nameserver
     * @return array
     * @throws OP_API_Exception
     */
    function deleteNsRequest($nameserver)
    {

        $this->request->setCommand('deleteNsRequest')
            ->setArgs(array(
                'name' => $nameserver
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