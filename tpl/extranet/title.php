
<!--- titols -->
<? 
include_once("/usr/local/kms/lib/constants.php");
if (!isset($classtitle)) $classtitle="titles"; ?>
        <table width="100%" height="50" cellspacing="0" cellpadding="0" bgcolor="#ffffff" class="<?=$classtitle?>">
        <tr>
        <td width="20"></td>
<?  //we obtain the title of the current folder
   
//if (!isset($client_account)) { echo "client_dbconnect.php: invalid session";exit; }
include ('/usr/local/kms/lib/dbi/openExtranetDB.php');
include ('/usr/local/kms/lib/dbi/dbconnect.php');
//require ('/usr/local/kms/lib/dbi/kms_dbconnect.php');

if ($_GET['dr_folder']==0) $_GET['dr_folder']="";
if ($_GET['dr_folder']!="") {

    // titol de la carpeta
    $result = mysql_query("SELECT description FROM kms_sys_folders WHERE id='".$_GET['dr_folder']."'");
    if (!$result) {
                //echo "error head.php ".mysql_error();    exit;
                $title = $this->title;;
        } else {
            $rowdr = mysql_fetch_array($result);
            $title = $rowdr['description'];
        }
   }

   // Constants en els noms de les carpetes (per sistema multiidioma)
   if (substr($title,0,4)=="_KMS") $title= constant($title);
   // tornem a la base de dades predefinida
  $result = mysql_connect($_SESSION['dbhost'],$_SESSION['dbuser'],$_SESSION['dbpasswd']);
    mysql_select_db ($_SESSION['mydb_name']);
?>
<td align="right" width="30">
<?  
if (isset($modtitle))  $title=$modtitle;
if (!isset($content_type)) $content_type=$_GET['mod'];
?>
<img src="<? echo PATH_IMG_32; ?>/<?=$content_type?>_big.png" style="border: 0px"></td><td width="10"></td><td align="left"><font style="font-size:15px;font-weight:bold"> <?=$title?></font><br><font style="font-size:11px;font-weight:normal"><? echo $kms->subtitle?></font>

</td>

        </tr>
        </table>

