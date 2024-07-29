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
<script language="javascript" type="text/javascript" src="/kms/lib/checkIE.js"></script>
</head>

<body marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" onresize="refreshUI()">
<script language="javascript">

</script>

<a href="#" name="top" id="top"></a>
<div id="center">
<? //determine national site 
	$site="http://www.intergrid.cat";$email="suport@intergrid.cat";
	if ($_GET['lang']=="es") { $site="http://www.intergrid.es"; $email="soporte@intergrid.es"; }
	
?>

    <div class="startpage_login_logo">extranet</div>
    <div id="startpage_login_form" class="startpage_login_form">
      

  <div class="box_login"><table id="box_title_0" class="box_title_no_hover"><tbody><tr><td class="title"><?=ucfirst($this->current_subdomain)?>.<?=$this->current_domain?></td></tr></tbody></table><div class="box_content_login" id="content_0">  
    
  <form id="login" method="post" action="index.php">
<? if ($status=="login_failed") { ?><script>nonAnimate();</script> <b><font color='#AA0000'><? print _KMS_CMN_LOGFAIL?></font><br></b> <? }  else { echo "<br>"; } ?>
 <label class="login"><b><? print _KMS_CMN_USERNAME?></b></label><br><input type="text" name="login" id="login_name"><br>
 <label class="login"><b><? print _KMS_CMN_PASSWD?></b></label><br><input type="password" name="passwd" id="passwd"><br>
	<input type="hidden" name="login_name" value=""><br>
            <input style="" class="button" type="submit" value="<? print _KMS_CMN_LOGIN?>">
    </form>
    <noscript>
    &lt;div class="startpage_no_js"&gt;
      To be able to use the Extranet you have to activate JavaScript in your browser!    &lt;/div&gt;
  </noscript>
  
  </div>

</div>
<div class="extra_login"><a onclick="password_lost();" href="#"><? print _KMS_CMN_FORGET?></a>
</div>

    </div>
  </div>
</div>

</div>
<div id="powered">Powered by <a style="margin:0px;top:0px" href="http://www.intergrid.cat">Intergrid KMS 2.0</a></div>

</body>
</html>
