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

//---------------------------
/*
$email= "jordi@mamutserver.com";
*/
//---------------------------

//-- Obtenemos todo el usuario:

//$_row = $_userOnline->get_row();
$_conexion = new Conexion();


$_email = trim($_POST["email"]);
$_pass = trim($_POST["pass"]);	

$_row = $_conexion->select_user_PEmail($_email);



//----------------------------------------------
/*
$_conexion = new Conexion();
$_row = $_conexion->select_user_PEmail($email);
if ($_row == FALSE)
{
	$string = $_conexion->get_db_error();
	set_response("status=ko");
	send_response_to_client();
	exit;
}
*/
//----------------------------------------------

$queryBorrar = "DELETE FROM users_unsubscribe WHERE id_users='".$_row['id_users']."'";
$_conexion->execute_select_query($queryBorrar);

$queryBorrar = "DELETE FROM users_profiles WHERE id_users='".$_row['id_users']."'";
$_conexion->execute_select_query($queryBorrar);

$queryBorrar = "DELETE FROM users WHERE id_users='".$_row['id_users']."'";
$_conexion->execute_select_query($queryBorrar);

// en teoria no existeix de preusers perque quan s'ha donat d'alta s'ha tret, però ho borrem per si hi ha hagut algun error a l'alta
$queryBorrar = "DELETE FROM users_preusers WHERE email='".$_email."'";;
$_conexion->execute_select_query($queryBorrar);

set_response("status=ok");
send_response_to_client();
exit;

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
?>
