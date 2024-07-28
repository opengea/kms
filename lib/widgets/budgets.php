<?




echo "<div class='dashboard_box'>Pressupostos > <b><a onmouseover='this.style.cursor=\"pointer\"' onclick='loadOn(\"/?mod=budgets&dr_folder=".$dr_folder."&_action=Clear\")'>".$title."</a></b><br><br>";



//$filter

/*   $param = substr($filter,0,strpos($filter,"="));
   $condicions = substr($filter,strpos($filter,"=")+1);

// NOTA: Acabar & split i bucle

   $filter_lines = split("\|",$condicions);
   $cond="";
   for ($i=0;$i<count($filter_lines);$i++) {
     $cond .= $param." like '%".$filter_lines[$i]."%' or "; 
   }
   $cond = substr ($cond,0,strlen($cond)-4);
*/
// 

if (!isset($orderby)) $orderby="priority desc";

$select = "SELECT * FROM kms_budgets WHERE dr_folder='".$dr_folder."' and ".$filter." order by ".$orderby." limit 10";

$result = mysql_query($select);
if ($debug) echo $select;
if (!$result) {echo mysql_error();exit;}


while($row = mysql_fetch_array($result)){

 if ($row['status']=='1pendent') {$ledcolor="red";$statusmsg="pendent"; }
 else if ($row['status']=='4rebutjat') {$ledcolor="gray";$statusmsg="rebutjat";}
 else if ($row['status']=='5rebutjat') {$ledcolor="black";$statusmsg="rebutjat";}
 else if ($row['status']=='3aprovat') {$ledcolor="green";$statusmsg="aprovat";}
 else if ($row['status']=='2espera') {$ledcolor="yellow";$statusmsg="a l`espera";}


$colorlink="#777777";

$max_chars = 35;

// capturem nom del client
$select_client = "SELECT name FROM kms_ent_contacts WHERE id='".$row['sr_client']."'";
$result_client = mysql_query($select_client);
if (!$result_client) {echo mysql_error();exit;}
$data_client = mysql_fetch_array($result_client);

if (strlen($row['description'])>$max_chars) $short_descr=substr($row['description'],0,$max_chars)."..."; else $short_descr = $row['description'];
 echo "<img onmouseover='this.style.cursor=\"pointer\"' src='/kms/css/aqua/img/small/led-".$ledcolor.".gif' title='".$statusmsg."'>&nbsp;<a class='dashboard_link' onmouseover='this.style.cursor=\"pointer\"'  style='color:".$colorlink."' onclick='loadOn(\"/?mod=budgets&dr_folder=".$dr_folder."&query=".$row['id']."&queryfield=id\")' title='CLIENT:".$data_client['name']." DESCRIPCI&Oacute;: ".htmlentities($row['description'])." NOTES: ".htmlentities($row['notes'])."'>".$short_descr."</a><br>";
}
echo "</div>";

?>
