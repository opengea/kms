<!--[if IE]>
<!DOCTYPE html>
<![endif]-->
<html>
<head>
<title><?=$this->current_subdomain?>.<?=$this->current_domain?></title>
<meta name="robots" content="noindex">
<link rel="stylesheet" type="text/css" href="/kms/tpl/extranet/style.css" />
<link rel="stylesheet" type="text/css" href="/kms/css/extranet/<?=$this->extranet['theme']?>/main.css"/>
<script language="javascript" type="text/javascript" src="/kms/lib/jQuery/jquery-min.js"></script> 
<script language="javascript" type="text/javascript" src="/kms/lib/jQuery/jquery-ui.min.js"></script> 
<script language="javascript" type="text/javascript" src="/kms/lib/formManager.js"></script>
<script language="javascript" type="text/javascript" src="/kms/lib/session/login.js"></script>
</head>
<?php include "/usr/share/kms/tpl/default/update_browser_notify.php"?>
<body marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" onresize="refreshUI()">
<a href="#" name="top" id="top"></a>
<script language="javascript">
function select_lang(lang) {
	if (lang!="default") document.location='?lang='+lang;
}

function password_lost() {
	if ($('#email').val()=="") $('#forget_error').show(); else {
	document.forms['forget'].action = "/?password-lost=1&email="+$('#email').val();
	document.forms['forget'].submit();
	}
}
</script>
<div id="center">
    <div class="startpage_login_verlauf_short"></div>        
<? //determine national site 
	$site="http://www.intergrid.cat";$email="suport@intergrid.cat";
	if ($_GET['lang']=="es") { $site="http://www.intergrid.es"; $email="soporte@intergrid.es"; }
	
?>

    <div class="startpage_login_logo"><a href="<?=$site?>" target="new"><img src="/kms/css/aqua/img/logos/intergrid-logo-white-200_.png"></a></div>
    <div id="startpage_login_form" class="startpage_login_form">
      

  <div class="box_login"><table id="box_title_0" class="box_title_no_hover"><tbody><tr><td class="title">Control Panel login</td></tr></tbody></table><div class="box_content_login" id="content_0">  
    
  <form id="login" method="post" action="index.php">      <table class="form">
<? if ($status=="login_failed") { ?> <b><font color='#AA0000'><? print _KMS_CMN_LOGFAIL?></font><br></b> <? }  else { echo "<br>"; } ?>
 <? print _KMS_CMN_LOGTXT?><br><br>
        <tbody><tr><td class="label_req"><label for="user"><? print _KMS_CMN_USERNAME?></label></td><td class="element"><input type="text" name="login" id="login_name"></td></tr>
<tr><td class="label_req"><label for="password"><? print _KMS_CMN_PASSWD?></label></td><td class="element"><input type="password" name="passwd" id="passwd"></td></tr>
<tr> <td>&nbsp;</td><td class="element"><select name="lang" id="lang" onChange="select_lang(this.value)">
	<option value='default' SELECTED><?=_KMS_CMN_USERDEFAULTLANG?></option>
        <option value='ct'<? if ($_GET['lang']=="ct") echo " selected"?>>Catal&agrave;</option>
        <option value='en'<? if ($_GET['lang']=="en") echo " selected"?>>English</option>
        <option value='es'<? if ($_GET['lang']=="es") echo " selected"?>>Espa&ntilde;ol</option>
        <option value='eu'<? if ($_GET['lang']=="eu") echo " selected"?>>Euskara</option>
        </select>
<input type="hidden" name="login_name" value="">
</td></tr>

        <tr class="submit_row">
          <td class="">&nbsp;</td>
          <td class="element">
            <input class="button" type="submit" value="<? print _KMS_CMN_LOGIN?>">          </td>
        </tr>
      </tbody></table>                
    </form>
    <noscript>
    &lt;div class="startpage_no_js"&gt;
      To be able to use the Control Panel you have to activate JavaScript in your browser!    &lt;/div&gt;
  </noscript>
  
  </div>

</div>
<div id="footnotes"><b>
      <br><a onclick="$('#password_lost').show();" href="#" style="color:#666"><? print _KMS_CMN_FORGET?></a>
<br><br><?echo _KMS_INTERGRID_ALTA_RECLAM?>
</b>
</div>
<div style="padding-top:15px;display:none" id="password_lost"><form action="/?password-lost=1" id="forget" method="post">Email : <input type="text" name="email" id="email"><input type="button" class="button" value="Recordar" onclick="password_lost();"></form><div id="forget_error" style="padding-top:10px;display:none;color:#a00"><?=_KMS_LOGIN_FORGET_ERROR?></div></div>

<div style="padding-top:150px"><span style="color:#999;line-height:140%"><? /*<img border="0" src="/kms/css/aqua/img/logos/intergrid-logo.png"><br><br>*/?>Intergrid Tecnologies del Coneixement SL. Barcelona, Catalunya<br>
Tel. +34-934426787  Fax. +34-934439639<br><a href="mailto:<?=$email?>"><?=$email?></a> - <a href="<?=$site?>"><?=$site?></a></span></div>
    </div>
<? /*You are using an old version of Internet Explorer. For the best viewing experience please upgrade to Internet Explorer 7 or higher. Or even better, use a more standard browser like <a href="https://www.google.com/chrome">Chrome</a>, <a href="http://www.mozilla.com">Firefox</a> or <a href="http://www.opera.com">Opera</a>.*/?></div>
  </div>

</div>
</body>
</html>
