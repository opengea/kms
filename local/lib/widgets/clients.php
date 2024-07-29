

<?
echo "<div class='dashboard_box'>Clients > <b><a onmouseover='this.style.cursor=\"pointer\"' onclick='loadOn(\"/?mod=clients&dr_folder=".$dr_folder."&_action=Clear\")'>".$title."</a></b><br><br>";
$select = "SELECT * FROM kms_ent_clients WHERE dr_folder='".$dr_folder."' and ".$filter." order by ".$orderby." limit 10";

$result = mysql_query($select);
//echo $select;
if (!$result) {echo mysql_error();exit;}
if ($debug) echo $select;

while($row = mysql_fetch_array($result)){

 if ($row['status']=='pendent') $ledcolor="red";
 else if ($row['status']=='en_proces') $ledcolor="orange";
 else if ($row['status']=='alta') $ledcolor="green";

 $colorlink="#666666";


$max_chars = 35;

// capturem nom del client
$select_client = "SELECT name FROM kms_ent_contacts WHERE id='".$row['sr_name']."'";
$result_client = mysql_query($select_client);
if (!$result_client) {echo mysql_error();exit;}
$data_client = mysql_fetch_array($result_client);

if ($refresh_onclick) { 
	// refresquem
	$action = "loadContents(\"clients\",\"/?refresh&sr_client=1\")"; 
	// obrim objecte
//	$action = "alert(\"si\");";
	} else { $action = "loadContents(\"clients\",\"/?mod=clients&dr_folder=".$dr_folder."&query=".$row['id']."&queryfield=id\")"; }

if (strlen($data_client['name'])>$max_chars) $short_descr=substr($data_client['name'],0,$max_chars)."..."; else $short_descr = $data_client['name'];
 echo "<img src='/kms/css/aqua/img/small/led-".$ledcolor.".gif'>&nbsp;<a class='dashboard_link' onmouseover='this.style.cursor=\"pointer\"'  style='color:".$colorlink."' onclick='".$action."' title='".$row['sr_client']."|".$short_descr."|".$row['notes']."'>".$short_descr."</a><br>";
}
echo "</div>";

?>
