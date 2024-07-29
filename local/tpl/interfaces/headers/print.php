
<?
print print_title();

function print_title() {
	if ($_GET['app']!="") $title=constant('_KMS_TY_'.strtoupper($_GET['app']));
	if ($_GET['mod']!=""&&$_GET['mod']!="folders") $title.=" - ".constant('_KMS_TY_'.strtoupper($_GET['mod']));
        // Constants en els noms de les carpetes (per sistema multiidioma)
        if (substr($title,0,4)=="_FL_") $title= constant($title);
        if (substr($title,0,4)=="_KMS") $title= constant($title);

        // tornem a la base de dades predefinida
        $result = mysql_connect($_SESSION['mydb_host'],$_SESSION['mydb_user'],$_SESSION['mydb_pass']);
        mysql_select_db ($_SESSION['mydb_name']);

        $iconurl = PATH_IMG_BIG.$content_type."_big.png";
        if (!file_exists('/usr/share'.$iconurl)) $iconurl = "/kms/css/aqua/img/big/folders_big.png";
	 print "<table width=\"100%\" cellpadding=0 cellspacing=0><tr><td style='padding-top:5px;text-align:left'><h2>".$title."</h2></td><td style='padding-top:10px;color:#555;vertical-align:top;text-align:right;font-size:10px;padding-right:5px;'><b>".$_SERVER['SERVER_NAME']."</b> - Intergrid KMS</td></tr></table>";
	?>
<? } ?>

