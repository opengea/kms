<?
// aquest script s'executa cada dia, i genera les factures a partir de tasques facturables.
// aquestes factures no s'agrupen.

include "/usr/local/kms/lib/dbi/db_localhost_connect.php";
include_once "/usr/local/kms/mod/erp/erp_options.php";
// G2
$dia_de_facturacio=10;
//$dies_venciment=10;
// today
$day = date('d');
$month = date('m');
$year = date('Y');
//$day=10;
//$month=2;

//if ($day!=$dia_de_facturacio) { echo "\nWe don't generate invoices until day ".$dia_de_facturacio."\n";exit; }
$num_factures=0;
$facturar = array();
$i=0;
// recopila les factures que vencen entre el dia d'avui (dia de facturació) i 30 dies abans.
	$select = "SELECT * from kms_planner_tasks WHERE status='facturable'";
//	echo $select."\n";
	$result = mysqli_query($dblink_local,$select);
	if (!$result) die (mysqli_error()."\n\n");
	while ($task = mysqli_fetch_array($result)) {


		$concepte="";
		$base_imposable=0;
		$price_values="";
		$tax_values="";
		$total_values="";

		// select client language
		$select = "SELECT * from kms_ent_contacts WHERE id='".$task['sr_client']."' AND status='alta'";
		$select = "SELECT * FROM kms_ent_contacts t1 INNER JOIN (select * FROM kms_ent_clients) t2 ON t1.id=t2.sr_client and t1.id='".$task['sr_client']."'";

                $select_result = mysqli_query($dblink_local,$select);
		if (!$select_result) die (mysqli_error()."\n\n");
                $client_data = mysqli_fetch_array($select_result);

		if ($task['billing_amount']!="0") {
//		$concepte .= mysqli_real_escape_string($dblink_local,htmlentities($task['type']." ".$task['description']))."<br><br>";
		$concepte .=  "T-".str_pad($task['id'], 5, "0", STR_PAD_LEFT)." - ".mysqli_real_escape_string($dblink_local,str_replace("<br />","//",$task['description']))."////";
		$base_imposable += $task['billing_amount'];
		$price_values .= $task['billing_amount']." &euro; ////";

                $iva=$iva_aplicable;
                // no VAT for EU Member States with intra-communitary VAT
                if ($client_data['zone_id']=='1'&&$client_data['intra_community_vat']=='1') $iva=0;
                // no VAT for non European Countries
                if ($client_data['zone_id']=='2') $iva=0;

		$tax_values .= round($task['billing_amount']*($iva/100),2)." &euro; ////";
		$total_values .= round((($task['billing_amount']*($iva/100))+$task['billing_amount']),2)." &euro;////>";
		}

		$total_tax = round($base_imposable*($iva/100),2);
		$total = round($base_imposable+$total_tax,2);
		$status="pendent";
		$venciment = 10;

        $today = date('Y-m-d');
//      $venciment_date=date("Y-m-d",strtotime('+'.$contracte['venciment'].' days',strtotime($mydate)));
        if ($client_data['force_payment_day']=="all") {
                $venciment_date=date("Y-m-".$client_data['default_payment_day']);
        } else {
                $venciment_date=date("Y-m-d",strtotime('+5 days',strtotime($today)));
        }

	$price_values=substr($price_values,0,strlen($price_values)-4);
	$payment_method = $client_data['sr_payment_method'];
	if ($payment_method =="") $payment_method = "3";
	$logo="intergrid";
	$insert = "INSERT INTO kms_erp_invoices (creation_date,type,sr_client,serie,concept,base,tax_percent,total_tax,total,payment_method,payment_date,status,price_values,tax_values,total_values,logo) VALUES ('".date('Y-m-d')."','ordinaria','".$task['sr_client']."','A','".$concepte."','".$base_imposable."','".$iva_aplicable."','".$total_tax."','".$total."','".utf8_encode($payment_method)."','".date('Y')."-".$month."-".($dia_de_facturacio+$venciment)."','".$status."','".$price_values."','".$tax_values."','".$total_values."','".$logo."')";
//	echo $insert."\n\n";
	$num_factures++;

        $do = mysqli_query($dblink_local,$insert); if (!$do) die ("shit : ".mysqli_error()."\n\n");

        $update_number = "UPDATE kms_erp_invoices SET number='F".mysqli_insert_id($dblink_local).".".date('y')."' WHERE id=".mysqli_insert_id($dblink_local);
        $do = mysqli_query($dblink_local,$update_number); if (!$do) die (mysqli_error()."\n\n");
}


        $select = "UPDATE kms_planner_tasks set status='finalitzat' WHERE status='facturable'";
//      echo $select."\n";
      $result = mysqli_query($dblink_local,$select);
        if (!$result) die ("error updating tasks ".mysqli_error()."\n\n");

echo $num_factures." factures generades de tasques\n";


?>
