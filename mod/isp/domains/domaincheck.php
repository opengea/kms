<?php

    require_once(dirname(__FILE__).'/API.php');
require_once(dirname(__FILE__).'/openprovider/app/Config/cfg.inc.php');
require_once(dirname(__FILE__).'/api/apiwrapper.inc.php');

    // Check domain; continue to next form only when domain is free
    if ($_POST['submit'] == 'Check') {
        APIConnect();
        if (APICheckDomain($_POST)) {
	    $register_url='customercreation.php?domain='.$_POST['domain'].'&extension='.$_POST['extension'];
	    $msg = "<span style='color:#090'>Domain name available. <a href='{$register_url}'>Click here to register</a></span>";
        }
        else {
            $msg = "<span style='color:#900'>Domain is not available for registration</span>";
        }
    }

?>

<html>
    <head>
        <title>Domain registration - Check availability</title>
    </head>
    
    <body>
        <h1>Check availability domain</h1>
        <?php
            // Show msg if there is one
            if (isset($msg)) {
                echo '<strong>'.$msg.'</strong>';
            }
        ?><br><br>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <table>
                <tr>
                    <td>www.</td>
                    <td><input type="text" name="domain" value="<?php if (isset($_POST['domain'])) echo $_POST['domain']; ?>"/></td>
                    <td>
                        <select name="extension">
                            <?php
                                foreach ($cfg['extensions'] as $ext) {
                                    echo '<option value="'.$ext.'"'.((isset($_POST['extension']) && ($_POST['extension'] == $ext)) ? ' selected' : '').'>.'.$ext.'</option>';
                                }
                            ?>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="submit" value="Check" /></td>
                </tr>
            </table>
        </form>
    </body>
</html>
