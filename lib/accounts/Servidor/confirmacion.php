<?
require_once('headers.inc.php');
require_once('conexion.inc.php');
require_once('functions.inc.php');

ECHO "<TITLE>DServer.net  Confirmacion </TITLE><BR>";

$_id_preuser = "";
$_conexion = "";
$_query = "";
$_id_user = "";
$_table_users = array('username','pass','name','apellido','direccion','codigoPostal','telefono','email','id_user');
$_table_usersProfiles = array('id_user','change_pass', 'avisar');
$_num_col_users = count($_table_users);

if (!isset($_GET["id"]))
{
	ECHO "NO SE HA ENCONTRADO LA VARIABLE \"ID\"";
	exit;
}else{
	$_id_preuser = trim($_GET["id"]);
}

//$_id_preuser = "99d9d8b44a64c5dee1d58cb5da86db752725";

$_conexion = new Conexion();
$_row = $_conexion->select_preuser($_id_preuser);

if ($_row == FALSE)
{
	//redirigir algun sitio
	ECHO "NO SE HA ENCONTRADO LA \"ID\" ".$_id_preuser;
	exit;
}

for ($i =0 ; $i<$_num_col_users ; $i++) {
	$_table_users[$i] = null;
}
$_table_users[0] = $_row['username'];
$_table_users[1] = $_row['pass'];
$_table_users[7] = $_row['email'];
$_table_usersProfiles[2] = $_row['avisar'];
//-- Añadimos el usuario a la tabla 'users':

$_good_conection = $_conexion->insert_user($_table_users);

if ($_good_conection == FALSE)
{
// El único problema que puede haber es que se pierda la conexion con el servidor de base de datos
//		o que el servidor no responda... etc...

	ECHO "".$_conexion->get_db_error();
	exit;
}

//-- Obtenemos el identificador de usuario:

$_row = $_conexion->select_id_user_from_users_PEmail($_table_users[7]);
if ($_row == FALSE)
{
// El único problema que puede haber es que se pierda la conexion con el servidor de base de datos
//		o que el servidor no responda... etc...

	ECHO "".$_conexion->get_db_error();
	exit;
}
$_table_usersProfiles[0] = $_row[0];

//-- Insertamos el id_user en su perfil (usersProfiles) de usuario:

$_good_conection = $_conexion->insert_userProfile($_table_usersProfiles);
if ($_good_conection == FALSE)
{
// El único problema que puede haber es que se pierda la conexion con el servidor de base de datos
//		o que el servidor no responda... etc...

	ECHO "".$_conexion->get_db_error();
	exit;
}

//-- Borramos al usuario de la tabla preUser:

$_good_conection = $_conexion->delete_preuser($_id_preuser);
if ($_good_conection == FALSE)
{
	//ha ocurrido un problema al borrar el usuario .... en la tabla preusers
	ECHO "ha ocurrido un problema al borrar el usuario .... en la tabla preusers";
	exit;
}

//redirigir a la loginacion------
ECHO "Se ha registrado con éxito<br>";
ECHO "Haga click <a href='http://dserver.net/REAL'>aqui</a> para comenzar";
?>
