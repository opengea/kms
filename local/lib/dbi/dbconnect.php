<?

   if (!isset($client_account)||$client_account['dbhost']=="") { echo "dbconnect: invalid session";exit; }

   $link_clientdb = mysqli_connect('localhost',$client_account['dbuser'],$client_account['dbpasswd'],$client_account['dbname']);
   if (!$link_clientdb) {
		$link_clientdb = mysqli_connect($client_account['dbhost'],$client_account['dbuser'],$client_account['dbpasswd'],$client_account['dbname']);
		if (!$link_clientdb)  $link_clientdb = mysqli_connect('localhost',$client_account['dbuser'],$client_account['dbpasswd'],$client_account['dbname']);
   }	
   if (!$link_clientdb) die ('can\'t connect to client database server '.$client_account['dbhost'].' with user '.$client_account['dbuser'].': '.mysqli_error($link_clientdb));
	mysqli_query($link_clientdb,"SET NAMES 'utf8'"); 
   //echo $client_account['dbhost'].$client_account['dbuser'].$client_account['dbpasswd'].$client_account['dbname'];

   $_SESSION['dbhost'] = $client_account['dbhost'];
   $_SESSION['dbuser'] = $client_account['dbuser'];
   $_SESSION['dbpasswd'] = $client_account['dbpasswd'];
   $_SESSION['dbname'] = $client_account['dbname'];

?>
