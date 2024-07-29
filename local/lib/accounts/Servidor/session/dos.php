<?PHP
require_once('userOnline2.inc.php');

if (!session_start()){
//	Error al iniciar la sesion.....	
	echo "no se ha podido iniciar la session";
	exit;
}
if (!session_is_registered('_userOnlineS')) {
    echo "<html>No tienes ninguna session con nosotros";
    echo "<html>\nVuelve a <a href='uno.php'>uno</a>'";
    exit;
}

$_userOnline = unserialize($_userOnlineS);
//echo "<html>\nHola <n>".$_userOnline->get_username()."</n>\n";
//echo "Tu id es: ".$_userOnline->get_id_user()."</html>";
$count = $_userOnline->get_count();
if ( $count >= 3 ){
	session_destroy();
	echo "<html>\nHola has salido\n";
	exit;
}
echo "<html>\nHola has entrado: <n>".$count." veces.</n>\n";
$_userOnline->set_count();
$_userOnlineS = serialize($_userOnline);
session_register("_userOnlineS");
exit;
?>