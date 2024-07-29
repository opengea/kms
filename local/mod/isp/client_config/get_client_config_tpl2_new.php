<?
	include "/usr/local/kms/lib/include/pwcrypt.functions.php";
	$base_img ="http://intranet.intergrid.cat/kms/css/aqua/mod/isp";
?>

<div class="container" style="margin:0;height:auto;width:600px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:400;background-color:#fff">

	<div style="background-color:#E6F3FF;padding:15px;margin-bottom:20px">
		<p style="font-size:13px;line-height:130%">
		<? echo _KMS_MAIL_SENDCONFIG_SALUTATION; ?><br><br>
		<? echo _KMS_MAIL_SENDCONFIG_HEAD; ?>
		</p>
	</div>

	<?
	
	if($_GET['client_data_check']=="on") { 


		$header_txt = _KMS_MAIL_SENDCONFIG_CLIENT_DATA;
		$body_txt = _KMS_MAIL_SENDCONFIG_CLIENT_NAME.": <b>".htmlentities(utf8_encode($client['name']))."</b>";
		if  ($client['provider']!='') {
			$body_txt.= _KMS_PROVIDER_NAME.":<b> ".htmlentities(utf8_decode($client['provider']))."</b>";
		}
		$body_txt.= "<br>";
		$body_txt.= _KMS_GL_ADMINEMAIL.": <b>".$client['email']."</b>";

		$data = [
		
			'header_logo' => $base_img."/client_account48px.png",
			'header_txt' => $header_txt,
			'body_txt' => $body_txt,
			'footer_txt' => ''

		];

		echo render_block($data);


	}

	if($_GET['control_panel_check']=="on") {

		$header_txt = _KMS_SERVICES_CP;
		$body_txt = '<p>'._KMS_MAIL_SENDCONFIG_CP_HELPTIP.'</p>';
		$body_txt.= '<p><a style="font-size:13px" href='.$cp_link.'>'.$cp_link.'</a><br>';
                $body_txt.= '<br>';
		$body_txt.= _KMS_GL_USERNAME.': <b>'.$user['username'].'</b><br>';
		$body_txt.= _KMS_GL_PASSWORD.': <b>';
		$body_txt.= (decrypt($user['upassword'] == "")) ? $user['upassword'].' Warning: PASSWORD UNENCRYPTED!' : decrypt($user['upassword']);  
		$body_txt.= '</b>';

		if ($_SERVER['REMOTE_ADDR']=='81.0.57.125'&&!isset($_GET['destinyemail']))  { 

		$body_txt.= '<hr>';
		$body_txt.= '<form id="config_gen_form" method="POST" action="https://control.intergridnetwork.net/index.php">';
		$body_txt.= '<input type="hidden" name="login" value="'.$user['username'].'">';
		$body_txt.= '<input type="hidden" name="passwd" value="'.decrypt($user['upassword']).'">';
		$body_txt.= '<input class="customButton highlight big" type="submit" value="Entrar">';
		$body_txt.= '</form>';
		
		}
	
                $data = [

                        'header_logo' => $base_img."/controlpanel48px.png",
                        'header_txt' => $header_txt,
                        'body_txt' => $body_txt,
                        'footer_txt' => ''

                ];

                echo render_block($data);

	 } if($_GET['extranet_check']=="on") { 


		$header_txt = _KMS_SERVICES_EXTRANET;
                $body_txt = '<p>'._KMS_MAIL_SENDCONFIG_EXTRANET_HELPTIP.'</p>';
		$body_txt.= $extranetNote;

                $data = [

                        'header_logo' => $base_img."/extranet48px.png",
                        'header_txt' => $header_txt,
                        'body_txt' => $body_txt,
                        'footer_txt' => ''

                ];

                echo render_block($data);	


	} if($_GET['ftp_check']=="on") { 

		$header_txt = _KMS_SERVICES_FTP;
                $body_txt = '<p>'._KMS_MAIL_SENDCONFIG_FTP_HELPTIP.'</p>';
		$body_txt.= '<p></b>'._KMS_GL_SERVER.':<b> ftp.'.$_GET['dom'].' ('.$webserver['ip'].')</b></p>';
		$body_txt.= '<p>'._KMS_GL_USERNAME.': <b>'.$ftp['login'].'</b><p>';
		$body_txt.= '<p>'._KMS_GL_PASSWORD.': <b>'.$ftp['password'].'</b></p>';
		$body_txt.= '<p>'._KMS_GL_BASEHTMLPATH.': <b>/httpdocs</b></p>';

		if ($_SERVER['REMOTE_ADDR']=='81.0.57.125'&&!isset($_GET['destinyemail']))  {
                $ftp_connection_status =  check_ftp_connection($webserver['ip'],$ftp['login'],$ftp['password']);
                if ($ftp_connection_status === 'success') {
                        $body_txt.= render_ftp_status(_KMS_MAIL_SENDCONFIG_FTP_CHECK_SUCCESFUL,'green');
                	} else {
                        $error_msg = $ftp_connection_status;
                        $body_txt.= render_ftp_status($error_msg,'red');
                	}
        	}


                $data = [

                        'header_logo' => $base_img."/extranet48px.png",
                        'header_txt' => $header_txt,
                        'body_txt' => $body_txt,
                        'footer_txt' => ''

                ];

                echo render_block($data);



	} if($_GET['email_accounts_check']=="on") { 



		$header_txt = _KMS_SERVICES_MAIL;
                $body_txt = '<p>'._KMS_MAIL_SENDCONFIG_MAIL_HELPTIP.'</p>';
		$body_txt.= '<p>'.$helpcenter.'</p>';
		$body_txt.= '<p>'._KMS_SERVICES_MAIL_CHANGEPASSWORD.'</p>';
		$body_txt.= '<p>'._KMS_ISP_MAILBOXES_ACCOUNTTYPE.'</p>';
		$body_txt.= '<p>'._KMS_GL_POPIMAP_MAILSERVER.': <b>'.$server['hostname'].'</b></p>';
		$body_txt.= '<p>'._KMS_GL_SMTP_MAILSERVER.': <b>'.$server['hostname'].'</b></p>';
	
		if ($vhost['mailserver_id']=="30") { 
			$body_txt.= '<p>'._KMS_ISP_MAILBOXES_ADV.'</p>';
			$body_txt.= '<p>'._KMS_ISP_MAILBOXES_SSL.'</p>';	
			} else {
			$body_txt.= '<p>'._KMS_ISP_MAILBOXES_SSL_PORTS."</p>";
			}

		$body_txt.= '<p>'._KMS_GL_REQUIRESAUTH.'</p>';
		$body_txt.= '<p>'._KMS_SERVICES_WEBMAIL.': <a style="font-size:13px" href="http://webmail.'.$_GET['dom'].'">http://webmail.'.$_GET['dom'].'</a></p>';

                $data = [

                        'header_logo' => $base_img."/email48px.png",
                        'header_txt' => $header_txt,
                        'body_txt' => $body_txt,
                        'footer_txt' => ''

                ];

                echo render_block($data);

	?>

<div class="warning_icon" style="float: left; padding-bottom: 5px;"><img src="<? echo $base_img;?>/warning32px.png"></div>
</b><br><? echo $helpcenter; ?><br>
<br><? echo _KMS_SERVICES_MAIL_CHANGEPASSWORD; ?>
</div>
<div style="clear: both;"></div>
<?=_KMS_ISP_MAILBOXES_ACCOUNTTYPE?><br>
<? echo _KMS_GL_POPIMAP_MAILSERVER.": <b>".$server['hostname'];?></b><br>
<? echo _KMS_GL_SMTP_MAILSERVER.": <b>".$server['hostname'];?></b><br>
<?if ($vhost['mailserver_id']=="30") {?>
<? echo _KMS_ISP_MAILBOXES_ADV;?><br>
<? echo _KMS_ISP_MAILBOXES_SSL; ?><br>
<? } else {
echo _KMS_ISP_MAILBOXES_SSL_PORTS."<br>";
} ?>
<? echo _KMS_GL_REQUIRESAUTH; ?><br>
<? echo _KMS_SERVICES_WEBMAIL.": "; ?><a style="font-size:13px" href=http://webmail.<? echo $_GET['dom']; ?>>http://webmail.<? echo $_GET['dom'] ?></a><br>
<br>
<? echo _KMS_SERVICES_MAIL; ?>
<br>
<table class="email_table" style="        border-style: solid;
        border-color: #B4E3FB;
        border: 2px;
        width: 100%;
        font-size: 11px;
        border-collapse:collapse;
"><tr class="email_table_header" style="background: #B4E3FB;"><td style=" padding:3px;"><b>E-mail</b></td><td style=" padding:3px;"><b><? echo _KMS_GL_USERNAME?></b></td><td style=" padding:3px;"><b><? echo _KMS_GL_PASSWORD?></b></td></tr>
<?php
$i =0;
while ($row=mysqli_fetch_array($res_mailboxes)) {
$colorCell = "#E6F3FF";
if ($cellcolor!=$colorCell) $cellcolor=$colorCell; else $cellcolor="#ffffff";
?>
<tr style="background-color:<?=$cellcolor?>"><td style=" padding:3px;"><? echo $row['mailname']."@".$_GET['dom'];?></td><td style=" padding:3px;"><? echo $row['mailname']."@".$_GET['dom']?></td><td style=" padding:3px;"><? if($_GET['email_accounts_password_check']=="on") { echo $row['password']; } else { echo "***********"; } ?></td></tr>
<? 
	$i++;
		} ?>
</table>
</div>
</div>
<? } ?>


