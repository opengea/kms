<?
//require_once('headers.inc.php');
require_once('conexion.class.php');
require_once('functions.inc.php');
require_once('email.class.php');
require_once('passAleatorio2.inc.php');

$_conexion = "";
$_query = "";
$_email = "";
$_new_pass = "";
$_response = "";
$_table_users = array('id_users','nom','cognoms','direccio','poblacio','provincia','cp','telefon','data_naixement','password','email','data_alta');
$_table_users_profiles = array('id_users','newsletter','password_expired');


if (!isset($_POST["email"]))
{
	set_response("status=ko&error=faltan variables");
	send_response_to_client();
	exit;
}else{
	$_email = trim($_POST["email"]);
}

//------------------------------------
/*
$_email = "vgarcia@mamutserver.com";
*/
//------------------------------------

$sintax_ok = check_sintax_vars($_email);
if ( $sintax_ok == FALSE){
	send_response_to_client();
	exit;
}

$_conexion = new Conexion();

//-- Comprobamos que tenemos la dirección de email:

$_row = $_conexion->select_user_PEmail($_email);

if ($_row['email'] == trim(""))
{
	set_response("status=ko&error=");
	send_response_to_client();
	exit;
}

$_table_users_profiles[0] = $_row['id_users'];
$_table_users_profiles[1] = 'NULL';
$_table_users_profiles[2] = '1';

/*-- He decido cambiar primero el 'change_pass' del usersProfiles, ya que
		es primordial que ésta tabla no falle, ya que sino, el usuario no podria 
		cambiar el 'new_pass' que le hemos enviado. Por otra parte, si surgiese
		alguna excepcion despues de este paso, el usuario no se enteraría ya que
		una vez logineado correctamente, se le pedíra que cambiase el password.
*/

//$_good_conection = $_conexion->update_change_pass_in_usersProfiles($_row['id_users'], 1);
//$_good_conection = $_conexion->update_users_profiles($_table_users_profiles);
$_good_conection = $_conexion->update_profile_TUsersProfiles($_table_users_profiles);

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

$_table_users[0] = $_row["id_users"];
$_table_users[1] = $_row["nombre"];
$_table_users[2] = $_row["apellidos"];
$_table_users[3] = $_row["direccion"];
$_table_users[4] = $_row["poblacion"];
$_table_users[5] = $_row["provincia"];
$_table_users[6] = $_row["cp"];
$_table_users[7] = $_row["telefono"];
$_table_users[8] = $_row["fecha_nacimiento"];
$_table_users[9] = $_new_pass_md5;
$_table_users[10] = $_row["email"];
$_table_users[11] = $_row["fecha_alta"];
	
//echo "nombre: ".$_row["nombre"]."--apellidos: ".$_row["apellidos"];
//$_good_conection = $_conexion->update_pass_in_users($_email, $_new_pass_md5);
$_good_conection = $_conexion->update_user_TUsers($_table_users);
if ($_good_conection == FALSE)
{
	$string = $_conexion->get_db_error();
	set_response("status=ko&at=DB&error=$string");
	send_response_to_client();
	exit;
}
//

$_email = new Email("registros@scalextric.es", $_email, "Tu contraseña", ""
			."<br>"			
			."  tu nueva contraseña es:<br><br>"
			."  <b>".$_new_pass."</b><br><br>"
//-- Si falla el registro a la tabla usersProfiles			."  Le recordamos que puede cambiar de password dentro del menú, datos personales."
			."  Haz clic <a href ='http://www.scalextric.es/services/registros/micuenta.html'>aquí</a> para entrar.<br>"
			."", 1);
			
$_good_email = $_email->send();
if ($_good_email == TRUE){
	set_response("status=ok");
	send_response_to_client();
}else {
//	$string ="Ha habido un error en el envio por email de su nuevo password, por favor llame al 904.00.00.00 para saber su pass";
	$string ="";
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
