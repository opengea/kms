<?
require_once('headers.inc.php');
require_once('functions.inc.php');
require_once('conexion.inc.php');
require_once('userOnline.inc.php');

$_username = "";
$_pass = "";
$_response ="";
$_usernameRow = "";
$_row = null;
$_conexion = null;
$_userOnline = null;

if (!isset($HTTP_POST_VARS["username"]) || !isset($HTTP_POST_VARS["pass"]))
{
	set_response("status=error");
	send_response_to_client();
	exit;
}else{
	$_username = trim($HTTP_POST_VARS["username"]);
	$_pass = trim($HTTP_POST_VARS["pass"]);	
}

//$_username = "virgilio";
//$_pass = "8k5oj2m";
//-- Comprobamos los inputs que sean correctos:

$sintax_ok = check_sintax_vars($_username, $_pass);
if ( $sintax_ok == FALSE){
	send_response_to_client();
	exit;
}

$_conexion = new Conexion();

//-- Comprobamos los datos recibidos en la tabla users:
$_pass = md5($_pass);
$_row = $_conexion->select_userPass_users($_username, $_pass);
$_usernameRow = $_row['username'];
if ( $_usernameRow == "")
{
//	echo "row[username] != ''\r\n";
	set_response("status=ko");
	send_response_to_client();
	exit;
}

set_response("status=ok");
send_response_to_client();

//-- Aqui habrá que redirigirlo a la página de la consola,
//		
//		Podríamos crear un objeto session con el usuario, de esta manera, tendremos la certeza 
//		que todos los usuarios que estan dentro de la consola han pasado por el login.

//--- Empezamos con las pruebas -----------------
/*
if (!session_start()){
//	Error al iniciar la sesion.....	
	exit;
}

$_userOnline = new UserOnline($_usernameRow);
$_userOnlineS = serialize($_userOnline);
session_register("_userOnlineS");
echo "<html>\n\n";
echo "<head>\n<meta http-equiv=\"refresh\" content=\"0;URL=dos.php\">\n</head>\n";
echo "<body></body>\n</html>\n";
//echo "<body>Automatic redirect to <a href=\"dos.php\">dos.php</a>.\n</body>\n</html>\n";
*/

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
function check_sintax_vars($nickname, $password) {
	
	$nicknameValid = valid_userName($nickname);
	$passwordValid = valid_password($password);	
	
	if ($nicknameValid == false){
		set_response("status=ko&at=SINTAXVAR&at2=USERNAME&error=El username introducido no es correcto");
		return FALSE;
	}
	if ($passwordValid == false){
		set_response("status=ko&at=SINTAXVAR&at2=PASS&error=El password introducido no es correcto");
		return FALSE;
	}
	
	return TRUE;
}
//-- end of functions of login.php

?>