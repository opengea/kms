#!/usr/bin/php -q
<?php
include "/usr/local/kms/lib/dbi/db_localhost_connect.php";
include "/usr/local/kms/lib/include/functions.php";

$now=date('Y-m-d');
$days_to_expiration = array(30,7); //notify days
echo "Sending client notifications ".date('d-m-Y')."...\n";

for ($x=0;$x<count($days_to_expiration); $x++) {
	// --------------------------------
	echo "Contracts expiring in ".$days_to_expiration[$x]." days ...\n";
	$select="
		SELECT
	        kms_erp_contracts.id,
	        kms_erp_contracts.end_date,
	        kms_erp_contracts.status,
	        kms_erp_contracts.domain,
	        kms_erp_contracts.sr_client,
		kms_erp_contracts.end_date,
	        kms_ecom_services.family,
	        kms_ecom_services.subfamily,
	        kms_ecom_services.name_ca,
	        kms_ecom_services.name_en,
	        kms_ecom_services.name_es
	        FROM kms_ecom_services LEFT OUTER JOIN kms_erp_contracts ON kms_ecom_services.id = kms_erp_contracts.sr_ecom_service
	        WHERE kms_erp_contracts.auto_renov='0' AND kms_erp_contracts.status = 'active'  AND DATE(DATE_ADD(kms_erp_contracts.end_date, INTERVAL -{$days_to_expiration[$x]} DAY)) = '{$now}'
	        ORDER BY kms_erp_contracts.end_date ASC;
		";
	// AND kms_ecom_services.family = '1' //dominis
	$result_=mysqli_query($link,$select);
	if (!$result_) die(mysqli_error($result_).$select);
	while ($notify=mysqli_fetch_array($result_)) {
	        //send notificacio client
	        $sel="
		SELECT
		kms_ent_clients.id, 
		kms_ent_clients.`status`, 
		kms_ent_clients.type, 
		kms_ent_clients.sr_client, 
		kms_ent_clients.phone, 
		kms_ent_clients.email AS client_email, 
		kms_ent_clients.billing_email as client_billing_email, 
		kms_ent_contacts.`name` AS client_name,
		kms_ent_contacts.email AS contact_email,
		kms_ent_contacts.language AS language
		FROM kms_ent_clients INNER JOIN kms_ent_contacts ON kms_ent_clients.sr_client = kms_ent_contacts.id
		where sr_client=".$notify['sr_client'];
		
	        $res=mysqli_query($link,$sel);
	        $client=mysqli_fetch_array($res);
	        if (!$res) die(mysqli_error($res));
		$data_finalitzacio = date('d-m-Y',strtotime($notify['end_date']));

		if ($client['language']=="ca") $client['language']="ct";
		if ($client['language']=="eu") $client['language']="es";
		if ($client['language']=="fr") $client['language']="en";

		if ($notify['family']=="1") { 
			//dominis 
			switch ($client['language']) {
			case 'ct':  $from="registres@intergrid.cat"; $subject = "Av&iacute;s d'expiraci&oacute; de domini ".strtoupper($notify['domain']);break;
			case 'en':  $from="registres@intergrid.cat"; $subject = "Notification of domain name expiration ".strtoupper($notify['domain']);break;
			case 'es':  $from="soporte@intergrid.es"; $subject = "Notificaci&oacute;n de expiraci&oacute;n de dominio ".strtoupper($notify['domain']);break;
			}
			$tpl='client_notification_tpl_domains_'.$client['language'].'.php';
		} else {
			//hostings and other
			switch ($client['language']) {
                        case 'ct':  $from="registres@intergrid.cat"; $subject = "Av&iacute;s d'expiraci&oacute; de ".strtoupper($notify['name_ca']);break;
                        case 'en':  $from="registres@intergrid.cat"; $subject = "Notification of expiration of ".strtoupper($notify['name_en']);break;
                        case 'es':  $from="soporte@intergrid.es"; $subject = "Notificaci&oacute;n de expiraci&oacute; de ".strtoupper($notify['name_es']);break;
			'client_notification_tpl_hostings_'.$client['language'].'.php';
	                }
		}


		$subject = html_entity_decode($subject);
//		$subject = mb_encode_mimeheader($subject, 'UTF-8', 'Q'); 
		ob_start();
		include ($tpl);
		$body= ob_get_clean();
		
		if ($client['client_email'] !="") { $to = $client['client_email']; }
		else { $to = $client['contact_email']; }
	
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'From: Intergrid SL <'.$from.'>' . "\r\n";
		 if ($notify['family']=="1")  mail($to, $subject, $body, $headers, "-f {$from}");
		$to="j.berenguer@intergrid.cat";
		$subject.=" [COPIA]";
		mail($to, $subject, $body, $headers, "-f {$from}");
	}
} //final bucle days_to_expiration array
