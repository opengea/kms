<?
require_once('conexion.class.php');
require_once('leerWeb.inc.php');
require_once('email.class.php');

$_conexion = "";
$_query = "";
$_response = "";
$_params = "";
$_table_users = array('id_users','nom','cognoms','direccio','poblacio','provincia','cp','telefon','data_naixement','password','email','data_alta');
$_table_users_profiles = array('id_users','newsletter','password_expired');
$_table_mailing_grups = array('id_grups','comentario','sentencia_sql');
$_table_mailing_enviats = array('id_mailing_enviats','comentario','para','de','copia','cuerpo','total_users','fecha');


			
$_comentario = trim($_GET["comentario"]);
$_from = trim($_GET["from"]);
$_grupo = trim($_GET["grupo"]);
$_asunto = trim($_GET["asunto"]);
$_urlBody = trim($_GET["urlBody"]);
$_isPhp = trim($_GET["isPhp"]);
$_params = $_GET["params"];


//echo $_body;
//exit;

$_conexion = new Conexion();

//-- Selecionamos la sentencia de dicho grupo:	
	$row = $_conexion->select_sqlQuery_gruposEnvios($_grupo);
	if ($row == FALSE)
	{
		$string = $_conexion->get_db_error();
		set_response("status=ko&at=DB&error=$string");
		send_response_to_client();
		exit;
	}

//-- Ejecutamos la sentencia que corresponde a dicho grupo:	
	$sql = $_conexion->execute_select_query($row['sentencia_sql']);
	if ($sql == FALSE)
	{
		//-- En teoria es imposible ya que la "sentencia_sql" es correcta.
	}

//-- Enviamos el email al grupo correspondiente:
	$_table_mailing_enviats[0] = "";
	$_table_mailing_enviats[1] = $comentario;
	$_table_mailing_enviats[2] = $grupo;
	$_table_mailing_enviats[3] = $from;
	$_table_mailing_enviats[4] = "";
	$_table_mailing_enviats[5] = rawurlencode($body);
	$_table_mailing_enviats[6] = "".date('YmdHis',substr(microtime(),11));
	
	
	$total = mysql_num_rows($sql);
	
	if ($_isPhp != "1") {
		$_body = getWeb($_urlBody);
	}
	$nAInsertar = $total%100;
	$i=0;
	while($row = mysql_fetch_assoc($sql))
	{
		if ($_isPhp == "1") {
			$_params = eregi_replace('\\\\','',$_params);
			$_params = unserialize($_params);
	
			$_urlBody .= "?";
			$_keys_params = array_keys($_params);
			$_values_params = array_values($_params);
			$lenght = count($_keys_params);
			for ( $i = 0 ; $i<$lenght ; $i++ ) {
				if ($i != ($lenght-1)) {
					$_urlBody .= "".$_keys_params[$i]."=".$_values_params[$i]."&";
				}else {
					$_urlBody .= "".$_keys_params[$i]."=".$_values_params[$i];
				}
			}
			$_body = getWeb($_urlBody);
		}
/*
		$_email = new Email($_from, $row['email'], $_asunto, $_body, 1);
		$_good_email = $_email->send();
		if ($_good_email == TRUE){
			
		}else {
		
		}
*/
		$_conexion->execute_select_query("INSERT INTO pruebas (email) VALUES ('".$row['email']."')");
		if ($i == $nAInsertar) {
			
			//$_conexion->execute_select_query("INSERT INTO mailingXXX VALUES() SET ''");
			$i =0;
		}
		$i++;
	}
	
	$_conexion->insert_emailsEnviados($_table_mailing_enviats);
echo "FIN";
exit;
//-- Updatamos la tabla 	
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

//-- end of functions of forgotPass.php
?>
