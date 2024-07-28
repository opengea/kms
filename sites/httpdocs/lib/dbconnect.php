<?
$dblink=mysqli_connect($conf['db_host'],$conf['db_user'],$conf['db_pass'],$conf['db_name']);
if (!$dblink) echodebug("Can't connect to database ".$conf['db_name'],1);
mysqli_query($dblink,"SET NAMES 'utf8'");
mysqli_query($dblink,"SET CHARACTER SET utf8 ");
?>
