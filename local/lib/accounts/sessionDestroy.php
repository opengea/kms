<?
if (!session_start()){
//	Error al iniciar la sesion.....	
	echo "no se ha podido iniciar la session";
	exit;
}
if ( session_destroy() ){
	echo "status=ok";
//	echo "<head>\n<meta http-equiv=\"refresh\" content=\"0;URL=index.html\">\n</head>\n";
	exit;
}else {
	echo "status=ko&error=No se ha podido salir, por seguridad cierre esta ventana";
}
?>