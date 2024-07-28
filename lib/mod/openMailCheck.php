<?php
//if ($_GET['exec']!="preview") {
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
error_reporting(0); 
date_default_timezone_set('Europe/Berlin');
$remote_ip = $_SERVER['REMOTE_ADDR'];

//include_once ('leerWeb.inc.php');
include_once ('/etc/kms/kms.conf.php');
include_once ('/usr/local/kms/lib/dbi/openClientDB.php');
include_once ('/usr/share/kms/lib/plugins/geoplugin/geoplugin.class.php');

//geolocating IP services
$geoplugin = new geoPlugin();
$geoplugin->locate();

//prevent SQL injection
$_GET['url']=mysqli_real_escape_string($_GET['url']);
$_GET['eid']=mysqli_real_escape_string($_GET['eid']);
$_GET['cid']=mysqli_real_escape_string($_GET['cid']);
$_GET['dom']=mysqli_real_escape_string($_GET['cid']);
$_GET['to']=mysqli_real_escape_string($_GET['to']);
$_GET['lang']=mysqli_real_escape_string($_GET['lang']);
	
if (isset($_GET['url'])) { 
	// check from email link
	$return = "Location: ".$_GET['url'];
	// not needed:
	//."?dom=".$_GET['dom']."&cid=".$_GET['cid']."&eid=".$_GET['eid']."&to=".$_GET['to']."&lang=".$_GET['lang']."&utm_source=".$_GET['utm_source']."&utm_medium=".$_GET['utm_medium']."&utm_campaign=".$_GET['utm_campaign'];
	$opened_on_query = ",opened_on='browser'";
} else {
	// check from email body
	$return = "Location: http://".$_SERVER['HTTP_HOST']."/kms/mod/emailing/1x1.png";
        $opened_on_query = ",opened_on='email'";
}
//necessitem saber en quina data es va enviar per determinar la taula on estan els registres
$link_client_extranet = mysqli_connect($client_account['dbhost'],$client_account['dbuser'],$client_account['dbpasswd']);
if (!$link_client_extranet) $link_client_extranet = mysqli_connect('localhost',$client_account['dbuser'],$client_account['dbpasswd']);
if (!$link_client_extranet) die('can\'t connect to client db server '.$client_account['dbhost'].' using '.$client_account['dbuser'].' '.$client_account['dbpasswd'].mysqli_error());

mysqli_select_db ($client_account['dbname'],$link_client_extranet);
if ($_GET['mod']=="") $_GET['mod']="mailings";
$select="select * from kms_".$_GET['mod']." where id=".$_GET['eid'];
$result=mysqli_query($this->dblinks['client'],$select);
$current_mailing=mysqli_fetch_array($result);
$mailing_year=substr($current_mailing['send_datetime'],0,4);
$mailing_month=substr($current_mailing['send_datetime'],5,2);

$link_mailing_server = mysqli_connect($setup['mailer_server'],$setup['mailer_db_user'],$setup['mailer_db_pass']);
mysqli_select_db ($setup['mailer_db_name'],$link_mailing_server);
if (substr($mailing_month,0,1)=="0") $mailing_month=substr($mailing_month,1,1);

// comprovem si existeix
$select  = "SELECT * from kms_isp_mailings_".$mailing_year."_".$mailing_month." WHERE rcpt_to='".$_GET['to']."' AND id_mailing='".$_GET['eid']."' and id_client='".$_GET['cid']."'";
$result=mysqli_query($this->dblinks['client'],$select);
$row=mysqli_fetch_array($result);

if ($row['rcpt_to']==$_GET['to']) {
	// canviem estat
	$update = "UPDATE kms_isp_mailings_".$mailing_year."_".$mailing_month." SET status='opened',last_update='".date('Y-m-d H:i:s')."',opened_datetime='".date('Y-m-d H:i:s')."',relay_ip='".$remote_ip."',opened_from_city='".$geoplugin->city."',opened_from_country='".$geoplugin->countryName."'".$opened_on_query." WHERE rcpt_to='".$_GET['to']."' AND id_mailing='".$_GET['eid']."' and id_client='".$_GET['cid']."' and status!='bounced'";
	$result = mysqli_query($this->dblinks['client'],$update); // or die(mysqli_error());
	if (!$result) echo mysqli_error($result)." SQL:".$update;
} else {
	// insertem
	$insert = "INSERT INTO kms_isp_mailings_".$mailing_year."_".$mailing_month." (rcpt_to,id_mailing,id_client,status,last_update,opened_datetime,relay_ip,opened_from_city,opened_from_country) VALUES ('".$_GET['to']."','".$_GET['eid']."','".$_GET['cid']."','opened','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','".$remote_ip."','".$geoplugin->city."','".$geoplugin->countryName."')";
	$result = mysqli_query($this->dblinks['client'],$insert);
	 if (!$result) echo mysqli_error($result)." SQL:".$insert;
//	echo $insert;
}
//exit;
//if ($_SERVER['REMOTE_ADDR']!='85.48.253.234')	header("".$return.""); 
// en comptes de redirect farem variables replacement i mostrarem el body
// connect to client account
//require ('/usr/local/kms/lib/dbconnect.php');
//echo "OK";
$conf=Array();
$conf['domain']=$client_account['domain'];
include_once "/usr/share/kms/mod/emailing/render_functions.php";

if (isset($_GET['url'])) { 
	// open on browser (email link)
	$template=$body =file_get_contents($_GET['url'],true)."<script>document.getElementById('clickOpen').style.display='none';</script>";
	// get mailing
	if ($_GET['mod']=="") $_GET['mod']="mailings";
//	$query= "SELECT * FROM kms_".$_GET['mod']." WHERE id='".$_GET['eid']."'";
//	$result_mailings = mysqli_query($this->dblinks['client'],$query);
//	if (!$result_mailings) {echo "openMailCheck:".mysqli_error();exit;}
//	$current_mailing = mysqli_fetch_array($result_mailings);
//	include "variables_replacement.php";
//      require "make_select.php";
	$g=$current_mailing['to_group'];
	if ($g!="") {
	$sql = "select * from kms_ent_contacts where email='".$_GET['to']."' and (groups='{$g}' or groups like '{$g},%' or groups like '%,{$g},%' or groups like '%,{$g}')";
$link_mailing = mysqli_query($this->dblinks['client'],$sql);
//        if (!$link_mailing) { echo "error 3: ".mysqli_error()." SQL:".$sql); echo "error 3: ".mysqli_error()." SQL:".$sql;exit;}
	$row = mysqli_fetch_array($link_mailing);
	for ($k=0;$k<mysqli_num_fields($link_mailing);$k++) {
                $fieldname = mysqli_field_name ($link_mailing, $k);
                $body = str_replace ("[kms_ent_contacts.{$fieldname}]",$row[$fieldname],$body);
                }
	}
	//		id=25&mod=mailings_articles
	//			
	//$_GET['id']=$_GET['eid'];
	//include "/usr/share/kms/mod/emailing/mailing_preview.php";		
	
	$body = render_tpl($body,$current_mailing);
	echo $body;
} else {
	// retornem imatge
header ($return);
}
//
?>
