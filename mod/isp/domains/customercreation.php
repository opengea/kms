<?php

    require_once(dirname(__FILE__).'/API.php');
require_once(dirname(__FILE__).'/openprovider/app/Config/cfg.inc.php');
require_once(dirname(__FILE__).'/apiwrapper.inc.php');

    // Search if customer exists; if not, request remaining data
    $showFullForm = false;
    if ($_POST['submit'] == 'Search') {
        APIConnect();
        $result = APISearchCustomer($_POST);
        
        if (preg_match('/^[A-Z]{2}\d{6}\-[A-Z]{2}$/', $result)) {
            header('Location: nameservers.php?'.$_POST['values'].'&handle='.$result);
            exit;
        }
        else {
            $showFullForm = true;
        }
    }

    // Create customer; continue to next form only when no errors
    if ($_POST['submit'] == 'Continue') {
        APIConnect();
        $result = APICreateCustomer($_POST);

        if (preg_match('/^[A-Z]{2}\d{6}\-[A-Z]{2}$/', $result)) {
            header('Location: nameservers.php?'.$_POST['values'].'&handle='.$result);
            exit;
        }
        else {
            $error = $result;
            $showFullForm = true;
        }
    }

?>

<html>
    <head>
        <title>Domain registration - Customer data</title>
    </head>
    
    <body>
        <h1>Customer data</h1>
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
                    <td>Company name</td>
                    <td><input type="text" name="companyname" value="<?php if (isset($_POST['companyname'])) echo $_POST['companyname']; ?>" /></td>
                </tr>
                <tr>
                    <td>Name (firstname*, prefix, lastname*)</td>
                    <td>
                        <input type="text" name="firstname" value="<?php if (isset($_POST['firstname'])) echo $_POST['firstname']; ?>" />
                        <input type="text" name="prefix" value="<?php if (isset($_POST['prefix'])) echo $_POST['prefix']; ?>" />
                        <input type="text" name="lastname" value="<?php if (isset($_POST['lastname'])) echo $_POST['lastname']; ?>" />
                    </td>
                </tr>
                <?php if (!$showFullForm) { ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" name="submit" value="Search" /></td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td>Address (street*, number*, suffix)</td>
                        <td>
                            <input type="text" name="street" value="<?php if (isset($_POST['street'])) echo $_POST['street']; ?>" />
                            <input type="text" name="number" value="<?php if (isset($_POST['number'])) echo $_POST['number']; ?>" />
                            <input type="text" name="suffix" value="<?php if (isset($_POST['suffix'])) echo $_POST['suffix']; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>Address (zipcode*, city*, country)</td>
                        <td>
                            <input type="text" name="zipcode" value="<?php if (isset($_POST['zipcode'])) echo $_POST['zipcode']; ?>" />
                            <input type="text" name="city" value="<?php if (isset($_POST['city'])) echo $_POST['city']; ?>" />
                            <select name="country">
                                <option value="">Choose</option>
                                <?php
                                    foreach ($cfg['countries'] as $code => $name) {
                                        echo '<option value="'.$code.'"'.((isset($_POST['country']) && ($_POST['country'] == $code)) ? ' selected' : '').'>'.$name.'</option>';
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Telephone (country code*, region code*, subscriber number*)</td>
                        <td>
                            <input type="text" name="tel1" value="<?php if (isset($_POST['tel1'])) echo $_POST['tel1']; ?>" />
                            <input type="text" name="tel2" value="<?php if (isset($_POST['tel2'])) echo $_POST['tel2']; ?>" />
                            <input type="text" name="tel3" value="<?php if (isset($_POST['tel3'])) echo $_POST['tel3']; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>E-mail address*</td>
                        <td><input type="text" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" /></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" name="submit" value="Continue" /></td>
                    </tr>
                <?php } ?>
            </table>
        </form>
    </body>
</html>
