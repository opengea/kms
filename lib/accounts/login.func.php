<?
//require_once('headers.inc.php');
require_once('functions.inc.php');
require_once('conexion.class.php');
require_once('userOnline.class.php');

$_email = "";
$_pass = "";
$_response ="";
$_row = null;
$_conexion = null;
$_userOnline = null;


if (!isset($_POST["email"]) || !isset($_POST["pass"]))
{
	set_response("status=ko&error=faltan variables");
	send_response_to_client();
	exit;
}else{
	$_email = trim($_POST["email"]);
	$_pass = trim($_POST["pass"]);	
}


//-- Comprobamos los inputs que sean correctos:

$sintax_ok = check_sintax_vars($_email, $_pass);
if ( $sintax_ok == FALSE){
	send_response_to_client();
	exit;
}

$_conexion = new Conexion();

//-- Comprobamos los datos recibidos en la tabla users:
$_row = $_conexion->select_user_PEmail($_email);
if ( $_row['email'] == "")
{
	set_response("status=ko&at=EMAIL&error=Este usuario no está registrado.");
	send_response_to_client();
	exit;
}
$_pass = md5($_pass);
if ($_pass != $_row['password']) {
	set_response("status=ko&at=PASS&error=La contraseña es incorrecta.");
	send_response_to_client();
	exit;	
}

//-- Aqui habrá que redirigirlo a la página de la consola,
//		
//		Podríamos crear un objeto session con el usuario, de esta manera, tendremos la certeza 
//		que todos los usuarios que estan dentro de la consola han pasado por el login.

//--- Empezamos con las pruebas -----------------

if (!session_start()){
//	Error al iniciar la sesion.....	
	exit;
}

$_userOnline = new UserOnline($_row);
$_userOnlineS = serialize($_userOnline);
session_register("_userOnlineS");
//echo "<html>\n\n";
//echo "<head>\n<meta http-equiv=\"refresh\" content=\"0;URL=dos.php\">\n</head>\n";
//echo "<body></body>\n</html>\n";
//echo "<body>Automatic redirect to <a href=\"dos.php\">dos.php</a>.\n</body>\n</html>\n";


set_response("status=ok");
send_response_to_client();

//-- Functions of login.php:

function send_response_to_client(){
	global $_response;
	print $_response;
	set_response("");
}

function set_response($response){
	global $_response;
	$_response = $response;
}
function check_sintax_vars($email, $password) {
	
	$emailValid = valid_email($email);
	$passwordValid = valid_password($password);	
	
	if ($emailValid == false){
		set_response("status=ko&at=EMAIL&error=el email introducido no es correcto.");
		return FALSE;
	}
	if ($passwordValid == false){
		set_response("status=ko&at=PASS&error=la contraseña introducida no es correcta.");
		return FALSE;
	}
	
	return TRUE;
}
//-- end of functions of login.php

?>
