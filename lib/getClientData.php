<?
// retrieving the current domain

//SERVER_NAME 
if (isset($_SERVER['SERVER_NAME'])) $server = $_SERVER['SERVER_NAME']; else $server = $_SERVER['HTTP_HOST'];
$first = strpos($server, '.');
$last = strrpos($server, '.');
if ($first!=$last) { 
        $current_subdomain = substr($server,0,$first);
        $current_domain = substr($server,$first+1,strlen($server));
} else {
	$current_domain = substr($_SERVER['SERVER_NAME'],0,strlen($server));
}
if (isset($_GET['d'])) $current_domain=$_GET['d'];

//report($fplog,$current_domain);

if ($current_subdomain!="extranet"&&$current_subdomain!="intranet"&&$current_subdomain!="control"&&$current_subdomain!="data") {
	$select="SELECT * FROM kms_isp_extranets WHERE status='online' and (domain='".$current_subdomain.".".$current_domain."' or domain='{$current_domain}') and subdomain='extranet'";
} else if ($current_subdomain=="data") {
	$select="SELECT * FROM kms_isp_extranets WHERE status='online' and (domain='".$current_subdomain.".".$current_domain."'  or domain='{$current_domain}')";
} else {
	$select="SELECT * FROM kms_isp_extranets WHERE status='online' and (domain='".$current_subdomain.".".$current_domain."'  or domain='{$current_domain}') and subdomain='".$current_subdomain."'";
}

$result = mysqli_query($link_extranetdb,$select);
if (!$result) {    if (isset($fplog)) report($fplog,mysqli_error()); 
		   echo "getClientData error: ".mysqli_error();    exit;}

//if ($_SERVER['REMOTE_ADDR']==TARTARUS_IP) { echo "DEBUG ";print_r ($link_extranetdb); echo $select."<br>";}

$client_account = mysqli_fetch_array($result);
$current_domain=$client_account['domain'];
//if ($_SERVER['REMOTE_ADDR']==TARTARUS_IP) {echo "client account:"; print_r($client_account); echo "<br>Connecting to kms_isp_extranets using ".$extranet_server; exit; }
if (count($client_account['domain'])==0)  { $kms_fail=true;include "/usr/local/kms/tpl/default.php";exit;  }

// user language
if (isset($_GET['lang']))  $_SESSION['lang']=$_GET['lang']; 
if (!isset($_SESSION['lang'])) $_SESSION['lang']=$client_account['default_lang'];
//if ($_SESSION['lang']=="ca") $_SESSION['lang']="ct";
if ($_SESSION['lang']=="ct") $_SESSION['lang']="ca";
$case=true;
include_once( '/usr/local/kms/lang/'.$_SESSION['lang'].'.php');

?>
