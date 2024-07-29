<?
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 1);

$debug_level=0;  //activar per fer debug (no genera factures)

// aquest script s'executa cada dia i ja genera factures que vencen en 15 dies, manté el dia de venciment del contracte

$locales=array();
$locales['ct']=array("_DISCOUNT"=>"Descompte");
$locales['es']=array("_DISCOUNT"=>"Descuento");
$locales['en']=array("_DISCOUNT"=>"Discount");
$locales['eu']=array("_DISCOUNT"=>"Descuento");
$locales['fr']=array("_DISCOUNT"=>"Discount");

include "/usr/local/kms/lib/dbi/db_localhost_connect.php";
include_once "/usr/local/kms/mod/erp/erp_options.php";

$today = date('d');
$from_date = "2000-01-01"; //date('Y-m-d',strtotime("-3 month",strtotime(date('Y-m-'.$today))));
$to_date = date('Y-m-d',strtotime("+15 days",strtotime(date('Y-m-d')))); // en 15 dies /generem i enviem factures 15 dies abans del seu venciment

$facturar = array();
$i=0;
// recopila els contractes que vencen 
	$select = "SELECT * from kms_erp_contracts WHERE ((end_date >='".$from_date."' AND end_date <= '".$to_date."') AND status='active' AND (auto_renov='1' or creation_date='".date('Y-m-d')."')) OR (invoice_pending=1 and initial_date=end_date) ";
	if ($debug_level==1) echo "Generem factures 15 dies abans del seu venciment per enviar-les ja al client\n".$select."\n";
	$result = mysqli_query($dblink_local,$select);
	if (!$result) die (mysqli_error()."\n\n");
	while ($contract = mysqli_fetch_array($result)) {
		if ($contract['price']!=0&&gettype($facturar[$contract['sr_client']])!="array") $facturar[$contract['sr_client']] = array();
		// update end_date
		switch ($contract['billing_period']) {
			case "1M"   :  $add_time = "+1 month";break;
			case "6M"   :  $add_time = "+6 months";break;
			case "3M"   :  $add_time = "+3 months";break;
			case "1Y"   :  $add_time = '+1 year';break;
			case "2Y"   :  $add_time = "+2 years";break;
			case "3Y"   :  $add_time = "+3 years";break;
			case "4Y"   :  $add_time = "+4 years";break;
			case "5Y"   :  $add_time = "+5 years";break;
			case "6Y"   :  $add_time = "+6 years";break;
			case "7Y"   :  $add_time = "+7 years";break;
			case "8Y"   :  $add_time = "+8 years";break;
			case "9Y"   :  $add_time = "+9 years";break;
			case "10Y"  :  $add_time = "+10 years";break;
		}
		$contract['old_end_date']=$contract['end_date'];
		$new_end_date=date('Y-m-d',strtotime($add_time,strtotime($contract['end_date'])));
		$contract['venciment_date']=$contract['end_date'];
		$contract['end_date']=$new_end_date;
		if ($contract['price']!=0) array_push($facturar[$contract['sr_client']], $contract);
		if ($contract['auto_renov']=="0") $contract['status']="finalitzat";
		if ($contract['price']!="") {
	        $update_contract = "UPDATE kms_erp_contracts SET invoice_pending=0,status='".$contract['status']."',end_date='".$new_end_date."' WHERE id=".$contract['id'];
		if ($debug_level==1) echo "\n".$contract['end_date']." ".$contract['billing_period']."  ---> ".$update_contract."\n";
		if ($debug_level!=1)  { $do = mysqli_query($dblink_local,$update_contract);  if (!$do) die (mysqli_error()."\n\n");  }	
		} else {
		$from_name="KMS";
		$from="kms@intergridnetwork.net";
		$to="sistemes@intergrid.cat";
		$subject="[KMS Ecom] Contracte #".$contract['id']." sense preu";
		$body="Comproveu el ".$subject;
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'From: '.$from_name.' <'.$from.'>' . "\r\n";
		$body="<span style='font-family:monospace;font-size:12px'>".$body."</span>";
		mail($to, $subject, $body, $headers, "-f {$from}");	

		}
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
		// processem tots els contractes del client

		// select client language
                $select = "SELECT * FROM kms_ent_contacts t1 INNER JOIN (select * FROM kms_ent_clients) t2 ON t1.id=t2.sr_client and t1.id='".$contracte['sr_client']."' AND t2.status='active'";
		$select_result = mysqli_query($dblink_local,$select);
		if (!$select_result) die (mysqli_error()."\n\n");
                $client_data = mysqli_fetch_array($select_result);
		if ($client_data['sr_provider']!='1'&&$client_data['billing_client']=='1') {
			// cal facturar al compte de reseller
			if ($debug_level==1) {echo " ---cal facturar al compte de reseller---"; }
			$select="SELECT * FROM kms_ent_contacts t1 INNER JOIN (select * FROM kms_ent_clients) t2 ON t1.id=t2.sr_client and t1.id='".$client_data['sr_provider']."' AND t2.status='active'";
			$select_result = mysqli_query($dblink_local,$select);
			if (!$select_result) die (mysqli_error()."\n\n");
			$client_data = mysqli_fetch_array($select_result);
		}

		if ($contracte['sr_ecom_service']==2120) $logo="opengea"; else $logo="intergrid";
	
                // select service name
                $select = "SELECT * from kms_ecom_services where id='".$contracte['sr_ecom_service']."' AND status='active'";
                $select_result = mysqli_query($dblink_local,$select);
                if (!$select_result) die (mysqli_error()."\n\n");
                $service = mysqli_fetch_array($select_result);

	
		 if ($debug_level==1) {echo "------------------------------\nClient: ".$client_data['name'];
					if ($client_data['name']=="") echo "NO CLIENT!!!";
					echo " locale:".$client_data['language'];
						 if ($client_data['language']=="") {echo " NO LOCALE FOR THIS CLIENT!"; }
					echo "\n";
				      }
		if ($client_data['language']=="") $client_data['language']=="ct";
		include "/usr/local/kms/mod/erp/reports/lang/".$client_data['language'].".php"; 
		//$period= html_entity_decode("report_billing_period_".$contracte['billing_period']);
		if ($client_data['language']=="ct") $client_data['language']="ca";
		$sel_l="select ".$client_data['language']." from kms_sys_lang where const='_KMS_GL_PERIOD_".strtoupper($contracte['billing_period'])."'";
	 	if ($debug_level==1) echo $sel_l."\n";
		$res_l = mysqli_query($dblink_local,$sel_l,$dblink_local);
		$lang_l=mysqli_fetch_array($res_l);
		$period=$lang_l[0];
		if ($period=="") $period=$contracte['billing_period'];
		$description_extra=$contracte['description'];
		if ($description_extra!=$contracte['domain']) $contracte['description'].=" ".strtoupper($contracte['domain']);
		
		$opc=date('d/m/Y',strtotime($contracte['old_end_date']))." - ".date('d/m/Y',strtotime($contracte['end_date']));
		$concepte .= "C-".str_pad($contracte['id'], 5, "0", STR_PAD_LEFT)." - ".mysqli_real_escape_string($dblink_local,$service['name_'.$client_data['language']])." ".mysqli_real_escape_string($dblink_local,$description_extra)." (".$period." ".$opc.")//";
		if ($debug_level==1) echo "service:".$service['name_'.$client_data['language']]."\n";

		 if ($debug_level==1)	echo "CONCEPTE: ".$concepte."\n";

		if ($contracte['price_discount_pc']!=""&&$contracte['price_discount_pc']!=0) {
			$descompte=$contracte['price']*$contracte['price_discount_pc']/100;
			$preudescomptat=$contracte['price']-$descompte;
			$preudescomptat=round($preudescomptat*100)/100; //2 decimals
			$base_imposable += $preudescomptat;
                        $price_values .= $contracte['price']." &euro;//-".$descompte." &euro;//";
			$concepte .= $locales[$client_data['language']]['_DISCOUNT']." ".$contracte['price_discount_pc']."% "."C-".str_pad($contracte['id'], 5, "0", STR_PAD_LEFT)." - ".mysqli_real_escape_string($dblink_local,$service['name_'.$client_data['language']])."//"; 
		} else {
			$base_imposable += $contracte['price'];
			$price_values .= $contracte['price']." &euro;//";
		}
		// set VAT
		$iva=$iva_aplicable=$erp['ecom_def_vat'];
		// no VAT for EU Member States with intra-communitary VAT
		if ($client_data['zone_id']=='1'&&$client_data['intra_community_vat']=='1') $iva=$iva_aplicable=0;
		// no VAT for non European Countries
		if ($client_data['zone_id']=='2') $iva=$iva_aplicable=0;

		$tax_values .= round($contracte['price']*($iva/100),2)." &euro;//";
		$total_values .= round((($contracte['price']*($iva/100))+$contracte['price']),2)." &euro;//";
        }
	$total_tax = round($base_imposable*($iva/100),2);
	$total = round($base_imposable+$total_tax,2);



	$select = "SELECT * from kms_ecom_payment_methods where id='".$contracte['payment_method']."'";
        $select_result = mysqli_query($dblink_local,$select);
        if (!$select_result) die (mysqli_error()."\n\n");
        $payment_method = mysqli_fetch_array($select_result);
	if ($payment_method['payment_type']=="R") $status = "pendent"; else $status="pendent";

	if ($client_data['default_payment_day']==0) $client_data['default_payment_day']=$dia_venciment; //20; avancem 15 dies per lo que triga
	// ajust per dies de pagament nostres (venciment factura)

	if ($client_data['force_payment_day']==""||$client_data['force_payment_day']=="none") $client_data['force_payment_day']=$dia_venciment;// avancem 15 dies 20; //default

	$venciment_date = $contracte['venciment_date']; 

        if ($payment_method['payment_days']!=0&&$payment_method['payment_days']!='') $add_time="+".$payment_method['payment_days']." days"; else $add_time="";
        if ($add_time!="") $venciment_date=date('Y-m-d',strtotime($add_time,strtotime($venciment_date))); //date('Y-m-d'))));

	echo "DATA VENCIMENT: ".$venciment_date."\n";

	$insert = "INSERT INTO kms_erp_invoices (creation_date,type,sr_client,serie,concept,base,tax_percent,total_tax,total,payment_method,payment_date,status,price_values,tax_values,total_values,paypal_subscr_id,pre_client,post_client,logo) VALUES ('".date('Y-m-d')."','ordinaria','".$client_data['sr_client']."','A','".$concepte."','".$base_imposable."','".$iva_aplicable."','".$total_tax."','".$total."','".$contracte['payment_method']."','".$venciment_date."','".$status."','".$price_values."','".$tax_values."','".$total_values."','".$contracte['paypal_subscr_id']."','".$client_data['invoice_prefix']."','".$client_data['invoice_sufix']."','".$logo."')";

	if ($debug_level==1)	{echo $insert."\n\n";}
	$num_factures++;
        if ($debug_level!=1) {$do = mysqli_query($dblink_local,$insert); if (!$do) die (mysqli_error()."\n\n");}
        $update_number = "UPDATE kms_erp_invoices SET number='F".mysqli_insert_id($dblink_local).".".date('y')."' WHERE id=".mysqli_insert_id($dblink_local);
	if ($debug_level!=1) { $do = mysqli_query($dblink_local,$update_number); if (!$do) die (mysqli_error()."\n\n");}
}

echo "\n".$num_factures." factures generades de contractes\n";

// set 0 invoices to payed
$update="update kms_erp_invoices set status='cobrat' where total='0' and status='pendent'";
$do = mysqli_query($dblink_local,$update);
$update="update kms_isp_invoices set status='cobrat' where total='0' and status='pendent'";
$do = mysqli_query($dblink_local,$update);
include "/usr/local/kms/lib/dbi/db_master_connect.php";
$update="update kms_isp_invoices set status='cobrat' where total='0' and status='pendent'";
$do = mysqli_query($dblink_cp,$update);


?>
