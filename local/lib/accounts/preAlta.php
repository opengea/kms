<?
require_once('functions.inc.php');
require_once('conexion.class.php');
require_once('email.class.php');

$_conexion = "";
$_good_conection = "";
$_good_email = "";
$_response = "";
$_table_pre_user = array('id_uniq_users','email','fecha_preAlta');


if (!isset($_POST["email"]))
{
	set_response("status=ko&error=faltan variables");
	send_response_to_client();
	exit;
}else{	
	$_table_pre_user[0] = "";
	$_table_pre_user[1] = trim($_POST["email"]);
	$_table_pre_user[2] = "".date('YmdHis',substr(microtime(),11));
}

//-------------------------------------
/*
$_table_pre_user[0] = "";
$_table_pre_user[1] = "jordi@mamutserver.com";
$_table_pre_user[2] = "".date('YmdHis',substr(microtime(),11));
*/
//-------------------------------------

//-- Comprobamos los inputs que sean correctos:
$sintax_ok = check_sintax_vars($_table_pre_user[1]);


if ( $sintax_ok == FALSE){

	send_response_to_client();
	exit;
}

$_conexion = new Conexion();

//-- Comprobamos que no este en la tabla users:

$_row = $_conexion->select_user_PEmail($_table_pre_user[1]);
if ($_row['email'] != trim(""))
{
//	$string = "ya estas registrado, si no recuerdas la contraseña haz click <a href=''>aqui<";
	set_response("status=ko&at=EMAILREPETIDO");
	send_response_to_client();
	exit;
}

//-- Insertamos el usuario en la tabla pre_users:

$_table_pre_user[0] = get_unique_id();
//$_table_pre_user[1] = $_table_pre_user[1];

$_good_conection = $_conexion->insert_preUser($_table_pre_user);

if ($_good_conection == FALSE)
{
	$good_conection = $_conexion->execute_select_query("DELETE FROM pre_users WHERE email = '".$_table_pre_user[1]."'");
	
	$_good_conection = $_conexion->insert_preUser($_table_pre_user);
	
//	$string = $_conexion->get_db_error();
//	set_response("status=ko&at=EMAILREPETIDO&error=");
//	send_response_to_client();
//	exit;
}

//-- Enviamos el email de confirmacion:

$_email = new Email("registros@scalextric.es", $_table_pre_user[1], "Completa tu registro", ""
			."<HTML>"
			."<HEAD>"
			."</HEAD>"
			."<BODY bgColor=#ffffff>"
			."<FONT face=Arial size=2><BR>"
//			."Hola ".$_table_pre_user[1].",<br>"
			."Haz clic <A href='http://www.scalextric.es/services/registros/confirmacion.php?id=".$_table_pre_user[0]."'>aquí</A>"
			." para confirmar tu registro a la lista de correo Scalextric."
			."<BR><BR>"
			."Esperamos que disfrutes de nuestro servicio!"
			."<BR>&nbsp; <BR>Atentamente,"
			."<BR>Scalextric"
			."</FONT>"
			."</BODY>"
			."</HTML>", 1);

			
$_good_email = $_email->send();
if ($_good_email == FALSE){

	$_good_conection = $_conexion->delete_preUser($_table_pre_user[0]);

	$string ="no se ha podido enviar el email, se deberá registrar de nuevo";
	set_response("status=ko&at=ENVIOEMAIL&error=$string");
	send_response_to_client();
	exit;
}
set_response("status=ok");
send_response_to_client();
exit;

//-- Functions of preAlta.php:

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
		set_response("status=ko&at=EMAIL&error=el email introducido no es correcto");
		return FALSE;
	}
	return TRUE;
//-- end of functions of preAlta.php	
}
?>
