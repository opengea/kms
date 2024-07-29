<?
set_time_limit(0);
$_id_preuser = "";
$_conexion = "";
$_query = "";
$_id_user = "";


if (!isset($_GET["id"]))
{
	ECHO "NO SE HA ENCONTRADO LA VARIABLE \"ID\"";
	exit;
}else{
	$_id_preuser = trim($_GET["id"]);
}

/*
$_id_preuser = "994f0bde48639c2a8ea56fe177cc5825752";
*/

connect();

$query = "SELECT * FROM users_preusers WHERE id_uniq_users = '$_id_preuser' limit 1";
//$_row = mysql_query($query);
$_row = mysql_fetch_array(mysql_query($query));
if($_row['email'] == trim("")) {
	//-- La id enviada no existe -------------
	echo "status=ko&error=Ya estás registrado.";
	exit;
}

echo "status=ok&email=".$_row['email'];

function connect() {
	
	$_host1 = 'localhost';
	$_dbuser1 = 'tecnitoys';
	$_dbpass1 = 'tecniweb';
	$_dbname1 = 'tecnitoys';

	$_connect = @mysql_connect($_host1,$_dbuser1,$_dbpass1) or die(false);
	$_connect = mysql_select_db($_dbname1);
}
?>
