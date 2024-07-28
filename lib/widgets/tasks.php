<?


echo "<div class='dashboard_box'>Tasques > <b><a onmouseover='this.style.cursor=\"pointer\"' onclick='loadOn(\"/?mod=tasks&dr_folder=".$dr_folder."&_action=Clear\")'>".$title."</a></b><br><br>";


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

$select = "SELECT * FROM kms_tasks WHERE dr_folder like '".$dr_folder."' and ".$filter." order by ".$orderby." limit 10";

$result = mysql_query($select);
if ($debug) echo $select;
if (!$result) {echo mysql_error();exit;}


while($row = mysql_fetch_array($result)){

 if ($row['status']=='pendent') {$ledcolor="red";$statusmsg="pendent"; }
 else if ($row['status']=='en_proces') {$ledcolor="orange";$statusmsg="en proces...";}
 else if ($row['status']=='facturable') {$ledcolor="green";$statusmsg="facturable";}
 else if ($row['status']=='espera') {$ledcolor="yellow";$statusmsg="a l`espera";}
 

 if ($row['priority']=='3critical') {$colorlink="#ff0000"; $prioritymsg="critica";}
 else if ($row['priority']=='2high') {$colorlink="#CF6460"; $prioritymsg="urgent";}
 else if ($row['priority']=='1normal') {$colorlink="#666666"; $prioritymsg="normal";}
 else if ($row['priority']=='0low') {$colorlink="#777777"; $prioritymsg="baixa";}


 $user_icon="";
 if (strToLower($row['assigned'])==strToLower($_SESSION['user_name'])) { $user_icon="<img title='".$row['assigned']."' style='margin-left:0px;margin-right:5px' src='/kms/tpl/default/styles/aqua/img/small/user.png'>"; 
} else if (strToLower($row['assigned'])==strToLower($group)) { $user_icon="<img title='".$row['assigned']."' style='margin-left:-2px;margin-right:3px' src='/kms/tpl/default/styles/aqua/img/small/group2.png'>"; 
 } else { $user_icon="<img title='".$row['assigned']."' style='margin-left:0px;margin-right:5px' src='/kms/tpl/default/styles/aqua/img/small/otheruser.png'>"; } 
 

$max_chars = 33;

// capturem nom del client
$select_client = "SELECT name FROM kms_ent_contacts WHERE id='".$row['sr_client']."'";
$result_client = mysql_query($select_client);
if (!$result_client) {echo mysql_error();exit;}
$data_client = mysql_fetch_array($result_client);

if (strlen($row['description'])>$max_chars) $short_descr=substr($row['description'],0,$max_chars)."..."; else $short_descr = $row['description'];
 echo "<a class='dashboard_link' onmouseover='this.style.cursor=\"pointer\"'  style='color:".$colorlink."' onclick='loadOn(\"/?mod=tasks&dr_folder=".$dr_folder."&query=".$row['id']."&queryfield=id\")' title='PRIORITAT: ".$prioritymsg." CLIENT:".$data_client['name']." DESCRIPCI&Oacute;: ".htmlentities($row['description'])." NOTES: ".htmlentities($row['notes'])."'><img onmouseover='this.style.cursor=\"pointer\"' src='/kms/tpl/default/styles/aqua/img/small/led-".$ledcolor.".gif' title='".$statusmsg."'>&nbsp;".$user_icon.$short_descr."</a><br>";
}

echo "</div>";

?>
