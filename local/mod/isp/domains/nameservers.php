<?php

    require_once(dirname(__FILE__).'/API.php');
require_once(dirname(__FILE__).'/openprovider/app/Config/cfg.inc.php');
require_once(dirname(__FILE__).'/api/apiwrapper.inc.php');

    // Check if this form should be shown, maybe all data is in config already?
    // In that case, skip this form and continue to registration
    if (($cfg['nameservergroup'] > '') || ($cfg['dnstemplate'] > '')) {
        header('Location: register.php?'.$_SERVER['QUERY_STRING']);
        exit;
    }

    // Check domain; continue to next form only when domain is free
    if ($_POST['submit'] == 'Continue') {
        // Check if a template was selected
        if (isset($_POST['dnstemplate']) && ($_POST['dnstemplate'] > '')) {
            header('Location: register.php?'.$_POST['values'].'&dnstemplate='.$_POST['dnstemplate']);
            exit;
        }
        else {
            $error = 'Choose a template from the list';
        }
    }

    // Retrieve a list of DNS templates
    APIConnect();
    $dnstemplates = APISearchDnsTemplates();

?>

<html>
    <head>
        <title>Domain registration - Nameserver configuration</title>
    </head>
    
    <body>
        <h1>Nameserver configuration</h1>
        <?php
            // Show error if there is one
            if (isset($error)) {
                echo '<strong>'.$error.'</strong>';
            }
        ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="values" value="<?php if (isset($_POST['values'])) echo $_POST['values']; else echo $_SERVER['QUERY_STRING']; ?>" />
            <table>
                <tr>
                    <td>Template to use for nameserver creation</td>
                    <td>
                        <select name="dnstemplate">
                            <option value="">Choose</option>
                            <?php
                                foreach ($dnstemplates as $id => $name) {
                                    echo '<option value="'.$name.'"'.((isset($_POST['dnstemplate']) && ($_POST['dnstemplate'] == $name)) ? ' selected' : '').'>'.$name.'</option>';
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="submit" value="Continue" /></td>
                </tr>
            </table>
        </form>
    </body>
</html>