<div class="section"  style="background-color: #E6F3FF;position: relative; padding: 8px;margin-bottom: 20px;">
<div class="section_header" style="        font-size: 16px;
        font-weight: bold;
        text-decoration: none;
        height: 50px;
        text-align: left;
        padding-top: 10px;
        padding-right: 15px;
        padding-bottom: 3px;
        padding-left: 15px;
        background-color: #9CF;
        color: #006;
        vertical-align: text-bottom;
        margin: 12px;
">
<div class="header_icon" style="        padding-top: 0px;
        padding-right: 15px;
        padding-bottom: 5px;
        padding-left: 5px;
        float: left;"><img src="<? echo $base_img;?>/support48px.png"></div><div class="headtext" style=" padding-top:13px;"><? echo _KMS_SERVICES_EXTRA_SERVICES; ?></div>
</div>
<div class="section_content" style="        padding-top: 10px;
        padding-right: 15px;
        padding-bottom: 10px;
        padding-left: 15px;
        font-size: 13px;
        color: #333;
        text-decoration: none;
	white-space: initial;
">
<? echo _KMS_MAIL_SENDCONFIG_REMOTESERVICE; ?>
</div>
<div class="section_footer">
</div>
</div>

<div class="footer_mail" style="        font-size: 12px;
        color: #666;
        text-align: justify;
        padding-top: 20px;
        padding-right: 5px;
        padding-left: 5px;
