<?PHP
require_once('userOnline2.inc.php');

if (!session_start()){
//	Error al iniciar la sesion.....
	echo "no se ha podido iniciar la session";	
	exit;
}
$_usernameRow = "Virgilio";
$_userOnline = new UserOnline($_usernameRow);
$_userOnlineS = serialize(&$_userOnline);
//$_userOnlineS = serialize($_userOnline);
session_register("_userOnlineS");
echo "<html>\nHolas\n";
echo "<head>\n<meta http-equiv=\"refresh\" content=\"0;URL=dos.php\">\n</head>\n";
echo "<body>Automatic redirect to <a href=\"dos.php\">dos.php</a>.\n</body>\n</html>\n";
exit;
?>