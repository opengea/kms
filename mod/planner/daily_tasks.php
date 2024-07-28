<?

#include "/usr/local/kms/lib/globals_externalcall.php";
if ($_GET['html']!="0") {
include "headers.php";
echo "<b>Intergrid.cat</b> : Resum de tasques pendents ".date('d-m-Y');
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
$humantasks=array("0-kms"=>"Desenvolupament KMS","1-support"=>"Suport","2-works"=>"Enc&agrave;rrecs clients","3-domains"=>"Registres","4-gestio"=>"Gesti&oacute;","5-corp"=>"Empresa","6-sysadmin"=>"Sistemes");
//get tasks 
$table ="<table style='font-size:12px;width:1060px;font-family:arial;border-collapse:collapse' cellpadding='5' border='1'>";
$table_header= $table."<tr style='font-weight:bold'><td>Status</td><td>Priority</td><td>Description</td><td>Client</td><td>Start date</td><td>Final date</td></tr>";
foreach ($users as $i => $user) {
	$select="select * from kms_planner_tasks where start_date<='".date('Y-m-d 24:59:59')."' and assigned=".$user['id']." and status!='rebutjat' and status!='finalitzat' and status!='aturat' and status!='facturable' order by category,priority desc";
	$result=mysql_query($select);
	$out="<h2 style='width:1060px;background-color:#158CDC;color:#fff;margin-bottom:0px;padding:5px;font-family:arial'>".ucfirst($user['username'])." : Tasques pendents</h2>";
	$out.=$table;
	//if ($result) {
	while ($task=mysql_fetch_array($result)) {
			if ($current_category!=$task['category']) { $out.="</table><h3 style='font-family:arial'>".$humantasks[$task['category']]."</h3>"; $out.=$table_header; $current_category=$task['category']; }
			if ($task['priority']==3) $pri="Critica";
			else if ($task['priority']==2) $pri="Alta";
			else if ($task['priority']==1) $pri="Normal";
			else if ($task['priority']==0) $pri="Baixa";
			$select="select name from kms_ent_contacts where id='".$task['sr_client']."'";
			$result2=mysql_query($select);
			$client=mysql_fetch_array($result2);
			$task_description = (strlen(htmlentities(utf8_decode($task['description']))) > 88) ? substr(htmlentities(utf8_decode($task['description'])),0,85).'...' : htmlentities(utf8_decode($task['description']));
			$client_name = (strlen(htmlentities(utf8_decode($client['name']))) > 56) ? substr(htmlentities(utf8_decode($client['name'])),0,53).'...' : htmlentities(utf8_decode($client['name']));
	$out.="
	<tr class='priority".$task['priority']."'>
	<td style='width:50px;'>".$task['status']."</td>
	<td style='width:50px;'>".$pri."</td>
	<td><a href='http://intranet.intergrid.cat/?app=planner&mod=planner_tasks&_=e&id=".$task['id']."&view=165' title='".htmlentities(utf8_decode($task['description']))."'>".$task_description."</a></td>
	<td style='width:250px'>".$client_name."</td>
	<td style='width:70px'>".date('d-m-Y',strtotime($task['start_date']))."</td>
	<td style='width:70px'>".date('d-m-Y',strtotime($task['final_date']))."</td>
	</tr>";
	}
	//}
	$out.="</table>";
	if ($_GET['html']!="0"&&($_GET['user']=="all"||$_GET['user']==$user['username'])) echo $out;
	//enviem per email
        $geekMail = new geekMail();
        $geekMail->setMailType('html');

        ob_start();
        eval('?>' . file_get_contents('/usr/local/kms/mod/planner/headers.php') . '<?');
        $headers = ob_get_contents();
        ob_end_clean();
        $from_email = "kms@intergrid.cat";
        $geekMail->from($from_email,'Intergrid SL'); // agafar l'email i el nom d'usuari de la sessió?
	$destiny=$user['email'];
	//$destiny="j.berenguer@intergrid.cat";
        $geekMail->to($destiny);
	

//        if (isset($destinycc)) {   $geekMail->cc($destinycc); }
        $geekMail->subject("Resum diari de tasques pendents ".ucfirst($user['username']));
	$subject="Resum diari de tasques pendents ".ucfirst($user['username']);
        // $geekMail->message($_POST['emailBody']); //html?
	$msg="<div style='border:1px dotted #000;padding:30px'>Si us plau manteniu les vostres tasques actualitzades. Gr&agrave;cies.</div>";
        $geekMail->message($headers."<br>$msg<br>".utf8_encode($out)."</body></html>");
	$msg=$headers."<br>$msg<br>".utf8_encode($out)."</body></html>";
//        $geekMail->attach($file_path);
if (date('D')!="Sun"&&date('D')!="Sat"&&date('m')!="08") {
	if ($_GET['send']==1&&($_GET['user']=="all"||$_GET['user']==$user['username'])) {
	$headers="MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=utf-8" . "\r\n";
	mail ($destiny,$subject,$msg,$headers);
  /*      if (!$geekMail->send())
	        {
        	  $errors = $geekMail->getDebugger();
	          echo "error sending email:";print_r($errors);
	        }
*/
	//echo "<br>Informe enviat a ".$destiny;
	}

}

}
if ($_GET['html']!="0") {
include "footer.php";
}
?>
