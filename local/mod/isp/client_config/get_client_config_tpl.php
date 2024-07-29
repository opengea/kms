
<style type="text/css">
.container {
	margin: 0px;
	height: auto;
	width: 600px;
	font-family: Arial, Helvetica, sans-serif;
        font-size: 13px;
        font-weight: normal;
}
.section {
	background-color: #E6F3FF;
	position: relative; padding: 8px;
	margin-bottom: 20px;
}
.section_header {
	font-size: 16px;
	font-weight: bold;
	text-decoration: none;
	height: 55px;
	text-align: left;
	padding-top: 10px;
	padding-right: 15px;
	padding-bottom: 3px;
	padding-left: 15px;
	background-color: #9CF;
	color: #006;
	vertical-align: text-bottom;
	margin: 12px;
}
.section_content {
	padding-top: 10px;
	padding-right: 15px;
	padding-bottom: 10px;
	padding-left: 15px;
	font-size: 13px;
	color: #333;
	text-decoration: none;
	white-space: initial;
}
.header_icon {
	padding-top: 0px;
	padding-right: 15px;
	padding-bottom: 5px;
	padding-left: 5px;
	float: left;
}
.footer_mail {
	font-size: 12px;
	color: #666;
	text-align: justify;
	padding-top: 20px;
	padding-right: 5px;
	padding-left: 5px;
}
.presentation {
	font-size: 14px;
	color: #333;
	text-align: left;
	margin-bottom: 20px;
}


