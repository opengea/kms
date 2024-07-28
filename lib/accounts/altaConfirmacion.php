<?
require_once('functions.inc.php');
require_once('conexion.class.php');

$_conexion = "";
$_good_conection = "";
$_good_email = "";
$_response = "";
$_id_user = "";
$_unique_id = "";
$_table_users = array('id_users','nom','cognoms','direccio','poblacio','provincia','cp','telefon','data_naixement','password','email','data_alta');
$_table_users_profiles = array('id_users','newsletter','password_expired');


if (!isset($_POST["id"]) || !isset($_POST["nom"]) || !isset($_POST["cognoms"]) || !isset($_POST["direccio"]) || !isset($_POST["poblacio"]) || !isset($_POST["provincia"]) || !isset($_POST["cp"]) || !isset($_POST["data_naixement"]) || !isset($_POST["password"]) || !isset($_POST["email"]))
{
	$string = "Faltan variables";
	set_response("status=ko&error=$string");
	send_response_to_client();
	exit;
}else{
	$id = trim($_POST["id"]);
	$_table_users[0] = "";
	$_table_users[1] = trim($_POST["nom"]);
	$_table_users[2] = trim($_POST["cognoms"]);
	$_table_users[3] = trim($_POST["direccio"]);
	$_table_users[4] = trim($_POST["poblacio"]);
	$_table_users[5] = trim($_POST["provincia"]);
	$_table_users[6] = trim($_POST["cp"]);
	$_table_users[7] = trim($_POST["telefon"]);
	$_table_users[8] = trim($_POST["data_naixement"]);
	$_table_users[9] = trim($_POST["password"]);
	$_table_users[10] = trim($_POST["email"]);
	$_table_users[11] = date('YmdHis',substr(microtime(),11));
	
	$_table_users_profiles[0] = "";
	$_table_users_profiles[1] = "1";//trim($_POST["newsletter"]);
	$_table_users_profiles[2] = "0";

	$numColumns = count($_table_users);
	for ( $i=0 ; $i<$numColumns ; $i++) {
		if ($_table_users[$i] == "7") {
			$_table_users[$i] = "NULL";
		}
	}
}

//---------------------------
/*
$numColumns = count($_table_users);
for ($i = 0 ; $i<$numColumns ; $i++){
		$_table_users[$i] = "NULL";
}
$_table_users[1] = "Virgi";
//$_table_users[2] = "";
//$_table_users[8] = "06021977";
$_table_users[9] = "1234567";
$_table_users[10] = "jordi@mamutserver.com";
$_table_users[11] = date('YmdHis',substr(microtime(),11));
$_table_users_profiles[1] = "1";
$id = "22d5c1979968a2f15f1b23fcb1e41a0b1091";
*/
//---------------------------

$_conexion = new Conexion();

//-- Comprobamos que la id exista:

$query_getId_usersIntermedios = "SELECT * FROM users_preusers WHERE id_uniq_users = '$id'";
$sql = $_conexion->execute_select_query($query_getId_usersIntermedios);
$row = mysql_fetch_array($sql);

if ($row['email'] == trim("")) {
	set_response("status=ko&error=no existe el registro. Por favor vuelva a registrarse.");
	send_response_to_client();
	exit;
}
$_table_users[10] = $row['email'];

//-- Comprobamos los inputs que sean correctos:

$sintax_ok = check_sintax_vars($_table_users[1], $_table_users[9], $_table_users[10], $_table_users[8], $_table_users_profiles[1]);
if ( $sintax_ok == FALSE){
	//$string = "Error de sintaxis";
	//set_response("status=ko&error=$string");
	send_response_to_client();
	exit;
}

//-- Cambiamos el pass a modo cifrado:
$_table_users[9] = md5($_table_users[9]);

//-- Cambiamos el formato de la fecha de nacimiento:
if ($_table_users[8] != "NULL") {
	$_table_users[8] = "".substr($_table_users[8],4).substr($_table_users[8],2,2).substr($_table_users[8],0,2);
}

//-- Insertamos el usuario a la tabla 'users':

$_good_conection = $_conexion->insert_user_TUsers($_table_users);

if ($_good_conection == FALSE)
{
	$string = $_conexion->get_db_error();
	set_response("status=ko&at=EMAILREPETIDO&error=$string");
	send_response_to_client();
	
	//-- Se borrara de la tabla intermedia:
		$query_delete = "DELETE FROM users_preusers WHERE id_uniq_users = '$id' LIMIT 1";
		$_conexion->execute_select_query($query_delete);
	
	exit;
}

//-- Insertamos el profile del usuario a la tabla 'users_profiles':
$_row = $_conexion->select_user_PEmail($_table_users[10]);
if ($_row == FALSE)
{
	//-- En teoría este caso es imposible, ya que lo acabamos de insertar.

	$string = $_conexion->get_db_error();
	set_response("status=ko&at=EMAIL&error=$string");
	send_response_to_client();
	exit;

}
$_table_users_profiles[0] = $_row['id_users'];
$_table_users_profiles[1] = "1";
$_table_users_profiles[2] = "0";
$_good_conection = $_conexion->insert_profile_TUsersProfiles($_table_users_profiles);
if ($_good_conection == FALSE)
{
	//-- En teoría este caso es imposible....
	//set_response("status=ko&error=Gracias por registrarte");
	//send_response_to_client();
   // exit;
}


//-- Se borrara de la tabla intermedia:
$query_delete = "DELETE FROM users_preusers WHERE email = '".$_table_users[10]."'";
$_conexion->execute_select_query($query_delete);
//-------------------------------
/*
$query_count = "SELECT COUNT(*) FROM users";
$select_count = $_conexion->execute_select_query($query_count);
$row_count = mysql_fetch_array($select_count);
if ($row_count['count(*)'] == 630) {
$body = "Hay ".$select_count['count'];
		
$email = new Email("users@scalextric.es", "vgarcia@crazysms.com", "", $body, 0);
$_good_email = $email->send();
}
*/
//-------------------------------


set_response("status=ok&at=ok");
send_response_to_client();
exit;

//-- Functions of altaConfirmacion.php:

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

function check_sintax_vars($nickname,$pass,$email,$fecha_nacimiento,$mailingList){
	
	$nicknameValid = valid_userName($nickname);
	
	if ($pass == "NULL") {
		$passValid = FALSE;
	}else {
		$passValid = valid_password($pass);
	}
	$emailValid = valid_email($email);
	
	if ($fecha_nacimiento != "NULL") {
		$fechaValid = valid_fecha($fecha_nacimiento);
	}else {
		$fechaValid = TRUE;
	}
	
	if ($mailingList == "0" || $mailingList == "1") {
		$mailingListValid = TRUE;
	}else {
		$mailingListValid = FALSE;
	}
	
	if ($nicknameValid == false){
		set_response("status=ko&at=USERNAME&error=el nombre introducido no es correcto");
		return FALSE;
	}
	
	if ($pass == FALSE) {
		set_response("status=ko&at=PASS&error=la contraseña introducida no es correcta");
		return FALSE;
	}
	
	if ($emailValid == false){
		set_response("status=ko&at=EMAIL&error=el email introducido no es correcto");
		return FALSE;
	}
	if ($fechaValid == false){
		set_response("status=ko&at=FECHA&error=la fecha introducida no es correcta, se rige: ddmmaaaa");
		return FALSE;
	}
	if ($mailingListValid == false) {
		set_response("status=ko&at=MAILINGLIST&error=el valor introducido no es correcto");
		return FALSE;
	}
	return TRUE;	
}
//-- end of functions of altas.php
?>
