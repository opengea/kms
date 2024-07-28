<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Migracio de clients per FTP</title>
</head>

<body>

<?php if (!isset ($_GET['e'])) { ?>
 <p style="font-weight: bold; font-family: Arial, Helvetica, sans-serif; font-size: 18px;">Migraci&oacute; FTP </p>
 <form id="dades_migracio" method="post" action="?e">
   <table width="500" border="0" cellspacing="0" cellpadding="0">
     <tr>
       <td style="font-size: 14px">Host a migrar:</td>
       <td><input name="host" type="text" id="host" size="40" /></td>
     </tr>
     <tr>
       <td style="font-size: 14px">Nom usuari ftp</td>
       <td><input name="username" type="text" id="username" size="40" /></td>
     </tr>
     <tr>
       <td style="font-size: 14px">Contrassenya ftp</td>
       <td><input name="password" type="text" id="password" size="40" /></td>
     </tr>
     <tr>
       <td style="font-size: 14px">Directori a copiar</td>
       <td><input name="org_dir" type="text" id="org_dir" size="40" /></td>
     </tr>
     <tr>
       <td style="font-size: 14px">Carpeta dest&acute; (ruta sencera /var/www/vhost/...)</td>
       <td><input name="dest" type="text" id="dest" size="40" /></td>
     </tr>
      <tr>
       <td style="font-size: 14px">Fitxers simultanis</td>
       <td><input name="files" type="text" id="dest" value="10" size="40" /></td>
     </tr>
     <tr>
       <td>&nbsp;</td>
       <td><input type="submit" name="procedir" id="procedir" value="Procedir" /></td>
     </tr>
   </table>
 </form>
<? } else { ?>
<p>Process de migracio</p>
<?
$cmd= `ssh customers-206.intergridnetwork.net 'lftp -u ag6303,yy3wp4 -e "mirror  --parallel=10 --verbose /html /tmp/test" ftp.letsflow.org'`;
//$cmd = "ssh customers-206.intergridnetwork.net 'lftp -u {$_GET['username']},{$_GET['password']} -e \"mirror  --parallel={$_GET['files']} --verbose /{$_GET['org_dir']} {$_GET['dest']}\" {$_GET['host']}'";
//exec($cmd, $result);

$exec = $cmd;
$count=count($results);
for($i=0;$i<$count;$i++)
  {
   print "$results[$i]<br>";
  }
 }
?>
</body>
</html>
