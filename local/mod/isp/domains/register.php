<?php

    require_once(dirname(__FILE__).'/API.php');
    require_once(dirname(__FILE__).'/openprovider/app/Config/cfg.inc.php');
    require_once(dirname(__FILE__).'/api/apiwrapper.inc.php');

    APIConnect();
    $result = APIRegisterDomain($_GET);

    if ($result['result'] == true) {
        $message = 'Domain registration requested successfully';
        $error   = '';
    }
    else {
        $message = 'Domain registration failed';
        $error   = $result['error'];
    }

?>

<html>
    <head>
        <title>Domain registration - Result</title>
    </head>
    
    <body>
        <h1>Result</h1>
        <?php
            echo '<strong>'.$message.'<br /><br />'.$error.'</strong>';
        ?>
    </body>
</html>
