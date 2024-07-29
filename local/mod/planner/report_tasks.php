<?
include "/usr/local/kms/lib/globals_externalcall.php";
$startdate=date('Y-m-d',strtotime('-'.$_GET['daysago'].' days'));
$startdate_oc=date('d-m-Y',strtotime('-'.$_GET['daysago'].' days'));
if ($_GET['days']=="") $_GET['days']=1;
$enddate=date('Y-m-d',strtotime('+'.($_GET['days']+1).' days',strtotime($startdate)));
$enddate_oc=date('d-m-Y',strtotime('+'.($_GET['days']+1).' days',strtotime($startdate)));
if ($_GET['html']!="0") {
if ($_GET['user']=="") $_GET['user']="all";
include "headers.php";
?>
<form method="GET">
<div style="padding:5px;background-color:#ddd">Veure tasques finalitzades per <select name="user" type="text" value="<?=$_GET['user']?>" style="height:24px;width:90px"><option value="all" <?if ($_GET['user']=="all") echo "selected"?>>Tots</option><option value="jordi" <?if ($_GET['user']=="jordi") echo "selected"?>>jordi</option><option value="dbardaji" <?if ($_GET['user']=="dbardaji") echo "selected"?>>dbardaji</option><option value="susanna" <?if ($_GET['user']=="susanna") echo "selected"?>>susanna</option></select> fa <input type="text" name="daysago" value="<?=$_GET['daysago']?>" style="width:40px"> dies
<input style="background-color:#666;color:#fff;cursor:pointer;cursor:hand" type="submit" value="mostra"> <input type="text" name="days" value="<?=$_GET['days']?>" style="width:40px"> dies a partir d'aquesta data</div>
</form>
<?
echo "<br><b>Intergrid.cat</b> : Resum de tasques finalitzades del $startdate_oc fins el dia ".$enddate_oc; //date('d-m-Y');
}
require '/usr/local/kms/lib/mail/geekMail-1.0.php';
include "/usr/local/kms/lib/dbi/kms_erp_dbconnect.php";
//get users
$select="select distinct assigned from kms_planner_tasks";
$result=mysql_query($select);
$i=0;
$users=array();
while ($task=mysql_fetch_array($result)) {
	$select="select * from kms_sys_users where id=".$task[0];
	$result2=mysql_query($select);
	if ($result2) {
		$user=mysql_fetch_array($result2);
		$users[$i]=$user;
	}
	$i++;
}


//get tasks 
$table="<table class='report' style='font-size:12px;font-family:arial;border-collapse:collapse' cellpadding='5' border='1'>";
$table_header=$table."<tr style='font-weight:bold'><td>Descripci&oacute;</td><td>Client</td><td>Data d'inici</td><td>Data final prevista</td><td>Data final real</td><td>Temps destinat</td></tr>";
foreach ($users as $i => $user) {
//	$select="select * from kms_planner_tasks where finalization_date<='".date('Y-m-d H:i:s')."' and start_date>='{$startdate}' and assigned=".$user['id']." and status='finalitzat' order by category,start_date desc";
//        $select="select * from kms_planner_tasks where finalization_date<='{$enddate}' and start_date>='{$startdate}' and assigned=".$user['id']." and status='finalitzat' order by category,start_date desc";
	$select="select * from kms_planner_tasks where finalization_date<='{$enddate}' and finalization_date>='{$startdate}' and assigned=".$user['id']." and status='finalitzat' order by category,start_date desc";
//	echo $select;
	$result=mysql_query($select);
	$out="<h2 style='width:1050px;background-color:#158CDC;color:#fff;padding:5px;font-family:arial'>".ucfirst($user['username'])." : Tasques finalitzades</h2>";
	$out.=$table;
	//if ($result) {
	$total_spent=0;
	while ($task=mysql_fetch_array($result)) {
			if ($current_category!=$task['category']) { $out.="</table><h3 style='font-family:arial'>".$task['category']."</h3>"; $out.=$table_header; $current_category=$task['category']; }
			$select="select name from kms_ent_contacts where id='".$task['sr_client']."'";
			$result2=mysql_query($select);
			$client=mysql_fetch_array($result2);
			//calcul temps trigat
			$f=$task['finalization_date'];
			$s=$task['start_date'];
			$f_stamp =mktime(date('H',strtotime($f)),date('i',strtotime($f)),date('s',strtotime($f)),date('m',strtotime($f)),date('d',strtotime($f)),date('Y',strtotime($f)));
			$s_stamp=mktime(date('H',strtotime($s)),date('i',strtotime($s)),date('s',strtotime($s)),date('m',strtotime($s)),date('d',strtotime($s)),date('Y',strtotime($s)));
			$spent_time=$f_stamp-$s_stamp;  // segons
			$total_spent+=$spent_time;
			$spent_time_human = humanizeTime($spent_time);
			$out.="<tr class='priority1' style='color:#000'><td><a style='font-weight:bold' href='http://intranet.intergrid.cat/?app=agenda&mod=planner_tasks&_=e&id=".$task['id']."&view=165'>".$task['description']."</a></td><td>".$client['name']."</td><td>".$task['start_date']."</td><td>".$task['final_date']."</td><td>".$task['finalization_date']."</td><td>{$spent_time_human}</td></tr>";
		}
	//}
	$out.="</table>";
	if ($_GET['html']!="0"&&($_GET['user']=="all"||$_GET['user']==$user['username'])) echo $out."<br><b>Total hores destinades : ".humanizeTime($total_spent)."</b>";


}




if ($_GET['html']!="0") {
include "footer.php";
}

function humanizeTime($spent_time) {
	$unit="segons";
       if ($spent_time>59) { $spent_time=$spent_time/60; $unit="minuts"; $spent_time=round($spent_time); } // pasem a minuts
       if ($spent_time>59&&$unit=="minuts") { $spent_time=$spent_time/60; $unit="hores"; $spent_time=round($spent_time,1); } // pasem a hores
       if ($spent_time>23&&$unit=="hores") { $spent_time=$spent_time/24; $unit="dies"; $spent_time=round($spent_time,1); } // pasem a dies
       if ($spent_time>30&&$unit=="dies") { $spent_time=$spent_time/31; $unit="mesos"; $spent_time=round($spent_time,1); } // pasem a mesos
       return $spent_time." ".$unit;
}

?>
