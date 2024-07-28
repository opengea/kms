<?php

namespace App\Modules;

use App\Api\OP_Request;
use App\Api\OP_API_Exception;

class EmailTemplates extends authentication
{


    /**
     * Class Domain
     * @package App\Modules
     * @method string searchEmailTemplateRequest()
     * @method string createEmailTemplateRequest()
     * @method string modifyEmailTemplateRequest()
     * @method string deleteEmailTemplateRequest()
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
     * @param array $data
     * @return mixed
     * @throws OP_API_Exception
     */
    function searchEmailTemplateRequest($data)
    {

        $this->request->setCommand('searchEmailTemplateRequest')
            ->setArgs(array(
                    'id' => (isset($data['id'])) ? $data['id'] : null,
                    'name' => (isset($data['name'])) ? $data['name'] : null,
                    'group' => (isset($data['group'])) ? $data['group'] : null,
                    'tags' => (isset($data['tags'])) ? $data['tags'] : null
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
     * @param array $data
     * @return array|string
     * @throws OP_API_Exception
     */
    function createEmailTemplateRequest($data)
    {

        $this->request->setCommand('createEmailTemplateRequest')
            ->setArgs([
                'name' => $data['name'], // (string)
                'group' => $data['group'], // (string)
                'isDefault' => $data['is_default'], // true - false,
                'isActive' => $data['is_active'], // true - false ,
                'locale' => $data['locale'], // (string) ['ca_CAT'], ['en_EN'] ['es_ES'],
                'fields' => [
                    [
                        'name' => 'senderEmail',
                        'value' => $data['sender_email'], // (string) 'registres@intergrid.cat',
                    ],
                    [
                        'name' => 'confirmUrl',
                        'value' => $data['confirm_url'], // (string) 'http://icann-verification.registrar.eu/?email=%%email%%&authCode=%%authCode%%',
                    ],
                    [
                        'name' => 'resellerName',
                        'value' => $data['reseller_name'], // (string) 'Intergrid SL',
                    ],
                    [
                        'name' => 'subject',
                        'value' => $data['subject'], // (string) 'Email verification',
                    ],
                    [
                        'name' => 'body',
                        'value' => $data['body'], // (string) '%%confirmUrl%% and %%respondDate%%',
                    ],
                    [
                        'name' => 'reminderSubject',
                        'value' => $data['reminder_subject'],// (string) 'Email verification reminder',
                    ],
                    [
                        'name' => 'reminderBody',
                        'value' => $data['reminder_body'], // (string) '%%confirmUrl%% and %%respondDate%%',
                    ],
                ],
            ]);

        $reply = $this->api->process($this->request);

        if ($reply->getFaultCode() != 0) {
            $response = 'Error [' . $reply->getFaultCode() . '] occurred: ' . $reply->getFaultString();
        } else {
            $response = $reply->getValue();
        }

        return $response;
    }


    /**
     * @param array $data
     * @return mixed
     * @throws OP_API_Exception
     */
    function modifyEmailTemplateRequest($data)
    {

        $this->request->setCommand('modifyEmailTemplateRequest')
            ->setArgs(array(
                'id' => $data['id'], // (integer)
                'name' => $data['name'], // (string)
                'isDefault' => $data['is_default'], // true - false,
                'isActive' => $data['is_active'], // true - false ,
                'locale' => $data['locale'], // (string) ['ca_CAT'], ['en_EN'] ['es_ES'],
                'fields' => [
                    [
                        'name' => 'senderEmail',
                        'value' => $data['sender_email'], // (string) 'registres@intergrid.cat',
                    ],
                    [
                        'name' => 'confirmUrl',
                        'value' => $data['confirm_url'], // (string) 'http://icann-verification.registrar.eu/?email=%%email%%&authCode=%%authCode%%',
                    ],
                    [
                        'name' => 'resellerName',
                        'value' => $data['reseller_name'], // (string) 'Intergrid SL',
                    ],
                    [
                        'name' => 'subject',
                        'value' => $data['subject'], // (string) 'Email verification',
                    ],
                    [
                        'name' => 'body',
                        'value' => $data['body'], // (string) '%%confirmUrl%% and %%respondDate%%',
                    ],
                    [
                        'name' => 'reminderSubject',
                        'value' => $data['reminder_subject'],// (string) 'Email verification reminder',
                    ],
                    [
                        'name' => 'reminderBody',
                        'value' => $data['reminder_body'], // (string) '%%confirmUrl%% and %%respondDate%%',
                    ],
                ],
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
     * @param integer $emailTemplate
     * @return array
     * @throws OP_API_Exception
     */
    function deleteEmailTemplateRequest($emailTemplate)
    {

        $this->request->setCommand('deleteNsRequest')
            ->setArgs([
                'id' => $emailTemplate, // (integer)
            ]);
        $reply = $this->api->process($this->request);

        if ($reply->getFaultCode() != 0) {
            $response = 'Error [' . $reply->getFaultCode() . '] occurred: ' . $reply->getFaultString();
        } else {
            $response = $reply->getValue();
        }

        return $response;
    }

}