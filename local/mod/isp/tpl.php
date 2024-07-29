<!--
<style type="text/css">
.container {
	margin: 0px;
	height: auto;
	width: 600px;
}
.section {
	margin-top: 10px;
	margin-right: 5px;
	margin-bottom: 10px;
	margin-left: 5px;
}
</style>
-->
<div class="container">

<div class="presentation"><?php echo _KMS_MAIL_SENDCONFIG_SALUTATION; ?>
<br><br><?php echo _KMS_MAIL_SENDCONFIG_HEAD; ?>
</div>

<div class="section">
<div class="section_header">
Dades empresa
</div>
<div class="section_content">
<?php echo $nomempresa; ?><br>
<?php echo _KMS_GL_ADMINEMAIL.": ".$emailempresa; ?>
</div>
<div class="section_footer">
</div>
</div>

<div class="section">
<div class="section_header">
<?php echo _KMS_SERVICES_CP; ?>
<span style="font-size:12px"><?php echo _KMS_MAIL_SENDCONFIG_CP_HELPTIP; ?></span>
</div>
<div class="section_content">
<a href=http://control.intergrid<?php echo $domext; ?>>http://control.intergrid<?php echo $domext; ?></a><br>
<?php echo _KMS_GL_USERNAME.": ".$usuariplesk; ?><br>
<?php echo _KMS_GL_PASSWORD.": ".$passwordplesk; ?>
</div>
<div class="section_footer">
</div>
</div>

<div class="section">
<div class="section_header">
<?php echo _KMS_SERVICES_FTP; ?>
</div>
<div class="section_content">
<?php echo _KMS_GL_SERVER.": ftp.".$_GET['dom']; ?><br>
<?php echo _KMS_GL_USERNAME.": ".$usuari; ?><br>
<?php echo _KMS_GL_PASSWORD.": ".$passwd; ?>
</div>
<div class="section_footer">
</div>
</div>


<div class="section">
<div class="section_header">
<?php echo _KMS_SERVICES_MAIL; ?>
</div>
<div class="section_content">
<?php echo _KMS_GL_POPIMAP_MAILSERVER.": mail.".$_GET['dom'];?><br>
<?php echo _KMS_GL_SMTP_MAILSERVER.": smtp.".$_GET['dom'];?><br>
<?php echo _KMS_GL_REQUIRESAUTH; ?><br>
<?php echo _KMS_GL_SSLOFF_MAILSERVER; ?><br>
<?php echo _KMS_SERVICES_WEBMAIL.": "; ?><a href=http://webmail.<?php echo $_GET['dom']; ?>>http://webmail.<?php echo $_GET['dom'] ?></a><br>
<?php echo $helpcenter._KMS_SERVICES_MAIL_CHANGEPASSWORD;?>
<br><br>
<table class="emails" width="450"><tr><td><b>E-mail</b></td><td><b><?php echo _KMS_GL_USERNAME?></b></td><td><b><?php echo _KMS_GL_PASSWORD?></b></td></tr>
<?php
$i =0;
while ($row=mysqli_fetch_array($email_accounts)) {
$colorCell = "#D7DEE6";
if ($cellcolor!=$colorCell) $cellcolor=$colorCell; else $cellcolor="#ffffff";
?>
<tr><td><?php echo $row['mail_name']."@".$row['name'];?></td><td><?php echo $row['mail_name']."@".$row['name']?></td><td><?php echo $row['password']?></td></tr>
<?php 
	$i++;
		} ?>
</table>
</div>
<div class="section_footer">
</div>
</div>



<div class="section">
<div class="section_header">
<?php echo _KMS_SERVICES_STATS; ?>
</div>
<div class="section_content">
<a href=http://www.<?php echo $_GET['dom']; ?>/webstats>http://www.<?php echo $_GET['dom']; ?>/webstats</a><br>
<?php echo _KMS_GL_USERNAME.": ".$usuari; ?><br>
<?php echo _KMS_GL_PASSWORD.": ".$passwd; ?>
</div>
<div class="section_footer">
</div>
</div>

<div class="section">
<div class="section_header">
<?php echo _KMS_SERVICES_EXTRANET; ?>
</div>
<div class="section_content">
<?php $extranetNote; ?>
</div>
<div class="section_footer">
</div>
</div>

<div class="section">
<div class="section_header">
<?php echo _KMS_SERVICES_EXTRA_SERVICES; ?>
</div>
<div class="section_content">
<?php echo _KMS_MAIL_SENDCONFIG_REMOTESERVICE; ?>
</div>
<div class="section_footer">
</div>
</div>

<div class="footer">
<?php echo _KMS_MAIL_SENDCONFIG_FOOTER; ?><br><br>
<?php echo $txt2;?><br>
<?php echo _KMS_GL_LOPD; ?>
</div>


</div>
