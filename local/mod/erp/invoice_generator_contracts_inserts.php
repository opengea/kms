<?

// aquest script s'executa i genera factures cada dia. Genera les factures dels contractes que s'han donat d'alta aquest mes i tenen invoice pending=1

include "/usr/local/kms/lib/dbi/kms_erp_dbconnect.php";
include "/usr/local/kms/mod/erp/erp_options.php";
echo "-------------------\nCONTRACTES NOUS:\n";

//$dies_venciment=10;
// today
$day = date('d');
$month = date('m');
$year = date('Y');
//$day=10;
//$month=2;


$facturar = array();
$i=0;
// recopila els contractes que s'han donat d'alta entre el dia d'avui i 30 dies abans i dels quals no s'ha generat factura ( invoice_pending=1. )
//	$select = "SELECT * from kms_erp_contracts WHERE initial_date >= '".$year."".($month-12)."-".$day."' AND initial_date < '".$year."-".$month."-".$day."' AND invoice_pending=1 AND status='active'";
        $select = "SELECT * from kms_erp_contracts WHERE invoice_pending=1 AND status='active' and price>0";
	echo $select."\n";
	$result = mysqli_query($dblink_local,$select);
	if (!$result) die (mysqli_error()."\n\n");
	while ($contract = mysqli_fetch_array($result)) {
		if (gettype($facturar[$contract['sr_client']])!="array") $facturar[$contract['sr_client']] = array();
		array_push($facturar[$contract['sr_client']], $contract);

	}
// GENERAR FACTURES

$num_factures=0;
foreach ($facturar as $i => $client) {
	$concepte="";
	$base_imposable=0;
	$price_values="";
	$tax_values="";
	$total_values="";
        foreach ($client as $j => $contracte) {

		// processem tots els contractes del client per tal d'emetre una factura
		// select client language
		$select = "SELECT * from kms_ent_contacts WHERE id='".$contracte['sr_client']."' AND status='active'";
                $select_result = mysqli_query($dblink_local,$select);
		if (!$select_result) die (mysqli_error()."\n\n");
                $client_data = mysqli_fetch_array($select_result);

                // select service name
                $select = "SELECT * from kms_ecom_services where id='".$contracte['sr_ecom_service']."' AND status='active'";
                $select_result = mysqli_query($dblink_local,$select);
                if (!$select_result) die (mysqli_error()."\n\n");
                $service = mysqli_fetch_array($select_result);

		/// ALTA-..........
		if ($contracte['alta']!="") {
		$concepte .= "ALTA ".mysqli_real_escape_string($dblink_local,$service['name_'.$client_data['language']])." ".strtoupper(mysqli_real_escape_string($dblink_local,$contracte['domain']))."////";
		$base_imposable += $contracte['alta'];
                $price_values .= $contracte['alta']." &euro;//";

		}

                $opc=date('d-m-Y',strtotime($contracte['end_date']))." - ".date('d-m-Y',strtotime($new_end_date));
		$concepte .= "C-".str_pad($contracte['id'], 5, "0", STR_PAD_LEFT)." - ".mysqli_real_escape_string($dblink_local,$service['name_'.$client_data['language']])." ".strtoupper(mysqli_real_escape_string($dblink_local,$contracte['domain']))." (".$contracte['billing_period'].") ".$opc."//";

		//echo $concepte."\n";
		$base_imposable += $contracte['price'];
		$price_values .= $contracte['price']." &euro;//";
		if ($client_data['country']!="ES"||$client_data['country']=!"EU"||$client_data['country']!="CT") $iva=0; else $iva=$iva_aplicable;

		$tax_values .= round($contracte['price']*($iva/100),2)." &euro;//";
		$total_values .= round((($contracte['price']*($iva/100))+$contracte['price']),2)." &euro;//";

	        // update end_date
                switch ($contracte['billing_period']) {
                        case "1M"   :  $add_time = "+1 month";break;
                        case "3M"   :  $add_time = "+3 month";break;
                        case "6M"   :  $add_time = "+6 month";break;
                        case "1Y"   :  $add_time = '+1 year';break;
                        case "2Y"   :  $add_time = "+2 year";break;
                        case "3Y"   :  $add_time = "+3 year";break;
                        case "4Y"   :  $add_time = "+4 year";break;
                        case "5Y"   :  $add_time = "+5 year";break;
                        case "6Y"   :  $add_time = "+6 year";break;
                        case "7Y"   :  $add_time = "+7 year";break;
                        case "8Y"   :  $add_time = "+8 year";break;
                        case "9Y"   :  $add_time = "+9 year";break;
                        case "10Y"  :  $add_time = "+10 year";break;
                }
		$contracte['old_end_date']=$contracte['end_date'];
		// en els contractes nous la data de venciment es sobreescriu sempre en funcio del periode
                $new_end_date=date('Y-m-d',strtotime($add_time,strtotime($contracte['initial_date'])));
		$contracte['end_date']=$new_end_date;
		// marquem contracte que ja s'ha generat factura
	        $update_pending = "UPDATE kms_erp_contracts SET invoice_pending=0,end_date='".$new_end_date."' WHERE id='".$contracte['id']."'";
//echo $update_pending;exit;
	        $do=mysqli_query($dblink_local,$update_pending); if (!$do) die (mysqli_error()."\n\n");
		}

	$total_tax = round($base_imposable*($iva/100),2);
	$total = round($base_imposable+$total_tax,2);
	if ($contracte['payment_method']=="3") $status = "pendent"; else $status="pendent";
	$today = date('Y-m-d');
//	$venciment_date=date("Y-m-d",strtotime('+'.$contracte['venciment'].' days',strtotime($mydate)));
	if ($client_data['force_payment_day']=="all") {
		$venciment_date=date("Y-m-".$client_data['default_payment_day']);
	} else {
	        $venciment_date=date("Y-m-d",strtotime('+5 days',strtotime($today)));
	}
	$insert = "INSERT INTO kms_erp_invoices (creation_date,type,sr_client,serie,concept,base,tax_percent,total_tax,total,payment_method,payment_date,status,price_values,tax_values,total_values) VALUES ('".date('Y-m-d')."','ordinaria','".$contracte['sr_client']."','A','".$concepte."','".$base_imposable."','".$iva_aplicable."','".$total_tax."','".$total."','".$contracte['payment_method']."','".$venciment_date."','".$status."','".$price_values."','".$tax_values."','".$total_values."')";
	echo $insert."\n\n";
	$num_factures++;
        $do = mysqli_query($dblink_local,$insert); if (!$do) die (mysqli_error()."\n\n");
        $update_number = "UPDATE kms_erp_invoices SET number='F".mysqli_insert_id($dblink_local).".".date('y')."' WHERE id=".mysqli_insert_id($dblink_local);
        $do = mysqli_query($dblink_local,$update_number); if (!$do) die (mysqli_error()."\n\n");
}

echo "\n".$num_factures." factures generades\n\n";
?>