">
<? echo _KMS_MAIL_SENDCONFIG_FOOTER; ?><br>
<? echo _KMS_MAIL_SENDCONFIG_THANKS; ?><br><br><br>
<? echo _KMS_GL_LOPD; ?>
</div>

</div>

<?

	function check_ftp_connection($server, $username, $password){

		try {
    			$con = ftp_connect($server);
			    if (false === $con) {
			    throw new Exception(_KMS_MAIL_SENDCONFIG_FTP_CHECK_NOT_CONNECTION);
		    	    }

		        $loggedIn = ftp_login($con,  $username,  $password);
			    if (true === $loggedIn) {
			    ftp_close($con);
			    return 'success';
			    } else {
			        throw new Exception(_KMS_MAIL_SENDCONFIG_FTP_CHECK_CREDENTIALS_ERROR);
			    }
		    } catch (Exception $e) {
			    return "Error: " . $e->getMessage();
		    }
	}

	function render_ftp_status($msg,$color) {
	
		$output = '<div style="display: inline-flex; margin-top: 0.5rem">'._KMS_GL_STATUS.': ';
                $output.= '<svg xmlns="http://www.w3.org/2000/svg" style="margin-top: 3px; margin-left: 3px; width: 100%" height="30px"><g><circle cx="8" cy="5" r="5" fill="'.$color.'"/></circle>';
                $output.= '<text x="18" y="10" font-family="Arial" font-size="13px" fill="'.$color.'">'.$msg.'</text>';
                $output.= '</g></svg>';
                $output.= '</div>';

		return $output;

	}

	function render_block($data) {


		$output="
        	<div style='background-color: #E6F3FF; position: relative; padding: 8px; margin-bottom: 20px;'>
                	<div style='font-size:16px;font-weight:700;text-decoration:none;height:50px;text-align:left;padding:10px 15px 3px;background-color:#9CF;color:#006;vertical-align:text-bottom;margin:12px'>
                        	<div style='padding-top: 0px; padding-right: 15px; padding-bottom: 5px; padding-left: 5px; float: left;'>
                                	<img src='".$data['header_logo']."'>
				</div>
				<div style='padding-top:13px;'>".$data['header_txt']."</div>
                	</div>

	                <div style='padding-top:10px;padding-right:15px;padding-bottom:10px;padding-left:15px;font-size: 13px;color: #333;text-decoration: none;'>
        	                <p>".$data['body_txt']."</p>
               		</div> <!-- end div section_content -->

	                <div>".$data['footer_txt']."</div>
	        </div> <!-- end div section -->
		";

		return $output;
	}

?>
