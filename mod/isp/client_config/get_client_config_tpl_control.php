<?
	include "/usr/local/kms/lib/include/pwcrypt.functions.php";
	$base_img ="https://intranet.intergrid.cat/kms/css/aqua/mod/isp";
?>

<style>
body { background-color: #ffffff!important;}
body td, body p { white-space: normal !important; }
td { font-size: 13px !important; }

</style>
<table style="font-family:Arial,Helvetica,sans-serif;font-size:13px;background-color:#fff;width: 600px; ">
	<tr>
		<td style="background-color:#FFFFFF;padding:15px;">
			<p><img src="<?=$base_img?>/logo_intergrid300.png" style="width:150px;margin-bottom:2.5rem" width="150"></p>
			<p style="font-size:13px;line-height:130%">
			<? echo _KMS_MAIL_SENDCONFIG_SALUTATION; ?><br><br>
			<? echo _KMS_MAIL_SENDCONFIG_HEAD; ?>
			</p>
		</td>
	</tr>

	<tr>
		<td>

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
		$body_txt= '<p><a style="font-size:13px" href='.$cp_link.'>'.$cp_link.'</a><br>';
		$body_txt.= _KMS_GL_USERNAME.': <b>'.$user['username'].'</b><br>';
		$body_txt.= _KMS_GL_PASSWORD.': <b>';
		if (strlen(decrypt($user['upassword'])>0)) $pwd=decrypt($user['upassword']); else $pwd=$user['upassword'];
//if ((int)strlen(decrypt($user['upassword'])>0)) echo "SI";
$pwd=decrypt($user['upassword']);
		$body_txt.= $pwd;
		$body_txt.= '</b>';

		if ($_SERVER['REMOTE_ADDR']=='81.0.57.125'&&!isset($_GET['destinyemail']))  { 

		$body_txt.= '<hr>';
		$body_txt.= '<form id="config_gen_form" method="POST" action="https://control.intergridnetwork.net/index.php">';
		$body_txt.= '<input type="hidden" name="login" value="'.$user['username'].'">';
		$body_txt.= '<input type="hidden" name="passwd" value="'.$pwd.'">';
		$body_txt.= '<input class="customButton highlight big" type="submit" value="Entrar">';
		$body_txt.= '</form>';
		
		}
	
                $data = [

                        'header_logo' => $base_img."/controlpanel48px.png",
                        'header_txt' => $header_txt,
			'header_info_txt' => _KMS_MAIL_SENDCONFIG_CP_HELPTIP,
                        'body_txt' => $body_txt,
                        'footer_txt' => ''

                ];

                echo render_block($data);

	 } if($_GET['extranet_check']=="on") { 

		$header_txt = _KMS_SERVICES_EXTRANET;
		$body_txt = $extranetNote;

                $data = [

                        'header_logo' => $base_img."/extranet48px.png",
                        'header_txt' => $header_txt,
			'header_info_txt' => _KMS_MAIL_SENDCONFIG_EXTRANET_HELPTIP,
                        'body_txt' => $body_txt,
                        'footer_txt' => ''

                ];

                echo render_block($data);	


	} if(($_GET['ftp_check']=="on")&&($_GET['dom']!="")) { 

		$header_txt = _KMS_SERVICES_FTP;
		$body_txt= '<p></b>'._KMS_GL_SERVER.':<b> ftp.'.$_GET['dom'].' ('.$webserver['ip'].')</b><br>';
		$body_txt.= _KMS_GL_USERNAME.': <b>'.$ftp['login'].'</b><br>';
		$body_txt.= _KMS_GL_PASSWORD.': <b>'.$ftp['password'].'</b><br>';
		$body_txt.= _KMS_GL_BASEHTMLPATH.': <b>/httpdocs</b></p>';

		if ($_SERVER['REMOTE_ADDR']=='81.0.57.125'&&!isset($_GET['destinyemail']))  {
                $ftp_connection_status =  check_ftp_connection($webserver['ip'],$ftp['login'],$ftp['password']);
                if ($ftp_connection_status === 'success') {
                        $body_txt.= render_ftp_status(_KMS_MAIL_SENDCONFIG_FTP_CHECK_SUCCESFUL,'green',true);
                	} else {
                        $error_msg = $ftp_connection_status;
                        $body_txt.= render_ftp_status($error_msg,'red',true);
                	}
        	}

		if (mysqli_num_rows($ftp_others) != 0) {
			
			$body_txt.= '<b>'._KMS_SERVICES_FTP_OTHER_ACCOUNTS_HEADER."</b><br><br>";

			$body_txt.= '<table style="border-style: solid; border-color: #B4E3FB; border: 2px; width: 100%; font-size: 11px; border-collapse:collapse;">';
	                $body_txt.= '<tr style="background: #B4E3FB;">';
        	        $body_txt.= '<td style="padding:3px;"><b>'._KMS_SERVICES_FTP_USERNAME.'</b></td>';
                	$body_txt.= '<td style="padding:3px;"><b>'._KMS_SERVICES_FTP_PASSWORD.'</b></td>';
	                $body_txt.= '<td style="padding:3px;"><b>'._KMS_SERVICES_FTP_FOLDER.'</b></td>';
			if ($_SERVER['REMOTE_ADDR']=='81.0.57.125'&&!isset($_GET['destinyemail']))  {
				$body_txt.= '<td width:50px; style="padding:3px;"><b>'._KMS_GL_STATUS.'</b></td>';
			}
        	        $body_txt.= '</tr>';

                	$i=0;
	                while ($row=mysqli_fetch_array($ftp_others)) {

				if ($_SERVER['REMOTE_ADDR']=='81.0.57.125'&&!isset($_GET['destinyemail']))  {
                                        $ftp_connection_status =  check_ftp_connection($webserver['ip'],$row['login'],$row['password']);
                                        if ($ftp_connection_status === 'success') {
                                        $check_response= render_ftp_status('OK','green');
                                        } else {
                                        $error_msg = $ftp_connection_status;
                                        $check_response= render_ftp_status('KO','red');
                                        }
                                }

        	                $colorCell = "#E6F3FF";
				$path = explode('/',$row['home']);
                	        if ($cellcolor!=$colorCell) $cellcolor=$colorCell; else $cellcolor="#ffffff";

                        	$body_txt.= '<tr style="background-color:'.$cellcolor.'">';
	                        $body_txt.= '<td style="padding:3px;">'.$row['login'].'</td>';
        	                $body_txt.= '<td style="padding:3px;">'.$row['password'].'</td>';
        	                $body_txt.= '<td style="padding:3px;">'.$path[sizeof($path)-2].'/'.$path[sizeof($path)-1].'</td>';
				if ($_SERVER['REMOTE_ADDR']=='81.0.57.125'&&!isset($_GET['destinyemail']))  {
					$body_txt.= '<td style="width:50px; padding:3px;">'.$check_response.'</td>';
				}
	                        $body_txt.= '</tr>';

        	                $i++;

                        }

                $body_txt.= '</table>';


		}


                $data = [

                        'header_logo' => $base_img."/ftpaccount48px.png",
                        'header_txt' => $header_txt,
			'header_info_txt' => _KMS_MAIL_SENDCONFIG_FTP_HELPTIP,
                        'body_txt' => $body_txt,
                        'footer_txt' => ''

                ];

                echo render_block($data);



	} if($_GET['email_accounts_check']=="on") { 

		$header_txt = _KMS_SERVICES_MAIL;

		// Accounts table

                $body_txt= '<table style="border-style: solid; border-color: #B4E3FB; border: 2px; width: 100%; font-size: 11px; border-collapse:collapse;">';
                $body_txt.= '<tr style="background: #B4E3FB;">';
                #$body_txt.= '<td style="padding:3px;"><b>E-mail</b></td>';
                $body_txt.= '<td style="padding:3px;"><b>'._KMS_GL_USERNAME.'</b></td>';
                $body_txt.= '<td style="padding:3px;"><b>'._KMS_GL_PASSWORD.'</b></td>';
                $body_txt.= '</tr>';

                $i=0;
                while ($row=mysqli_fetch_array($res_mailboxes)) {

                        $colorCell = "#E6F3FF";
                        if ($cellcolor!=$colorCell) $cellcolor=$colorCell; else $cellcolor="#ffffff";

                        $body_txt.= '<tr style="background-color:'.$cellcolor.'">';
                        #$body_txt.= '<td style="padding:3px;">'.$row['mailname']."@".$_GET['dom'].'</td>';
                        $body_txt.= '<td style="padding:3px;">'.$row['mailname']."@".$_GET['dom'].'</td>';

                        $body_txt.= '<td style=" padding:3px;">';
                        $body_txt.= ($_GET['email_accounts_password_check']=="on") ? $row['password'] : "***********";
                        $body_txt.= '</td>';
                        $body_txt.= '</tr>';

                        $i++;

                        }

                $body_txt.= '</table>';

		$body_txt.= '<br>';
		$body_txt.= '<p>'._KMS_ISP_MAILBOXES_ACCOUNTTYPE.' *<br><span style="font-size:11px"><br>*'._KMS_ISP_MAILBOXES_ACCOUNTTYPE_POP_DISCLAIMER.'</span><br><br>';
	//	$body_txt.= '<span style="padding: 0.7em; display:block; text-align: center; background-color: beige">'._KMS_ISP_MAILBOXES_ACCOUNTTYPE_POP_DISCLAIMER.'</span><br>';

		$body_txt.= '<div style="padding:5px;background: #B4E3FB;"><b>'._KMS_ISP_MAILBOXES_INCOMING_CONFIGURATION.'</div></b><br><p style="line-height:130%">';
		$body_txt.= _KMS_ISP_MAILBOXES_INCOMING_HOST.': <b>'.$server['hostname'].'</b><br>';
		$body_txt.=  _KMS_ISP_MAILBOXES_USERNAME.': <i>'._KMS_ISP_MAILBOXES_USERNAME_HINT.'</i><br>';
		$body_txt.=  _KMS_ISP_MAILBOXES_PASSWORD.': <i>'._KMS_ISP_MAILBOXES_PASSWORD_HINT.'</i><br>';

		if ($vhost['mailserver_id']=="30") {
			$body_txt.= _KMS_ISP_MAILBOXES_IN_PORT.' <b>143</b><br>';
			$body_txt.= _KMS_ISP_MAILBOXES_ENCRYPTION_TYPE.' <b>'._KMS_ISP_MAILBOXES_SECURITY_NONE.'</b><br>';
                        } else {
			$body_txt.= '<br>'._KMS_ISP_MAILBOXES_SSL_INCOMING_OPTIONS.'<br><br>';
			$body_txt.= _KMS_ISP_MAILBOXES_IN_PORT.' <b>993</b><br>';
			$body_txt.= _KMS_ISP_MAILBOXES_ENCRYPTION_TYPE.' <b>SSL/TLS</b><br>';
                        $body_txt.= _KMS_ISP_MAILBOXES_SSL_AUTHENTICATION.'<b>'._KMS_ISP_MAILBOXES_SSL_AUTHENTICATION_REQUIRED.'</b><br>';
			$body_txt.= '<br>';
			$body_txt.= _KMS_ISP_MAILBOXES_IN_PORT.' <b>143</b><br>';
                        $body_txt.= _KMS_ISP_MAILBOXES_ENCRYPTION_TYPE.' <b>STARTTLS</b><br>';
                        $body_txt.= _KMS_ISP_MAILBOXES_SSL_AUTHENTICATION.'<b>'._KMS_ISP_MAILBOXES_SSL_AUTHENTICATION_REQUIRED.'</b><br>';
                        }

		$body_txt.= '</p><br>';
		$body_txt.= '<b><div style="padding:5px;background: #B4E3FB;">'._KMS_ISP_MAILBOXES_OUTGOING_CONFIGURATION.'</div></b><br><p style="line-height:130%">';
		$body_txt.= _KMS_ISP_MAILBOXES_OUTGOING_HOST.': <b>'.$server['hostname'].'</b><br>';
		$body_txt.=  _KMS_ISP_MAILBOXES_USERNAME.': <i>'._KMS_ISP_MAILBOXES_USERNAME_HINT.'</i><br>';
                $body_txt.=  _KMS_ISP_MAILBOXES_PASSWORD.': <i>'._KMS_ISP_MAILBOXES_PASSWORD_HINT.'</i><br>';
	
		if ($vhost['mailserver_id']=="30") {
			$body_txt.= _KMS_ISP_MAILBOXES_OUT_PORT.'<b>'._KMS_ISP_MAILBOXES_OUT_POP_PORT.'</b><br>';
                        $body_txt.= _KMS_ISP_MAILBOXES_ENCRYPTION_TYPE.' <b>'._KMS_ISP_MAILBOXES_SECURITY_NONE.'</b><br>'; 
			} else {
			$body_txt.= '<br>'._KMS_ISP_MAILBOXES_SSL_OUTGOING_OPTIONS.'<br><br>';
			#$body_txt.= _KMS_ISP_MAILBOXES_OUT_PORT.' <b>143</b><br>';
			#$body_txt.= _KMS_ISP_MAILBOXES_ENCRYPTION_TYPE.'<b>STARTTLS</b><br>';
			#$body_txt.= '<br>';
			$body_txt.= _KMS_ISP_MAILBOXES_OUT_PORT.' <b>465</b><br>';
                        $body_txt.= _KMS_ISP_MAILBOXES_ENCRYPTION_TYPE.' <b>SSL/TLS</b><br>';
                        $body_txt.= _KMS_ISP_MAILBOXES_SSL_AUTHENTICATION.'<b>'._KMS_ISP_MAILBOXES_SSL_AUTHENTICATION_REQUIRED.'</b><br>';
			$body_txt.= '<br>';
			$body_txt.= _KMS_ISP_MAILBOXES_OUT_PORT.' <b>587</b><br>';
                        $body_txt.= _KMS_ISP_MAILBOXES_ENCRYPTION_TYPE.'<b>STARTTLS</b><br>';
			$body_txt.= _KMS_ISP_MAILBOXES_SSL_AUTHENTICATION.'<b>'._KMS_ISP_MAILBOXES_SSL_AUTHENTICATION_REQUIRED.'</b><br>';
			}

		$body_txt.= '</p>';
/*		$body_txt.= '<br>';
		$body_txt.= '<hr>';
                $body_txt.= '<b>'._KMS_ISP_MAILBOXES_CLIENT_CONFIG.'</b><br><br>';
                $body_txt.= '<p>'._KMS_ISP_MAILBOXES_CLIENT_CONFIG_TXT1.'<br><br>';
                $body_txt.= '<table style="width:100%"><tr><td style="text-align:center">';

                $email_client_config_url = ($_GET['l'] == 'es') ? 'https://www.intergrid.es/'.$_GET['l'].'/config_email' : 'https://www.intergrid.cat/'.$_GET['l'].'/config_email';
                $body_txt.= '<a style="font-size:13px" href="'.$email_client_config_url.'" target="_blank">'.$email_client_config_url.'</a><br><br>';
                $body_txt.= '<img src="'.$base_img.'/intergrid_client_config.png" style="width:300px" width="300"><br>';
                $body_txt.= '</td></tr></table><br><br>';
*/
                $body_txt.= '<br>';
                $body_txt.= '<div style="padding:5px;background: #B4E3FB;"><b>'._KMS_ISP_MAILBOXES_WEBMAIL.'</b></div><br>';
                $body_txt.= '<p>'._KMS_ISP_MAILBOXES_WEBMAIL_ACCESS.'<br><br>';
                $body_txt.= '<table style="width:100%"><tr><td style="text-align:center">';

                $webmail_url = ($_GET['l'] == 'es') ? 'https://webmail.intergrid.es' : 'https://webmail.intergrid.cat';
                $body_txt.= '<a style="font-size:13px" href="'.$webmail_url.'" target="_blank">'.$webmail_url.'</a><br><br>';
                $body_txt.= '<img src="'.$base_img.'/intergrid_webmail.png" style="width:300px" width="300"><br>';
                $body_txt.= '<span style="font-size:11px"><br>'._KMS_SERVICES_MAIL_CHANGEPASSWORD.'</span></p>';
                $body_txt.= '</td></tr></table>';

                $data = [

                        'header_logo' => $base_img."/email48px.png",
                        'header_txt' => $header_txt,
			'header_info_txt' => _KMS_MAIL_SENDCONFIG_MAIL_HELPTIP,
                        'body_txt' => $body_txt,
                        'footer_txt' => ''

                ];

                echo render_block($data);

	 } if(($_GET['databases_check']=="on")&&($_GET['dom']!="")) {

                $header_txt = _KMS_SERVICES_DATABASES;

		$body_txt= '<table style="border-style: solid; border-color: #B4E3FB; border: 2px; width: 100%; font-size: 11px; border-collapse:collapse;">';
                $body_txt.= '<tr style="background: #B4E3FB;">';
                $body_txt.= '<td style="padding:3px;"><b>'._KMS_SERVICES_DATABASES_DBNAME.'</b></td>';
                $body_txt.= '<td style="padding:3px;"><b>'._KMS_SERVICES_DATABASES_DBUSERNAME.'</b></td>';
                $body_txt.= '<td style="padding:3px;"><b>'._KMS_SERVICES_DATABASES_DBPASSWORD.'</b></td>';
		$body_txt.= '<td style="padding:3px;"><b>'._KMS_SERVICES_DATABASES_HOSTNAME.'</b></td>';
                $body_txt.= '</tr>';

                $i=0;
                while ($row=mysqli_fetch_array($res_databases)) {

                        $colorCell = "#E6F3FF";
                        if ($cellcolor!=$colorCell) $cellcolor=$colorCell; else $cellcolor="#ffffff";

                        $body_txt.= '<tr style="background-color:'.$cellcolor.'">';
                        $body_txt.= '<td style="padding:3px;">'.$row['name'].'</td>';
                        $body_txt.= '<td style="padding:3px;">'.$row['login'].'</td>';

                        #$body_txt.= '<td style=" padding:3px;">';
                        #$body_txt.= ($_GET['databases_accounts_password_check']=="on") ? $row['password'] : "***********";
			#$body_txt.= '</td>';
			$body_txt.= '<td style="padding:3px;">'.$row['password'].'</td>';
                        $body_txt.= '</td>';
			 $body_txt.= '<td style="padding:3px;">localhost</td>';
                        $body_txt.= '</tr>';

                        $i++;

                        }

                $body_txt.= '</table>';
		$body_txt.= '<br><br>';
		$body_txt.= '<b>'._KMS_SERVICES_DATABASES_PHPMYSQL_HEADER.'</b><br><br>';
		$body_txt.= _KMS_SERVICES_DATABASES_TXT1;
                $body_txt.= " "._KMS_SERVICES_DATABASES_TXT2."<br><br><a href='https://control.intergridnetwork.net/kms/mod/isp/dbadmin/?dom=".$extranet['domain']."&lang=".$_GET['l']."-utf-8'>https://control.intergridnetwork.net/kms/mod/isp/dbadmin/?dom=".$extranet['domain']."&lang=".$_GET['l']."-utf-8</a><br><br>";
		$body_txt.= '<table style="width:100%"><tr><td style="text-align:center">';
                $body_txt.= '<img src="'.$base_img.'/intergrid_phpmyadmin.png" style="width:300px" width="300"><br>';
                $body_txt.= '</td></tr></table>';


                $data = [

                        'header_logo' => $base_img."/database48px.png",
                        'header_txt' => $header_txt,
                        'header_info_txt' => _KMS_SERVICES_DATABASES_HELPTIP,
                        'body_txt' => $body_txt,
                        'footer_txt' => ''

                ];

                echo render_block($data);


        } 

		
		$header_txt = _KMS_SERVICES_EXTRA_SERVICES;
                $body_txt = '<p>'._KMS_MAIL_SENDCONFIG_REMOTESERVICE.'</p>';

                $data = [

                        'header_logo' => $base_img."/support48px.png",
                        'header_txt' => $header_txt,
                        'body_txt' => $body_txt,
                        'footer_txt' => ''

                ];

                echo render_block($data);

