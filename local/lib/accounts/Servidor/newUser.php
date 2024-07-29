<?
require_once('headers.inc.php');
require_once('functions.inc.php');
require_once('conexion.inc.php');
require_once('email.inc.php');

//$_username = "";
//$_pass = "";
//$_email = "";
//$_id_preuser = "";

$_conexion = "";
$_good_conection = "";
$_good_email = "";
$_response = "";
$_table_preUser = array('username','pass','email','id_preuser','avisar');


if (!isset($_POST["username"]) || !isset($_POST["pass"]) || !isset($_POST["email"]) || !isset($_POST["avisar"]))
{
	set_response("status=error");
	send_response_to_client();
	exit;
}else{	
	$_table_preUser[0] = trim($_POST["username"]);
	$_table_preUser[1] = trim($_POST["pass"]);
	$_table_preUser[2] = trim($_POST["email"]);
	$_table_preUser[4] = trim($_POST["avisar"]);	
}

/*
$_table_preUser[0] = "virgilio";
$_table_preUser[1] = "123456";
$_table_preUser[2] = "vgarcia@dserver.net";
*/
//-- Comprobamos los inputs que sean correctos:
//$sintax_ok = check_sintax_vars($_username, $_pass, $_email);
$sintax_ok = check_sintax_vars($_table_preUser[0], $_table_preUser[1], $_table_preUser[2]);
if ( $sintax_ok == FALSE){
	send_response_to_client();
	exit;
}
//-----------------------------------
if ( $_table_preUser[4] == "1" || $_table_preUser[4] == "0") {	
}else {
	set_response("status=error");
	send_response_to_client();
	exit;
}
//-----------------------------------
//	set_response("status=error");
//	send_response_to_client();

$_conexion = new Conexion();

//-- Comprobamos que no este en la tabla users:

$_row = $_conexion->select_user_from_users($_table_preUser[0], $_table_preUser[2]);
if ($_row['username'] != "")
{
//	echo "row[username] != ''\r\n";
	$string = $_conexion->get_db_error();
	set_response("status=ko&at=DB&error=$string");
	send_response_to_client();
	exit;
}

//-- Insertamos el usuario en la tabla pre_users:

$_table_preUser[1] = md5($_table_preUser[1]); 	//$_pass = md5($_pass);
$_table_preUser[3] = get_unique_id();			//$_id_preuser = get_unique_id();
$_good_conection = $_conexion->insert_preUser($_table_preUser);
//$_good_conection = $_conexion->insert_preuser($_username, $_pass, $_email, $_id_preuser);
if ($_good_conection == FALSE)
{
	$string = $_conexion->get_db_error();
	set_response("status=ko&at=DB&error=$string");
	send_response_to_client();
	exit;
}

//-- Enviamos el mail de confirmacion:

//$_email = new Email("prueba@dserver.net", $_email, "Confirm your account", ""
//			."Hi ".$_username.",<br>"
$_email = new Email("prueba@dserver.net", $_table_preUser[2], "Confirm your account", ""
			."Hi ".$_table_preUser[0].",<br>"			
			."<br>"
			."	Gracias por utilizar nuestros servicios web's....<br>"
//			."  haga click <a href='http://dserver.net/REAL/confirmacion.php?id=".$_id_preuser."'>aqui</a>"
			."  haga click <a href='http://dserver.net/REAL/confirmacion.php?id=".$_table_preUser[3]."'>aqui</a>"
			." para confirmar su cuenta de usuario.", 1);
			
$_good_email = $_email->send();
if ($_good_email == TRUE){
	set_response("status=ok");
	send_response_to_client();
//	exit;
}else {
//	$_good_conection = $_conexion->delete_preuser($_id_preuser);
	$_good_conection = $_conexion->delete_preUser($_table_preUser[3]);
/*	if ($_good_conection == false)
	{
		$string = $_conexion->get_mysql_error();
//		$_conexion->insert_problem(con el usuario ....., en la tabla....., el error .....);
		set_response("status=ko&at=DB&error=$string");
		send_response_to_client();
		exit;
	}*/
	$string ="En su cuenta de correo";
	set_response("status=ko&at=ENVIOEMAIL&at2=EMAIL&error=$string");
	send_response_to_client();
	exit;
}

//-- Functions of newUser.php:

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

function check_sintax_vars($nickname, $password, $email){
	
	$nicknameValid = valid_userName($nickname);
	$passwordValid = valid_password($password);
	$emailValid = valid_email($email);
	
	if ($nicknameValid == false){
		set_response("status=ko&at=SINTAXVAR&at2=USERNAME&error=El username introducido no es correcto");
		return FALSE;
	}
	if ($passwordValid == false){
		set_response("status=ko&at=SINTAXVAR&at2=PASS&error=El password introducido no es correcto");
		return FALSE;
	}
	if ($emailValid == false){
		set_response("status=ko&at=SINTAXVAR&at2=EMAIL&error=El email introducido no es correcto");
		return FALSE;
	}
	return TRUE;
//-- end of functions of newUser.php	
}
?>
