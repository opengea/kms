<?
require_once('functions.inc.php');
require_once('conexion.class.php');
require_once('userOnline.class.php');


if (!session_start()){
//	Error al iniciar la sesion.....	
	$string = "no se ha podido iniciar la session";
	set_response("status=ko&at=SESSION&error=$string");
	send_response_to_client();
	exit;
}
if (!session_is_registered('_userOnlineS')) {
    $string = "La session ha caducado";
	set_response("status=ko&at=SESSION&error=$string");
	send_response_to_client();
	exit;
}

$_userOnline = unserialize($_userOnlineS);

$_conexion = "";
$_row= "";
$_good_email = "";
$_response = "";
$_num_col_users = 0;
$_table_users = array('id_users' =>'','nom' =>'','cognoms' =>'','direccio' =>'','poblacio' =>'','provincia' =>'','cp' =>'','telefon' =>'','data_naixement' =>'','password' =>'','email' =>'','data_alta' =>'');
$_table_users_profiles = array('id_users' =>'', 'newsletter' =>'', 'password_expired' =>'');

$_table_keys_users = array_keys($_table_users);
$_table_keys_users_profiles = array_keys($_table_users_profiles);


/*
if (!isset($_POST["email"]))
{
	$string = "Faltan variables";
	set_response("status=ko&error=$string");
	send_response_to_client();
	exit;
}else{		
	$_table_users[$_table_keys_users[10]] = trim($_POST["email"]);	
}
*/
//---------------------------
/*
$_table_users[$_table_keys_users[10]] = "jordi@mamutserver.com";
*/
//---------------------------

//-- Obtenemos todo el usuario:



$_conexion = new Conexion();

$_email = trim($_POST["email"]);
$_pass = trim($_POST["pass"]);	

$_row = $_conexion->select_user_PEmail($_email);

/*
$_row = $_conexion->select_user_PEmail($_table_users[$_table_keys_users[10]]);
if ($_row == FALSE)
{
	$string = $_conexion->get_db_error();
	set_response("status=ko");
	send_response_to_client();
	exit;
}
*/

$_string = "&status=ok";
//-- Escribimos todos los datos del usuario:
$_num_col_users = count($_table_users);
for ( $i=1 ; $i<$_num_col_users ; $i++) {
	$stringCol = $_table_keys_users[$i];
	$valueCol = $_row[$stringCol];
	if ( $stringCol != "password") {
		if ($stringCol == "data_naixement") {
			if ( $valueCol == "00000000") {
				$_string .= "&".$stringCol."=";
			}else {
				$_string .= "&".$stringCol."=".substr($valueCol,8,5).substr($valueCol,5,2).substr($valueCol,0,4);
			}
		}else if($stringCol == "data_alta") {
//			$_string .= "&".$stringCol."=".substr($valueCol,8,2).":".substr($valueCol,10,2).":".substr($valueCol,12,2)." ".substr($valueCol,6,2)."/".substr($valueCol,4,2)."/".substr($valueCol,0,4);
			$_string .= "";
		}else {
//****************FALLO del array en el servidor por eso empiezo con "&status..."		
			$_string .= "&".$stringCol."=".$valueCol;
		}
	}
}

//-- Escribimos el profiles del usuario:
$_row = $_conexion->select_profile_TUsersProfiles($_row['id_users']);
$_num_col_users_profiles = count($_table_users_profiles);
for ( $i=1 ; $i<$_num_col_users_profiles ; $i++) {	
	$stringCol = $_table_keys_users_profiles[$i];
	if ( $stringCol != "password_expired") {
		$_string .= "&".$stringCol."=".$_row[$stringCol];
	}
}

set_response($_string);
send_response_to_client();
exit;

//-- Functions of getUsuario.php:

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

function check_sintax_vars($email){
	
	$emailValid = valid_email($email);	
	if ($emailValid == false){
		set_response("status=ko&at=EMAIL&error=El email introducido no es correcto");
		return FALSE;
	}
	return TRUE;
}
//-- end of functions of getUsuario.php

?>