?>
		</td></tr>
	
		<tr>
			<td style="font-size: 11px !important;padding:10px 20px;text-align:justify;color: #666;">
			<p><? echo _KMS_MAIL_SENDCONFIG_FOOTER; ?></p>
		        <p><? echo _KMS_MAIL_SENDCONFIG_THANKS; ?></p>
		        <p><? echo _KMS_GL_LOPD; ?></p>
			</td>
		</tr>
</table>

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

	function render_ftp_status($msg,$color,$label = false) {
	
		$output = ($label) ? '<div style="display: inline-flex; width:100%;">'._KMS_GL_STATUS.': ' : '';
                $output.= '<svg xmlns="http://www.w3.org/2000/svg" style="margin-top: 3px; margin-left: 3px; width: 100%" height="30px"><g><circle cx="8" cy="5" r="5" fill="'.$color.'"/></circle>';
                $output.= '<text x="18" y="10" font-family="Arial" font-size="13px" fill="'.$color.'">'.$msg.'</text>';
                $output.= '</g></svg>';
                $output.= '</div>';

		return $output;

	}

	function render_block($data) {

		$output="
		<!-- section start -->
                <table style='background-color: #E6F3FF; padding: 8px; margin-bottom: 0px; width: 100%'>
			<tr>
				<td>
					<table cellspacing=0 cellpadding=10 border=0 style='padding:0.5em; width: 100%'>
						<tr style='background-color:#9CF; width:100%'>
							<td style='width:50px' width='50'><img src='".$data['header_logo']."' style='width:48px' width='48'></td>
							<td style='font-size:15px;font-weight:700;color:#006'>".$data['header_txt']."</td>
						</tr>";

		if ($data['header_info_txt'] != '') {

			$output.="<tr><td colspan=2 style='padding:1em 1.2em; background-color:#99CCFF7D'>".$data['header_info_txt']."</td><tr>";

		}

		$output.="</table>
                          </td>
                          </tr>";	

		$output.="<td>
					<table cellspacing=0 cellpadding=10 border=0 style='width: 100%'>
                                                <tr>
							<td>".$data['body_txt']."</td>
                                                </tr>
                                        </table>

				</td>
			<tr>

			</tr>
		
			<tr>
				<td>".$data['footer_txt']."</td>
			</tr>

                </table> <!-- section end -->
                ";




		return $output;
	}

?>
