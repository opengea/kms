<?php

    $api = NULL;

    function APIConnect($cfg,$debug = false)
    {
//        global $cfg, $api;
        $api = new OP_API($cfg['api']);
        if ($debug) {
            $api->setDebug(1);
        }
	return $api;
    }
    
    function APICheckDomain($data,$cfg,$api)
    {
        //global $cfg, $api;
//	global $api;
        $request = new OP_Request;
        $request->setCommand('checkDomainRequest')
            ->setAuth(array('username' => $cfg['username'], 'password' => $cfg['password']))
            ->setArgs(array(
                'domains' => array(
                    array(
                        'name' => $data['domain'],
                        'extension' => $data['extension'],
                    ),
                ),
            ));

        $reply = $api->process($request);
	

        $response = $reply->getValue();
        $availability = $response[0]['status'];

        return ($availability == 'free' ? true : false);
    }

    // Checks if a customer already exists for this companyname + name
    function APISearchCustomer($data)
    {
        global $cfg, $api;

        $request = new OP_Request;
        $request->setCommand('searchCustomerRequest')
            ->setAuth(array('username' => $cfg['username'], 'password' => $cfg['password']))
            ->setArgs(array(
                'companyName' => $data['companyname'],
                'name' => array(
                    'firstName' => $data['firstname'],
                    'prefix' => $data['prefix'],
                    'lastName' => $data['lastname'],
                ),
        ));
        $reply = $api->process($request);
        $response = $reply->getValue();
        
        // Walk through results to see if it is a 100% match
        foreach ($response['results'] as $result) {
            if (
                (strtolower($result['companyName'])  == strtolower($data['companyname']))
                && (strtolower($result['name']['firstName']) == strtolower($data['firstname']))
                && (strtolower($result['name']['prefix'])    == strtolower($data['prefix']))
                && (strtolower($result['name']['lastName'])  == strtolower($data['lastname']))
            ) {
                return $result['handle'];
            }
        }

        return false;
    }

    function APICreateCustomer($data)
    {
        global $cfg, $api;

        // Set some default values
        $initials = substr($data['firstname'], 0, 1).'.';
        $gender   = 'M';
        if (substr($data['tel1'], 0, 1) != '+') {
            $data['tel1'] = '+'.$data['tel1'];
        }

        $request = new OP_Request;
        $request->setCommand('createCustomerRequest')
            ->setAuth(array('username' => $cfg['username'], 'password' => $cfg['password']))
            ->setArgs(array(
                'companyName' => $data['companyname'],
                'name' => array(
                    'initials' => $initials,
                    'firstName' => $data['firstname'],
                    'prefix' => $data['prefix'],
                    'lastName' => $data['lastname'],
                ),
                'gender' => $gender,
                'phone' => array(
                    'countryCode' => $data['tel1'],
                    'areaCode' => $data['tel2'],
                    'subscriberNumber' => $data['tel3'],
                ),
                'address' => array(
                    'street' => $data['street'],
                    'number' => $data['number'],
                    'suffix' => $data['suffix'],
                    'zipcode' => $data['zipcode'],
                    'city' => $data['city'],
                    'country' => $data['country'],
                ),
                'email' => $data['email'],
        ));
        $reply = $api->process($request);
        $response = $reply->getValue();
        $handle = $response['handle'];

        if (preg_match('/^[A-Z]{2}\d{6}\-[A-Z]{2}$/', $handle)) {
            return $handle;
        }
        else {
            $code  = $reply->getFaultCode();
            $error = $reply->getFaultString();

            return 'Error '.$code.': '.$error;
        }
    }

    function APISearchDnsTemplates()
    {
        global $cfg, $api;

        $request = new OP_Request;
        $request->setCommand('searchTemplateDnsRequest')
            ->setAuth(array('username' => $cfg['username'], 'password' => $cfg['password']))
            ->setArgs(array(
            ));
        $reply = $api->process($request);
        $response = $reply->getValue();
        $dnstemplates = $response['results'];
        
        $returnvalue = array();
        if (is_array($dnstemplates)) {
            foreach ($dnstemplates as $tmpl) {
                $returnvalue[$tmpl['id']] = $tmpl['name'];
            }
        }

        return $returnvalue;
    }

    function APIRegisterDomain($data)
    {
        global $cfg, $api;

        // Define some values
        $admin    = ($cfg['admin'] == 'owner' ? $data['handle'] : $cfg['admin']);
        $tech     = ($cfg['tech']  == 'admin' ? $admin : $cfg['tech']);
        
        // Retrieve minimum registration period
        $request = new OP_Request;
        $request->setCommand('retrieveExtensionRequest')
          ->setAuth(array('username' => $cfg['username'], 'password' => $cfg['password']))
          ->setArgs(array(
            'name' => $data['extension'],
            'withPrices' => 1,
          ));
        $reply = $api->process($request);
        $response = $reply->getValue();
        $period = $response['prices']['minPeriod'];
        
        if ($cfg['nameservergroup'] > '' && $cfg['nameservergroup'] != 'dns-openprovider') {
            $nsgroup  = $cfg['nameservergroup'];
            $template = '';
        }
        else {
            $nsgroup = 'dns-openprovider';
            if ($cfg['dnstemplate'] > '') {
                $template = $cfg['dnstemplate'];
            }
            else {
                $template = $data['dnstemplate'];
            }
        }

        // Check if local presence of Openprovider should be used
        $useLocalPresence = false;
        if (in_array($data['extension'], $cfg['useLocalPresence'])) {
            // Retrieve customer's country
            $request = new OP_Request;
            $request->setCommand('retrieveCustomerRequest')
                ->setAuth(array('username' => $cfg['username'], 'password' => $cfg['password']))
                ->setArgs(array(
                    'handle' => $data['handle'],
            ));
            $reply = $api->process($request);
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

        $request = new OP_Request;
        $request->setCommand('createDomainRequest')
          ->setAuth(array('username' => $cfg['username'], 'password' => $cfg['password']))
          ->setArgs(array(
            'ownerHandle' => $data['handle'],
            'adminHandle' => $admin,
            'techHandle' => $tech,
            'domain' => array(
              'name' => $data['domain'],
              'extension' => $data['extension'],
            ),
            'period' => $period,
            'nsGroup' => $nsgroup,
            'nsTemplateName' => $template,
            'useDomicile' => $useLocalPresence,
          ));
        $reply = $api->process($request);

        $code = $reply->getFaultCode();
        if ($code == 0) {
            return array(
                'result' => true,
            );
        }
        else {
            $message = $reply->getValue();
            $error   = $reply->getFaultString();
            return array(
                'result' => false,
                'error'  => 'Error '.$code.': '.$error.($message ? ' ('.$message.')' : ''),
            );
        }
    }

?>
