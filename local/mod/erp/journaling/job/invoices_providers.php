<?
# aquest script revisa les factures/tiquets rebudes i crea assentaments segons estiguin pendents de cobrament, cobrades o impagades, # tambe crea subcomptes de creditors (400) /deutors (440) quan aquests no existeixen

$object="ent_providers";
$current_plan=1;
$debug=1;
echo "Bucle factures de proveidors no comptabilitzades\n";
// ============ BLOCK 1 ================
// Bucle factures de proveidors no comptabilitzades
$sel="SELECT * FROM kms_erp_invoices_providers WHERE acc_status='0'";
$res=mysqli_query($dblink_local,$sel);
if (!$res) die('error '.mysqli_error($res));
while ($invoice=mysqli_fetch_array($res)) {
	// INSERTEM ASSENTAMENT

	// creacio subcompte si es necessari 400x proveidor D (1/3)	
	$account="4000";
	$next_entry_id="0";  //determinem nou entry_id      
        $parent_account=get_account($account);
	$listProviders=get_subaccounts($account);
	$n=count($listProviders);
	$now=date('Y-m-d H:i:s');
	$now=$invoice['creation_date'];
echo $invoice['creation_date']."\n";
	if (!in_array($invoice['sr_provider'],$listProviders)) { // if not exists create provider account
                // add this new record as new subaccount
                $n++;

		$sel="select * from kms_ent_providers inner join kms_ent_contacts on kms_ent_providers.sr_provider = kms_ent_contacts.id where sr_provider='{$invoice['sr_provider']}'";
		$res_provider=mysqli_query($dblink_local,$sel);
		if (!$res_provider) die(mysqli_error($res_provider));
		$provider=mysqli_fetch_array($res_provider);

                $new_account=$parent_account['account'].num_pad($n,$mda-strlen($parent_account['account']));
                $insert="INSERT INTO kms_erp_accounting (status,creation_date,plan_id,account_type,account,description,acc_subgroup,acc_group,object_id,object_type) VALUES ('1','{$now}','{$current_plan}','{$parent_account['account_type']}','{$new_account}','".mysqli_escape_string($provider['name'])."','".mysqli_escape_string($parent_account['acc_subgroup'])."','".mysqli_escape_string($parent_account['acc_group'])."','{$provider['sr_provider']}','ent_providers')";
		echo "Creating subaccount ".$new_account. " (".$provider['name'].")\n";
		if ($debug) { echo $insert."\n"; } else {  $resi=mysqli_query($dblink_local,$insert); if (!$resi) die($insert."\n".mysqli_error($resi)); }
		$provider_acc=array("account"=>$new_account,"description"=>$provider['name']); //get_account($new_account);
        } else { //read provider account
		$sel="SELECT * FROM kms_erp_accounting WHERE object_id='{$invoice['sr_provider']}' and object_type='ent_providers'";
		$ress=mysqli_query($dblink_local,$sel);
		$provider_acc=mysqli_fetch_array($ress);
		
	}
	echo "Afegint assentament per factura ".$invoice['number']."\n";
	//get next_entry_id
	$sel="select entry_id FROM kms_erp_accounting_bookentries order by entry_id desc limit 1";
	$res2=mysqli_query($dblink_local,$sel);
	$row2=mysqli_fetch_array($res2);
	$next_entry_id=$row2[0]+1;

	// CREAMENT D'ASSENTAMENT

        // 400x proveidor amb import de factura a columna CREDIT (1/3)
	$insert="INSERT INTO kms_erp_accounting_bookentries (status,creation_date,entry_id,entry_type,account_id,description,debit,credit,balance,object_id,object_type) VALUES ('1','{$now}','{$next_entry_id}','1','{$provider_acc['account']}','".mysqli_escape_string($provider_acc['description'])."','0','{$invoice['total']}','','{$invoice['id']}','erp_invoices')";
	if ($debug) { echo $insert."\n"; } else { $res_insert=mysqli_query($dblink_local,$insert); if (!$res_insert) die($insert."\n".mysqli_error($res_insert)); }
	//600 Compres i despeses DEBIT (2/3)
	$acc=get_account('600');
	$insert="INSERT INTO kms_erp_accounting_bookentries (status,creation_date,entry_id,entry_type,account_id,description,debit,credit,balance,object_id,object_type) VALUES ('1','{$now}','{$next_entry_id}','1','600','".mysqli_escape_string($acc['description'])."','{$invoice['base']}','0','','{$invoice['id']}','erp_invoices')";
	if ($debug) { echo $insert."\n"; } else { $res_insert=mysqli_query($dblink_local,$insert); if (!$res_insert) die($insert."\n".mysqli_error($res_insert)); }
	//477 iva suportat DEBIT (3/3)
        $acc=get_account('477');
        $insert="INSERT INTO kms_erp_accounting_bookentries (status,creation_date,entry_id,entry_type,account_id,description,debit,credit,balance,object_id,object_type) VALUES ('1','{$now}','{$next_entry_id}','1','477','".mysqli_escape_string($acc['description'])."','{$invoice['total_tax']}','0','','{$invoice['id']}','erp_invoices')";
	if ($debug) { echo $insert."\n"; } else { $res_insert=mysqli_query($dblink_local,$insert); if (!$res_insert) die($insert."\n".mysqli_error($res_insert)); }

	// si hi hagues retenciÃ practicada caldria afegir compte 4751 (Hisenda) i posar l'import de la retencio a CREDIT
        // (nomines i lloguers)

	//Posem factura com comptabilitzada, update acc_status='1'
	$update="UPDATE kms_erp_invoices SET acc_status='1' WHERE id=".$invoice['id'];
	if ($debug) { echo $update."\n"; } else { $res_update=mysqli_query($dblink_local,$update); if (!$res_update) die($update."\n".mysqli_error($res_update)); }
}



?>