div.top-left-corner, div.bottom-left-corner,
div.top-right-corner, div.bottom-right-corner
{position:absolute; width:0px; height:0px;
background-color:#FFF; overflow:hidden;}
div.top-left-inside, div.bottom-left-inside,
div.top-right-inside, div.bottom-right-inside
{position:relative; font-size:150px; font-family:Arial;color:#E6F3FF; line-height: 40px;}
div.top-left-corner { top:0px; left:0px; }
div.bottom-left-corner {bottom:0px; left:0px;}
div.top-right-corner {top:0px; right:0px;}
div.bottom-right-corner {bottom: 0px; right:0px;}
div.top-left-inside {left:-8px;}
div.bottom-left-inside {left:-8px; top:-17px;}
div.top-right-inside {left:-25px;}
div.bottom-right-inside {left:-25px; top:-17px;}


.warning {
	background: #b4e3fb;
	height: auto;
	padding-bottom: 10px;
	margin-bottom: 10px;
	padding: 10px;
}
.warning_icon: {
	float: left;
	padding-bottom: 5px;
}

.warning_content {
	float:left;
}
.email_table {
	border-style: solid;
	border-color: #B4E3FB;
	border: 2px;
	width: 100%;
	font-size: 11px;
	border-collapse:collapse;
}

.email_table_header {
	background: #B4E3FB;

}

.email_table td {
        padding:3px;
}

</style>
<?php 
var_dump($_POST);
$base_img ="http://intranet.intergrid.cat/kms/css/aqua/mod/isp";
?>
<div class="container">

<div class="presentation"><?php echo _KMS_MAIL_SENDCONFIG_SALUTATION; ?><br><br>
<?php echo _KMS_MAIL_SENDCONFIG_HEAD; ?>
</div>

<? if($_GET['client_data_check']=="on") { ?>
<div class="section">
<div class="section_header">
<div class="header_icon"><img src="<?php echo $base_img;?>/client_account48px.png"></div><?php echo _KMS_MAIL_SENDCONFIG_CLIENT_DATA ?>
</div>
<div class="section_content">
<?php echo _KMS_MAIL_SENDCONFIG_CLIENT_NAME.": ".htmlentities(utf8_decode($nomempresa)); ?><br>
<?php if ($provider!="") echo _KMS_PROVIDER_NAME.": ".htmlentities($provider); ?><br>
<?php echo _KMS_GL_ADMINEMAIL.": ".$emailempresa; ?>
</div> <!-- end div section_content -->
<div class="section_footer"></div>

</div> <!-- end div section -->

<? } ?>

<? if($_GET['control_panel_check']=="on") { ?>

<div class="section">
<div class="section_header">
<div class="header_icon"><img src="<?php echo $base_img;?>/controlpanel48px.png"></div><?php echo _KMS_SERVICES_CP; ?>
<span style="font-size:12px;color:#444;font-weight:normal"><br><?php echo _KMS_MAIL_SENDCONFIG_CP_HELPTIP; ?></span>

</div>
<div class="section_content">
<a href="http://control.intergridnetwork.net">http://control.intergridnetwork.net</a> (<?=_KMS_OR?> <a href="http://control.<?=$_GET['dom']?>">control.<?=$_GET['dom']?></a>)<br> 
<?php echo _KMS_GL_USERNAME.": ".$usuariplesk; ?><br>
<?php echo _KMS_GL_PASSWORD.": ".$passwordplesk; ?>
</div>
<div class="section_footer">
</div>
</div>

<? } ?>

<? if($_GET['ftp_check']=="on") { ?>
<div class="section">
<div class="section_header">
<div class="header_icon"><img src="<?php echo $base_img;?>/ftpaccount48px.png"></div><?php echo _KMS_SERVICES_FTP; ?>
<span style="font-size:12px;color:#444;font-weight:normal"><br><?php echo _KMS_MAIL_SENDCONFIG_FTP_HELPTIP; ?></span>


</div>
<div class="section_content">
<?php echo _KMS_GL_SERVER.": ftp.".$_GET['dom']; ?> (<?=$webserver['ip']?>)<br>
<?php echo _KMS_GL_USERNAME.": ".$usuari; ?><br>
<?php echo _KMS_GL_PASSWORD.": ".$passwd; ?>
</div>
<div class="section_footer">
</div>
</div>
<? } ?>

<? if($_GET['email_accounts_check']=="on") { ?>

<div class="section">
<div class="section_header">
<div class="header_icon"><img src="<?php echo $base_img;?>/email48px.png"></div><?php echo _KMS_SERVICES_MAIL; ?>
<span style="font-size:12px;color:#444;font-weight:normal"><br><?php echo _KMS_MAIL_SENDCONFIG_MAIL_HELPTIP; ?></span>


</div>
<div class="section_content">
<div class="warning">
<div class="warning_icon"><img src="<?php echo $base_img;?>/warning32px.png"></div>
<br><?php echo $helpcenter; ?><br>
<br><?php echo _KMS_SERVICES_MAIL_CHANGEPASSWORD; ?>
</div>
<div style="clear: both;"></div>
<?=_KMS_ISP_MAILBOXES_ACCOUNTTYPE?><br>
<?php echo _KMS_GL_POPIMAP_MAILSERVER.":<b> mail.".$_GET['dom'];?></b><br>
<?php echo _KMS_GL_SMTP_MAILSERVER.":<b> smtp.".$_GET['dom'];?></b><br>
<?//print_r($webserver);

echo _KMS_ISP_MAILBOXES_ADV?><br>
<?php echo _KMS_GL_REQUIRESAUTH; ?><br>
<?php echo _KMS_GL_SSLOFF_MAILSERVER; ?><br>
<?php echo _KMS_SERVICES_WEBMAIL.": "; ?><a href=http://webmail.<?php echo $_GET['dom']; ?>>http://webmail.<?php echo $_GET['dom'] ?></a><br>
<br>
<?php echo _KMS_SERVICES_MAIL; ?>
<br>
<table class="email_table"><tr class="email_table_header"><td><b>E-mail</b></td><td><b><?php echo _KMS_GL_USERNAME?></b></td><td><b><?php echo _KMS_GL_PASSWORD?></b></td></tr>
<?php
$i =0;
while ($row=mysqli_fetch_array($email_accounts)) {
$colorCell = "#E6F3FF";
if ($cellcolor!=$colorCell) $cellcolor=$colorCell; else $cellcolor="#ffffff";
?>
<tr style="background-color:<?=$cellcolor?>"><td><?php echo $row['mail_name']."@".$row['name'];?></td><td><?php echo $row['mail_name']."@".$row['name']?></td><td><? if($_GET['email_accounts_password_check']=="on") { echo $row['password']; } else { echo "***********"; } ?></td></tr>
<?php 
	$i++;
		} ?>
</table>
</div>
</div>
<? } ?>

<? if ($_GET['databases_check']=="on") { ?>

<div class="section_footer">
</div>

<div class="section">
<div class="section_header">
<div class="header_icon"><img src="<?php echo $base_img;?>/database48px.png"></div><?php echo _KMS_SERVICES_DB; ?>
</div>
<div class="section_content">
<?php echo _KMS_SERVICES_DB_ACCESS?><br>
<a href="http://control.<?=$_GET['dom']?>"></a><br>
<?php echo _KMS_GL_USERNAME.": <b>".$usuariplesk; ?></b><br>
<?php echo _KMS_GL_PASSWORD.": <b>".$passwordplesk; ?></b><br>
<br>
<?php echo _KMS_SERVICES_DB_HOSTNAME?> : <b>sql.<?=$_GET['dom']?></b><br><br>
</div>
<div class="section_footer">
</div>
</div>
<? } ?>

<? if ($_GET['statistics_check']=="on") { ?>

<div class="section">
<div class="section_header">
<div class="header_icon"><img src="<?php echo $base_img;?>/statistics_2_48px.png"></div><?php echo _KMS_SERVICES_STATS; ?>
<span style="font-size:12px;color:#444;font-weight:normal"><br><?php echo _KMS_MAIL_SENDCONFIG_STATS_HELPTIP; ?></span>
</div>
<div class="section_content">
<a href=http://www.<?php echo $_GET['dom']; ?>/webstats>http://www.<?php echo $_GET['dom']; ?>/webstats</a><br>
<?php echo _KMS_GL_USERNAME.": ".$usuari; ?><br>
<?php echo _KMS_GL_PASSWORD.": ".$passwd; ?>
</div>
<div class="section_footer">
</div>
</div>
<? } ?>

<? if($_GET['extranet_check']=="on") { ?>

<div class="section">
<div class="section_header">
<div class="header_icon"><img src="<?php echo $base_img;?>/extranet48px.png"></div><?php echo _KMS_SERVICES_EXTRANET; ?>
</div>
<div class="section_content">
<?php echo $extranetNote; ?>
</div>
<div class="section_footer">
</div>
</div>

<? } ?>

<div class="section">
<div class="section_header">
<div class="header_icon"><img src="<?php echo $base_img;?>/support48px.png"></div><?php echo _KMS_SERVICES_EXTRA_SERVICES; ?>
</div>
<div class="section_content">
<?php echo _KMS_MAIL_SENDCONFIG_REMOTESERVICE; ?>
</div>
<div class="section_footer">
</div>
</div>

<div class="footer_mail">
<?php echo _KMS_MAIL_SENDCONFIG_FOOTER; ?><br>
<?php echo _KMS_MAIL_SENDCONFIG_THANKS; ?><br><br><br>
<?php echo _KMS_GL_LOPD; ?>
</div>

</div>
