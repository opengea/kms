<?

//set_time_limit(0);
    ini_set('display_errors','1');
    ini_set('display_startup_errors','1');
    error_reporting (E_ALL);

//require_once('conexion.php');
require_once('leerWeb.inc.php');
//require_once('email.class.php');

require_once ('/usr/local/kms/lib/openClientDB.php');

$_conexion = "";
$_query = "";
$_response = "";
$_params = array();
$_lenght = 0;
$_table_users = array('id_users','name','surname','address','location','province','zipcode','phone','birthdate','pass','email','subscriptionDate');
$_table_users_profiles = array('id_users','newsletter','password_expired');
$_table_mailing_grups = array('id_groups','name','sql');
$_table_mailing_enviats = array('id','serial','to','from','sr_body','total_users','send_date');

$_array = array ("name" =>"", "from" =>"", "group" =>"", "subject" =>"", "urlBody" =>"", "params" =>"", "current_domain"=>"");
//-- recogemos el argumento de la SHELL:


$_params1 = urldecode($argv[1]);

//$_params1 = urldecode("a%3A7%3A%7Bs%3A4%3A%22name%22%3Bs%3A7%3A%22aaaakkk%22%3Bs%3A4%3A%22from%22%3Bs%3A22%3A%22info%40videoartworld.com%22%3Bs%3A5%3A%22group%22%3Bs%3A4%3A%22Test%22%3Bs%3A7%3A%22subject%22%3Bs%3A24%3A%22VideoArtWorld%2Bnewsletter%22%3Bs%3A7%3A%22urlBody%22%3Bs%3A78%3A%22http%3A%2F%2Fwww.videoartworld.com%2Fdata%2Fmailings%2F2007_septiembre%2F2007_septiembre.htm%22%3Bs%3A5%3A%22isPhp%22%3Bs%3A0%3A%22%22%3Bs%3A6%3A%22params%22%3Bs%3A5%3A%22Array%22%3B%7D");

$_params1 = unserialize($_params1);

//-- lo pasamos al de esta php, de esta manera no nos liamos:
$_keys_params = array_keys($_params1);
$_values_params = array_values($_params1);
$lenght = count($_keys_params);
for ( $i = 0 ; $i<$lenght ; $i++ ) {
	$_array[$_keys_params[$i]] = $_values_params[$i];
}

//-- Asignamos las variables:
$_comentario = urldecode($_array['name']);
$_from = $_array['from'];
$_grupo = urldecode($_array['group']);
$_asunto = urldecode($_array['subject']);
$_urlBody = $_array['urlBody'];


//----------------------------------------------------

//-- Selecionamos la sentencia de dicho grupo:	
        $query = mysql_query("SELECT * FROM kms_mailing_groups WHERE name  = '$_grupo' LIMIT 1");
        $row = mysql_fetch_array($query);

	if ($row == FALSE)
	{
		$string = $_conexion->get_db_error();
		set_response("status=ko&at=DB&error=$string");
		send_response_to_client();
		exit;
	}

//-- Ejecutamos la sentencia que corresponde a dicho grupo:	
        $query = mysql_query($row['sql']);
        $numTotal= mysql_num_rows($query);

        $sql = $query;

//-- Enviamos el email al grupo correspondiente:
	$_table_mailing_enviats[0] = "";
	$_table_mailing_enviats[1] = $_comentario;
	$_table_mailing_enviats[2] = $_grupo;
	$_table_mailing_enviats[3] = $_from;
	$_table_mailing_enviats[4] = $sql;
//	$_table_mailing_enviats[5] = rawurlencode($body);
//	$_table_mailing_enviats[6] = mysql_num_rows($sql);
	$num_total = mysql_num_rows($sql);
	$_table_mailing_enviats[6] = $num_total;
	$_table_mailing_enviats[7] = date('YmdHis',substr(microtime(),11));
	
	
	
		$_urlBody .= "?";		
	
	$last_id = "";
	while($row = mysql_fetch_assoc($sql))
	{
			for ( $i = 0 ; $i<$_lenght ; $i++ ) {
				if ($i != ($_lenght-1)) {
					$_urlBody .= "".$_values_params[$i]."=".$row[$_values_params[$i]]."&";
				}else {
					$_urlBody .= "".$_values_params[$i]."=".$row[$_values_params[$i]];
				}				
			}

			$_body = getWeb($_urlBody);
			$_urlBody = $_array['urlBody']."?";	

        $query = mysql_query("SELECT MAX(id) as last_id FROM kms_mailings");
        $row_last_id = mysql_fetch_array($query);
	$last_id = $row_last_id["last_id"];

	$filename = "logs/report.log";
	$handle = fopen($filename, 'a+');
	fwrite($handle, $row['email']."\r\n");


        $head  = "Date: ". date("D, d M Y H:i:s",time()). "\n";
        $head  .= "Return-Path: ".$row['email']."\n";
        $head  .= "From: ".$row['email']."\n";
        $head  .= "Sender: ".$row['email']."\n";
        $head  .= "Reply-To: ".$row['email']."\n";
        $head  .= "Organization: ".$row['email']."\n";
        $head  .= "X-Sender: ".$row['email']."\n";
        $head  .= "X-Priority: 3\n";
        $head  .= "X-Mailer: Intergrid Mailing System\n";
        $head  .= "Mime-Version: 1.0\n";

        $head  .= "Content-Type: text/html; charset=utf-8\n";
        $head  .= "Content-Transfer-Encoding: 8bit\n";
	mail($row['email'], $_asunto, $_body, $head);

	} //while
/*CREATE TABLE  `vaw-extranet`.`kms_mailings` (
  `id` int(11) NOT NULL auto_increment,
  `from` varchar(100) default NULL,
  `to` varchar(30) default NULL,
  `subject` varchar(100) default NULL,
  `sr_body` varchar(100) default NULL,
  `total_users` int(11) default '0',
  `impacts` int(11) default NULL,
  `status` varchar(50) default NULL,
  `creation_date` date default NULL,
  `dr_folder` varchar(100) default NULL,
  `serial` varchar(100) default NULL,
  PRIMARY KEY  USING BTREE (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1ç


*/
   $query = mysql_query("UPDATE kms_mailings SET total_users = $num_total, send_date = '".date('Y-m-d')."',status='sent' WHERE id=$last_id");
//$_table_mailing_enviats[7]."' WHERE id=$last_id");


$handle = fopen($filename, 'a+');
fwrite($handle, "--FINISHED--\r\n");

	
	return;
	exit;

//-- Functions privates of sendEmail.php

function send_response_to_client(){
	global $_response;
	print $_response;
	set_response("");
}

function set_response($response){
	global $_response;
	$_response = $response;
}

function get_response(){
	global $_response;
	return $_response;
}

//-- end of functions of sendEmail.php
?>
