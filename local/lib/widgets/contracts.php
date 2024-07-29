<?




echo "<div class='dashboard_box'>Contractes > <b><a onmouseover='this.style.cursor=\"pointer\"' onclick='loadOn(\"/?mod=contracts&dr_folder=".$dr_folder."&_action=Clear\")'>".$title."</a></b><br><br>";


$select = "SELECT * FROM kms_contracts WHERE dr_folder='".$dr_folder."' and status='actiu' and ".$filter." order by ".$orderby." limit 10";

$result = mysql_query($select);
if ($debug) echo $select;
if (!$result) {echo mysql_error();exit;}

//$filter="status=pendents|in_process";

while($row = mysql_fetch_array($result)){

 if ($row['status']=='pendent') $ledcolor="red";
 else if ($row['status']=='en_proces') $ledcolor="orange";
 else if ($row['status']=='facturable') $ledcolor="green";


$max_chars = 35;
if (strlen($row['description'])>$max_chars) $short_descr=substr($row['description'],0,$max_chars)."..."; else $short_descr = $row['description'];
 echo "<img src='/kms/css/aqua/img/small/led-".$ledcolor.".gif'>&nbsp;<a class='dashboard_link' onmouseover='this.style.cursor=\"pointer\"'  style='color:".$colorlink."' onclick='loadOn(\"/?mod=tasks&dr_folder=".$dr_folder."&query=".$row['id']."&queryfield=id\")' title='".$row['sr_client']."|".$row['description']."|".$row['notes']."'>".$short_descr."</a><br>";
}
echo "</div>";

?>
