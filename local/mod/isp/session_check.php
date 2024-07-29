<? 
   session_start();
   if (!$_SESSION['user_logged']) {
   echo "Session expired or user not logged. Please, autenticate first";exit;
   header ('location: http://intranet.intergrid.cat');
   }
 ?>
