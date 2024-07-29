<?
require_once('headers.inc.php');
require_once('conexion.inc.php');
require_once('functions.inc.php');
require_once('email.inc.php');
require_once('passAleatorio2.inc.php');

$_conexion = "";
$_query = "";
$_email = "";
$_new_pass = "";
$_response = "";

/*if (!isset($HTTP_POST_VARS["email"]))
{
//	ECHO "NO SE HA ENCONTRADO LA VARIABLE \"email\"";
	exit;
}else{
	$_email = trim($HTTP_POST_VARS["email"]);
}
*/
$_email = "vgarcia@dserver.net";
$sintax_ok = check_sintax_vars($_email);
if ( $sintax_ok == FALSE){
	send_response_to_client();
	exit;
}

$_conexion = new Conexion();

//-- Comprobamos que tenemos la dirección de email:

$_row = $_conexion->select_user_by_email($_email);
if ($_row == FALSE)
{
	set_response("status=ok");
	send_response_to_client();
	exit;
}

/*-- He decido cambiar primero el 'change_pass' del usersProfiles, ya que
		es primordial que ésta tabla no falle, ya que sino, el usuario no podria 
		cambiar el 'new_pass' que le hemos enviado. Por otra parte, si surgiese
		alguna excepcion despues de este paso, el usuario no se enteraría ya que
		una vez logineado correctamente, se le pedíra que cambiase el password.
*/
$_good_conection = $_conexion->update_change_pass_in_usersProfiles($_row['id_user'], 1);
if ($_good_conection == FALSE)
{
//	Po cualquier motivo no se ha podido marcar que el usuario cambie el pass la primera vez que 
//		que entre, por eso se le tendrá que avisar que para su seguridad es aconsejable que lo 
//		cambie.
	
/*	$string = $_conexion->get_db_error();
	$int = $_conexion->get_db_errno();
	echo "".$int;
	set_response("status=ko&at=DB&error=$string");
	send_response_to_client();
	exit;
*/
}

//-- Modificamos el $_new_pass en la tabla users:

$_new_pass = get_pass_aleatorio();
$_new_pass_md5 = md5($_new_pass);
$_good_conection = $_conexion->update_pass_in_users($_email, $_new_pass_md5);

if ($_good_conection == FALSE)
{
	$string = $_conexion->get_db_error();
	set_response("status=ko&at=DB&error=$string");
	send_response_to_client();
	exit;
}
//
//
//
$_email = new Email("prueba@dserver.net", $_email, "Forgot your password", ""
			."Hi ".$_row['username'].",<br>"
			."<br>"			
			."  Le hemos puesto el siguiente password:<br><br>"
			."  <b>".$_new_pass."</b><br><br>"
			."  La proxima vez que entre se le pedirá cambiarlo."
//-- Si falla el registro a la tabla usersProfiles			."  Le recordamos que puede cambiar de password dentro del menú, datos personales."
			."  Haga click <a href ='http://dserver.net/REAL/'>aqui</a> para entrar.<br>"
			."	Gracias por utilizar nuestros servicios web's....<br>", 1);
			
$_good_email = $_email->send();
if ($_good_email == TRUE){
	set_response("status=ok");
	send_response_to_client();
}else {
	$string ="Ha habido un error en el envio por email de su nuevo password, por favor llame al 904.00.00.00 para saber su pass";
	set_response("status=ko&at=ENVIOEMAIL&error=$string");
	send_response_to_client();
	exit;
}

//-- Functions privates of forgotPass.php

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
		set_response("status=ko&at=SINTAXVAR&at2=EMAIL&error=El email introducido no es correcto");
		return FALSE;
	}
	return TRUE;
}
//-- end of functions of forgotPass.php
?>