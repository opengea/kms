<?
//require_once('headers.inc.php');
require_once('functions.inc.php');
require_once('conexion.class.php');
//require_once('email.class.php');
require_once('userOnline.class.php');

if (!session_start()){
//	Error al iniciar la sesion.....	
	$string = "no se ha podido iniciar la session";
	set_response("mystatus=ko&at=SESSION&error=$string");
	send_response_to_client();
	exit;
}
if (!session_is_registered('_userOnlineS')) {
    $string = "La session ha caducado";
	set_response("mystatus=ko&at=SESSION&error=$string");
	send_response_to_client();
	exit;
}
$_userOnline = unserialize($_userOnlineS);

$_conexion = "";
$_good_conection = "";
$_good_email = "";
$_response = "";
$_id_user = "";
$_table_users = array('id_users','nom','cognoms','direccio','poblacio','provincia','cp','telefon','data_naixement','password','email','data_alta');
$_table_users_profiles = array('id_users','newsletter','password_expired');


if (!isset($_POST["nom"]) || !isset($_POST["cognoms"]) || !isset($_POST["direccio"]) || !isset($_POST["poblacio"]) || !isset($_POST["provincia"]) || !isset($_POST["cp"]) || !isset($_POST["telefon"]) || !isset($_POST["data_naixement"]) || !isset($_POST["password"]) || !isset($_POST["email"]) || !isset($_POST["newsletter"]))
{
	$string = "Faltan variables";
	set_response("mystatus=ko&error=$string");
	send_response_to_client();
	exit;
}else{	
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
//	$_table_users[11] = date('YmdHis',substr(microtime(),11));
//	$_table_users[11] = "7";

//-- Profiles del usuario:	
	$_table_users_profiles[0] = "";
	$_table_users_profiles[1] = trim($_POST["newsletter"]);
	$_table_users_profiles[2] = "0";
	
	$numColumns = count($_table_users);
	for ( $i=0 ; $i<$numColumns ; $i++) {
		if ($_table_users[$i] == "7") {
			$_table_users[$i] = "";
		}
	}
}


//---------------------------
/*
$numColumns = count($_table_users);
for ($i = 0 ; $i<$numColumns ; $i++){
		$_table_users[$i] = "";
}
$_table_users[1] = "Virgis";
$_table_users[2] = "Garcia";
$_table_users[8] = "06021000";
//$_table_users[9] = "123456";
$_table_users[10] = "vgarcia@mamutserver.com";
$_table_users_profiles[1] = "1";
$_table_users_profiles[2] = "0";
*/
//---------------------------

$_conexion = new Conexion();
//------------------------------------------------------------
/*
$_row = $_conexion->select_user_PEmail($_table_users[10]);
if ($_row == FALSE)
{
	$string = $_conexion->get_db_error();
	set_response("mystatus=ko&at=DB&error=$string");
	send_response_to_client();
	exit;
}
*/
//------------------------------------------------------------ ^^
//-- Comprobamos los cambios realizados:
//$_row = $_userOnline->get_row();
$_email = trim($_POST["currentEmail"]);
$_pass = trim($_POST["currentPass"]);	

$_row = $_conexion->select_user_PEmail($_email);



$_table_users2 = array('id_users','nom','cognoms','direccio','poblacio','provincia','cp','telefon','data_naixement','password','email','data_alta');

$_num_col_users = (count($_table_users2)-1);
for ( $i=1 ; $i<$_num_col_users ; $i++) {
	$stringCol = $_table_users2[$i];
	if ($_row[$stringCol] != "NULL" && $_table_users[$i] == "") {		
		if ($stringCol != 'password') {
			$_table_users[$i] = "NULL";
		}else {
			$_table_users[$i] = $_row[$stringCol];
		}
	}else if ($stringCol == 'password') {
		$_table_users[$i] = md5($_table_users[$i]);
	}
	
}

$_table_users[11] = $_row['data_alta'];

//-- Comprobamos los inputs que sean correctos:

$sintax_ok = check_sintax_vars($_table_users[1], $_table_users[9], $_table_users[10], $_table_users[8], $_table_users_profiles[1]);
if ( $sintax_ok == FALSE){
	send_response_to_client();
	exit;
}

//-- Cambiamos la nomenclatura de la fecha de nacimiento:
if ($_table_users[8] != "NULL") {
	$_table_users[8] = "".substr($_table_users[8],4).substr($_table_users[8],2,2).substr($_table_users[8],0,2);
}

$_table_users[0] = $_row['id_users'];

//-- Updatamos el usuario de la tabla 'users':
$_good_conection = $_conexion->update_user_TUsers($_table_users);
if ($_good_conection == FALSE)
{
	$string = $_conexion->get_db_error();
	set_response("mystatus=ko&at=DB&error=$string");
	send_response_to_client();
	exit;
}

//-- Updatamos el usuario de la tabla 'users_profiles':
$_row_profile = $_conexion->select_profile_TUsersProfiles($_table_users[0]);

if ($_row_profile['newsletter'] != $_table_users_profiles[1]) {
	//-- Se updatara el campo en la tabla profiles:
	$_table_users_profiles[0] = $_table_users[0];
		
	if ($_table_users_profiles[1] == "1"){		
		$_good_conection = $_conexion->update_users_profiles($_table_users_profiles);
		if ($_good_conection == FALSE) {
			//-- Imposible ya que el id_users existe
			exit;
		}
		
		//-- Añadimos también a la "tabla darse_de_baja":
		$_good_conection = $_conexion->insert_idUsers_darseDeBaja($_table_users[0], get_unique_id());
		if ($_good_conection == FALSE) {
		//-- Imposible ya que el id_users es único
			exit;
		}
	}else if ($_table_users_profiles[1] == "0") {
		$_good_conection = $_conexion->update_users_profiles($_table_users_profiles);
		if ($_good_conection == FALSE) {
			//-- Imposible ya que el id_users existe
			exit;
		}
		
		$_row = $_conexion->select_all_darseDeBaja_Pid_users($_table_users[0]);
		if ($_row == TRUE)
		{
			$_good_conection = $_conexion->delete_idUsers_darseDeBaja($_table_users[0]);
			if ($_good_conection == FALSE)
			{
			//-- Ya se encuentra ese "id_users" en la tabla "darse_de_baja"
//				$string = $_conexion->get_db_error();
//				set_response("mystatus=ko&at=DB&error=$string");
//				send_response_to_client();
//				exit;
			}
		}
	}
}
set_response("mystatus=ok");
send_response_to_client();
session_destroy();
exit;

//-- Functions of cambios.php:

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
		set_response("mystatus=ko&at=USERNAME&error=el nombre introducido no es correcto.");
		return FALSE;
	}
	
	if ($pass == FALSE) {
		set_response("mystatus=ko&at=PASS&error=la contraseña introducida no es correcta.");
		return FALSE;
	}
	
	if ($emailValid == false){
		set_response("mystatus=ko&at=EMAIL&error=el email introducido no es correcto.");
		return FALSE;
	}
	if ($fechaValid == false){
		set_response("mystatus=ko&at=FECHA&error=la fecha introducida no es correcta.");
		return FALSE;
	}
	if ($mailingListValid == false) {
		set_response("mystatus=ko&at=MAILINGLIST&error=el valor introducido no es correcto.");
		return FALSE;
	}
	return TRUE;	
}
//-- end of functions of cambios.php
?>
