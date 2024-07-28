<?php

namespace App\Modules;

use App\Api\OP_Request;
use App\Api\OP_API_Exception;

class Domain extends Authentication
{

    /**
     * Class Domain
     * @package App\Modules
     * @method string APICheckDomain()
     * @method string APICreateDomain()
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
     * @param string $domain
     * @param string $extension
     * @return array
     * @throws OP_API_Exception
     */
    function APICheckDomain($domain, $extension)
    {

        $this->request->setCommand('checkDomainRequest')
            ->setArgs(array(
                    'domains' => array(
                        array(
                            'name' => $domain,
                            'extension' => $extension
                        ),
                    )
                )
            );

        $reply = $this->api->process($this->request);
        $response = $reply->getValue();

        return $response;

    }

    /**
     * @param array $data
     * @return array
     * @throws OP_API_Exception
     */
    function APISearchDomain($data)
    {
        $this->request->setCommand('searchDomainRequest')
            ->setArgs(array(
                    'extension' => (isset($data['extension'])) ? $data['extension'] : null,
                    'domainNamePattern' => (isset($data['domain_name_pattern'])) ? $data['domain_name_pattern'] : null,
                    'orderBy' => 'domainName',
                    'order' => 'desc'
                )
            );

        $reply = $this->api->process($this->request);
        $response = $reply->getValue();

        return $response;

    }

    /**
     * @param array $data
     * @return array
     * @throws OP_API_Exception
     */
    function APICreateDomain($data)
    {

        global $cfg;

        // Define some values
        $admin = ($cfg['admin'] == 'owner' ? $data['handle'] : $cfg['admin']);
        $tech = ($cfg['tech'] == 'admin' ? $admin : $cfg['tech']);

        // Retrieve minimum registration period
        $this->request->setCommand('retrieveExtensionRequest')
            ->setArgs(array(
                'name' => $data['extension'],
                'withPrices' => 1,
            ));
        $reply = $this->api->process($this->request);
        $response = $reply->getValue();
        $period = $response['prices']['minPeriod'];

        if ($cfg['nameservergroup'] > '' && $cfg['nameservergroup'] != 'dns-openprovider') {
            $nsgroup = $cfg['nameservergroup'];
            $template = '';
        } else {
            $nsgroup = 'dns-openprovider';
            if ($cfg['dnstemplate'] > '') {
                $template = $cfg['dnstemplate'];
            } else {
                $template = $data['dnstemplate'];
            }
        }

        // Check if local presence of Openprovider should be used
        $useLocalPresence = false;
        if (in_array($data['extension'], $cfg['useLocalPresence'])) {
            // Retrieve customer's country
            $this->request->setCommand('retrieveCustomerRequest')
                ->setAuth(array('username' => $cfg['username'], 'password' => $cfg['password']))
                ->setArgs(array(
                    'handle' => $data['handle'],
                ));
            $reply = $this->api->process($this->request);
            $response = $reply->getValue();
            $country = $response['address']['country'];

            switch ($data['extension']) {
                case 'de' :
                    if ($country != 'DE') {
                        $useLocalPresence = true;
                    }
                    break;
                case 'fr' :
                    if ($country != 'FR') {
                        $useLocalPresence = true;
                    }
                    break;
            }
        }

        $this->request->setCommand('createDomainRequest')
            ->setArgs(array(
                'ownerHandle' => $data['owner_handle'], // 'SR003891-NL' (string)
                'adminHandle' => $data['admin_handle'], // 'SR003891-NL' (string)
                'techHandle' => $data['tech_handle'], // 'SR003891-NL' (string)
                'billingHandle' => $data['billing_handle'], // 'SR003891-NL' (string)
                'domain' => array(
                    'name' => $data['domain'], // 'intergrid' (string)
                    'extension' => $data['extension'], // 'cat' (string)
                ),
                'period' => $data['period'], // '1' (integer)
                'nsGroup' => $data['ns_group'], // 'dns-intergrid' (string),
                'nsTemplateName' => $data['ns_template_name'], //'Intergrid NS template name'
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
     * @param string $domain
     * @param string $extension
     * @param array $new_nameservers
     * @return array
     * @throws OP_API_Exception
     */
    function APIModifyDomainNameserver($domain, $extension, $new_nameservers)
    {
        $this->request->setCommand('modifyDomainRequest')
            ->setArgs(array(
                    'domain' => array(
                        'name' => $domain,
                        'extension' => $extension
                    ),
                    'nameServers'  => $new_nameservers
                )
            );

        $reply = $this->api->process($this->request);
        $response = $reply->getValue();

        return $response;
    }

    /**
     * @param string $domain
     * @param string $extension
     * @param string $status
     * @return array
     * @throws OP_API_Exception
     */
    function APIModifyDomainAutorenew($domain, $extension, $status)
    {
        $this->request->setCommand('modifyDomainRequest')
            ->setArgs(array(
                    'domain' => array(
                        'name' => $domain,
                        'extension' => $extension
                    ),
                    'autorenew'  => $status
                )
            );

        $reply = $this->api->process($this->request);
        $response = $reply->getValue();

        return $response;
    }

    /**
     * @param string $domain
     * @param string $extension
     * @param boolean $isLocked
     * @return array
     * @throws OP_API_Exception
     */
    function APIModifyDomainLock($domain, $extension, $isLocked)
    {
        $this->request->setCommand('modifyDomainRequest')
            ->setArgs(array(
                    'domain' => array(
                        'name' => $domain,
                        'extension' => $extension
                    ),
                    'isLocked'  => $isLocked
                )
            );

        $reply = $this->api->process($this->request);
        $response = $reply->getValue();

        return $response;
    }

    /**
     * @param string $domain
     * @param string $extension
     * @param boolean $isPrivateWhois
     * @return array
     * @throws OP_API_Exception
     */
    function APIModifyDomainPrivateWhois($domain, $extension, $isPrivateWhois)
    {
        $this->request->setCommand('modifyDomainRequest')
            ->setArgs(array(
                    'domain' => array(
                        'name' => $domain,
                        'extension' => $extension
                    ),
                    'isPrivateWhoisEnabled'  => $isPrivateWhois
                )
            );

        $reply = $this->api->process($this->request);
        $response = $reply->getValue();

        return $response;
    }
}