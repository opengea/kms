<html>
<head>
<title><?=$this->current_subdomain?>.<?=$this->current_domain?></title>
<meta name="robots" content="noindex">
<link rel="stylesheet" type="text/css" href="/kms/tpl/extranet/style.css" />
<script language="javascript" type="text/javascript" src="/kms/lib/jQuery/jquery-min.js"></script> 
<script language="javascript" type="text/javascript" src="/kms/lib/jQuery/jquery-ui.min.js"></script> 
<script language="javascript" type="text/javascript" src="/kms/lib/formManager.js"></script>
<script language="javascript" type="text/javascript" src="/kms/lib/session/login.js"></script>
</head>

<body marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" onresize="refreshUI()">
<a href="#" name="top" id="top"></a>

<div id="normal_login">
<table height="100%" width="100%" cellspacing="0" cellpadding="0" border="0">
<tr><td>&nbsp;</td>
<td width="453" valign="top">
<table cellspacing="0" cellpadding="0" width="453">

	<tr><td id="loginTitle"><? print _KMS_CMN_LOGIN_TITLE.$this->current_subdomain?></td></tr>
	<tr><td id="loginForm">
                <? if ($status=="login_failed") { ?> <b><font color='#AA0000'><? print _KMS_CMN_LOGFAIL?></font><br></b> <? }  ?>
                <? print _KMS_CMN_LOGTXT?><br><br>
	
		<form name="form" action="index.php" method="post">
		<table class="formFields" cellspacing="0" width="100%">
			<tr>
				<td class="name"><label for="login_name"><? print _KMS_CMN_USERNAME?></label></td>

				<td><input type="text" name="login" id="login_name" value="" size="20" maxlength="501" tabindex="1"></td>
			</tr>
		</table>

		<table class="formFields" cellspacing="0" width="100%">
			<tr>
				<td class="name"><label for="passwd"><? print _KMS_CMN_PASSWD?> </label></td>

				<td><input type="password" name="passwd" id="passwd" size="20" maxlength="20" tabindex="2"></td>
			</tr>

			
			<tr>
	<td></td>
				<td><select  name="lang" id="lang" onChange="document.location='?lang='+this.value;">	<option value='default' SELECTED><?=_KMS_CMN_USERDEFAULTLANG?></option>
        <option value='ct'>Catal&agrave;</option>
        <option value='en'>English</option>
        <option value='es'>Espa&ntilde;ol</option>
        <option value='eu'>Euskar</option>
	</select>
	</td>
		</tr>
		</table>
			
		<input type="hidden" name="login_name" value="">

	<div class="formButtons">

		<table width="100%" cellspacing="0"><tr>
			<td class="main" id="get_password">

				<input type="hidden" name="login_name" value=""><a href="#" onClick="return get_password_oC(document.forms[2], document.forms[0]);"><? print _KMS_CMN_FORGET?></a>
			</td>
			<td class="misc"><button class="commonButton"  tabindex="3" type="submit"><? print _KMS_CMN_LOGIN?></button></td>
		</tr>
		</table>
		</form>

	</td></tr>

	</table>
	<br><br><br>
	</td><td>&nbsp;</td></tr>
	</table>
</div>

<div id="mobile_login" style="display:none">
<form name="form" action="index.php" method="post">
<table height="100%" width="100%" cellspacing="0" cellpadding="0" border="0">
<tr><td>&nbsp;</td>
<td width="" valign="top">


<table class="formFields" cellspacing="0" width="100%">
<tr>
	<td class="name" colspan="1" style="text-align:center"><h1><?=$this->current_subdomain?> Login</h1></td>
</tr>
</table>
<table class="formFields" cellspacing="0" width="100%">
                        <tr>
                                <td class="name"><label for="login_name"><? print _KMS_CMN_USERNAME?></label></td>
                                <td><input type="text" name="login" id="login_name" value="" size="25" maxlength="501" tabindex="1"></td>
                        </tr>
</table>
<table class="formFields" cellspacing="0" width="100%">
                        <tr>
                                <td class="name"><label for="passwd"><? print _KMS_CMN_PASSWD?> </label></td>
                                <td><input type="password" name="passwd" id="passwd" size="25" maxlength="20" tabindex="2"></td>
                        </tr>
</table>
<table class="formFields" cellspacing="0" width="100%">
			<tr>
			       <td class="name"></td>
	 			<td class="misc" colspan="2"><button class="commonButton"  tabindex="3" type="submit"><? print _KMS_CMN_LOGIN?></button></td>
			</tr>
</table>

</td>
<td>&nbsp;</td>



</td>
<td>&nbsp;</td>

</tr>
</table>
</form>
</div>
</body>
</html>
