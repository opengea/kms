#!/usr/bin/php -q
<?
include "/usr/local/kms/lib/dbi/db_localhost_connect.php";
include_once "/usr/local/kms/mod/erp/erp_options.php";

//executar dia 1

$month=date('m')-1; //mes anterior
if (strlen($month)==1) $month="0".$month;
$periode=date('Y')."-".$month;
$num_days=cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));

$sel="select * from kms_ent_staff where regim='1' and salary>0"; // staff en regim general i salari
$res=mysqli_query($dblink_local,$sel);
while ($staff=mysqli_fetch_array($res)) {

	$sel="select * from kms_erp_paysheets where staff_id=".$staff['id']." and periode='".$periode."'";
	$res2=mysqli_query($dblink_local,$sel);
	$ps = mysqli_fetch_array($res2);
	if ($ps['id']=="") { //don't exists, generate paysheet

		//get allocated costs
		$q="SELECT * FROM kms_erp_invoices_providers WHERE allocate_cost_to='".$staff['id']."' and creation_date between '".date('Y-'.$month.'-01')."' and '".date('Y-'.$month.'-'.$num_days.'')."'";
		//echo $q."\n";
		$res3=mysqli_query($dblink_local,$q);
		$restar_base=0;
		while ($invoice=mysqli_fetch_array($res3)) {
			$restar_base+=$invoice['base'];
		} 
		$total_a_percebre=$staff['salary']-$restar_base;
		$retencio=$staff['salary']*$staff['retencio_aplicable']/100;
		$total_a_percebre=$total_a_percebre-$retencio;
		$q="INSERT INTO kms_erp_paysheets (staff_id,periode,creation_date,date,regim,allocated_costs,total_dies,base_irpf,total_meritat,irpf_pc,total_a_deduir,total_a_percebre) VALUES ('{$staff['id']}','{$periode}','".date('Y-m-d')."','".date('Y-m-d')."','general','{$restar_base}','{$num_days}','{$staff['salary']}','{$staff['salary']}','{$staff['retencio_aplicable']}','{$retencio}','{$total_a_percebre}')";
		$res3=mysqli_query($dblink_local,$q);		
		echo "Created paysheet for ".$staff['fullname']." ".$periode." BASE:".$staff['salary']." -{$restar_base} DESPESA -{$retencio} RETENCIO = {$total_a_percebre}\n";
	}
}
?>
