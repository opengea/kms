<?
// KMS ERP - Journaling functions
// By Jordi Berenguer

function num_pad($number,$n) {
	return str_pad((int) $number,$n,"0",STR_PAD_LEFT);
}

function get_account($ac) {
	global $dblink_local;
        $sel="SELECT * FROM kms_erp_accounting where account='{$ac}'";
        $res=mysqli_query($dblink_local,$sel);
        return mysqli_fetch_array($res);
}

function get_account_by_object($object_id,$object_type) {
        global $dblink_local;

	$sel="SELECT * FROM kms_erp_accounting WHERE object_id='{$object_id}' and object_type='{$object_type}'";
	$ress=mysqli_query($dblink_local,$sel);
	return mysqli_fetch_array($ress);
}
function get_subaccounts($ac) {
        global $dblink_local;
        $listed=array();
        $sel="SELECT * FROM kms_erp_accounting where account like '{$ac}%' and account!='{$ac}'";
        $res=mysqli_query($dblink_local,$sel);
        if (!$res) die(mysqli_error($res)." ".$sel);
        while ($row=mysqli_fetch_array($res)) { array_push($listed,$row['object_id']);}  
	return $listed;
}

function next_subaccount_number($ac) {
        global $dblink_local,$account;
	$mda=9; //max digits for accounts (BIGINT)
        $listed=array();
        $sel="SELECT count(*) FROM kms_erp_accounting where account like '{$ac}%' and account!='{$ac}'";
        $res=mysqli_query($dblink_local,$sel);
        if (!$res) die(mysqli_error($res)." ".$sel);
	$row=mysqli_fetch_array($res);
	$n=$row[0];
	$n++;
	$parent_account=get_account($account);
        $new_account_number=$parent_account['account'].num_pad($n,$mda-strlen($parent_account['account']));
        return $new_account_number;
}

//next_entry_id : get the next book entry id
function next_entry_id() {
         global $dblink_local;
       $sel="select entry_id FROM kms_erp_accounting_bookentries order by entry_id desc limit 1";
        $res2=mysqli_query($dblink_local,$sel);
        $row2=mysqli_fetch_array($res2);
        return ($row2[0]+1);
}

function add_account($object_id,$object_type,$description,$account,$timestamp) {
        global $dblink_local,$debug;
	$current_plan=1;
        $parent_account=get_account($account);
        if ($timestamp=="") $timestamp=date('Y-m-d H:i:s');
	$new_account_number=next_subaccount_number($account);
        $insert="INSERT INTO kms_erp_accounting (status,creation_date,plan_id,account_type,account,description,acc_subgroup,acc_group,object_id,object_type) VALUES ('1','{$timestamp}','{$current_plan}','{$parent_account['account_type']}','{$new_account_number}','".mysqli_real_escape_string($dblink_local,$description)."','".mysqli_real_escape_string($dblink_local,$parent_account['acc_subgroup'])."','".mysqli_real_escape_string($dblink_local,$parent_account['acc_group'])."','{$object_id}','{$object_type}')";
        echo "Creating subaccount ".$new_account_number. " (".$description.")\n";
        if ($debug) { echo $insert."\n"; } else {  $resi=mysqli_query($dblink_local,$insert); if (!$resi) die($insert."\n".mysqli_error($resi)); }
	return mysqli_insert_id($dblink_local);
}

function add_entry($entry_type,$account_number,$debit,$credit,$object_id,$object_type) {

        global $dblink_local,$object,$debug,$exercici;
	$account=get_account($account_number);
	$entry_id=next_entry_id();
        $status=1;
	$balance="";
	$timestamp=$object['creation_date'];  if ($timestamp=="") $timestamp=date('Y-m-d H:i:s');
        if ($timestamp=="") $timestamp=date('Y-m-d H:i:s');
        $insert="INSERT INTO kms_erp_accounting_bookentries (status,creation_date,exercici,entry_id,entry_type,account_id,description,object_id,object_type,debit,credit,balance) VALUES ('{$status}','{$timestamp}','{$exercici}','{$entry_id}','{$entry_type}','".$account['account']."','".mysqli_real_escape_string($dblink_local,$account['description'])."','{$object_id}','{$object_type}','{$debit}','{$credit}','{$balance}')";
        if ($debug) { echo $insert."\n"; } else { $res_insert=mysqli_query($dblink_local,$insert); if (!$res_insert) die($insert."\n".mysqli_error($res_insert)); }
        return $entry_id;//mysqli_insert_id($dblink_local);
}

function get_client($sr_client) {
        global $dblink_local;

        $sel="select * from kms_ent_clients inner join kms_ent_contacts on kms_ent_clients.sr_client = kms_ent_contacts.id where sr_client='{$sr_client}'";
        $res_client=mysqli_query($dblink_local,$sel);
        if (!$res_client) die(mysqli_error($res_client));
        return (mysqli_fetch_array($res_client));
}

function get_bank_account($id) {
        global $dblink_local;
	$owner="INTERGRID SL";
	$sel="SELECT * FROM kms_{$object} where id={$id} and owner='".$owner."' and type='bank_account'";
	$res=mysqli_query($dblink_local,$sel);
        if (!$res) die(mysqli_error($res));
        return (mysqli_fetch_array($res));
}

function get_object($id,$object_type) {
        global $dblink_local;
	if ($object_type=="client") return get_client($id);
	else if ($object_type=="bank_account") return get_bank_account($id);
	else echo "unknown object type";

}

function get_object_description($object,$object_type) {
         global $dblink_local,$obj;
       if ($object_type=="client") { return $obj['name']; }
        else echo "unknown object type";
}

function set_object_status($status,$object_type,$object_id) {
        global $dblink_local,$debug;
	$update="UPDATE kms_{$object_type} SET acc_status='{$status}' WHERE id=".$object_id;
        if ($debug) { echo $update."\n"; } 
	else {  $res_update=mysqli_query($dblink_local,$update); 
	 	if (!$res_update) die($update."\n".mysqli_error($res_update)); 
	}
}
// add_if_not_exists : add subaccount if not exists
function add_if_not_exists($account,$parent,$object_type)  {  
        global $dblink_local;
        $list=get_subaccounts($parent);
        $n=count($list);
        if (!in_array($account,$list)) {
                // add this new record as new subaccount
                $n++;
                $object=get_object($account,$object_type); 
		$description=get_object_description($object,$object_type);
		$now=$object['creation_date'];	if ($now=="") $now=date('Y-m-d H:i:s');
                $new_account_id=add_account($object,$account,$description,$parent,$now);
                $new_account=get_account($new_account_id);
        } else { //read client account
                $new_account=get_account_by_object($account,"ent_clients");
        }
	return $new_account; //return object
}

function assentaments($object_type, $class) {
        global $dblink_local,$exercici;


        // Step 1: MAKE SELECT - seleccionem objectes a partir dels quals hem de crear els assentaments
	$exercici=date('Y');
        $table="kms_".$object_type;

	// STeP 1 define conditions

        switch ($object_type) {
                case "erp_invoices":
			 	// acc_status (estat d'on prove la factura)  -->   1=pendent  2=cobrat  3=impagada  4=retornat   5=anulat
                        switch ($class) {
                        case "noves":
                                // per aqui han de passar totes les factures sigui quin sigui el seu estat, per aixo no es filtra per estat sino per acc_status='0'
                                // si es anulada, com que n'hi haura una d'import negatiu no cal fer res ja es restara de la columna que pertoqui.
                                // si una factura es crea directament a estat diferent de pendent, passara per aqui una vegada igualment, comptant que primer havia passat a pendent
                                $conditions="acc_status='0' and check_sent='1'";
                                break;
                        case "cobrades": 
				// pendents o retornades passades a cobrades
                                $conditions="(acc_status='1' or acc_status='4') and status='cobrat' and check_sent='1'";
                                break;
                        case "anulades":
				// no cal fer RES, ja que hi haura una altra factura que ja l'anulara amb import negatiu, i entrara com noves
                                break;
                        case "devolucions":
                                // cobrades passades a anulades
                                $conditions="acc_status='2' and status='anulat' and check_sent='1'";
                                break;
			case "impagades":
                                $conditions="acc_status='1' and status='impagada'";
                                break;
                        case "retornades":
                                $conditions="acc_status='2' and (status='retornat' or status='impagada') and check_sent='1'";
                                break;
			case "recuperades":
				// d'impagades a cobrades
                                $conditions="acc_status='3' and status='cobrat' and check_sent='1'";
                                break;
                        } // switch $class
			break;
                case "erp_invoices_providers":
                                // acc_status (estat d'on prove la factura)  -->   1=pendent  2=cobrat  3=impagada  4=retornat   5=anulat
                        switch ($class) {
                        case "noves":
                                $conditions="acc_status='0' and validat='1'";
                                break;
                        case "pagades":
                                // pendents o retornades passades a cobrades
                                $conditions="acc_status='1' and status='cobrat' and validat='1'";
                                break;
                        case "anulades":
                                // no cal fer RES, ja que hi haura una altra factura que ja l'anulara amb import negatiu, i entrara com noves
                                break;
                        case "devolucions":
                                // cobrades passades a anulades
                                $conditions="acc_status='2' and status='anulat' and validat='1'";
                                break;
			case "serveis-professionals": 
				// serveis a autonoms
				
				break;
                        } // switch $class
                        break;
		case "erp_finance_bank_accounts":
			switch ($class) {
                        case "nous":
				// alta de subcomptes dels nous comptes bancaris si es que n'hi ha
				$owner="INTERGRID SL";
				$conditions="owner='".$owner."' and type='bank_account'";
				break;
			}
			break;
		case "erp_finance_banks_transactions":
			switch ($class) {
                        case "prestecs-societat-a-socis":
                                $conditions="txn_type='ajustaments' and import<0 and validat='1'";
                                break;
			case "prestecs-socis-a-societat":
				$conditions="txn_type='ajustaments' and import>0 and validat='1'";
                                break;
			case "credit-financer-alta":
                                $conditions="txn_type='credit financer' and import>0 and validat='1'";
                                break;
			case "credit-financer-quota":
                                $conditions="txn_type='credit financer' and import<0 and validat='1'";
                                break;
                        }
                        break;
		case "erp_paysheets":
			switch ($class) {
                        case "":
                                $conditions="txn_type='ajustaments' and import<0 and validat='1'";
                                break;	
			}  // switch $object_type

	}  //switch object_type

	// Step 2: ITERATE - creem els assentaments en funcio del tipus
	if (!$conditions) { echo 'error: no conditions available for object type '.$object_type.' class '.$class."\n"; return false; }

	       $sel="SELECT * FROM {$table} WHERE {$conditions}";
	       $res=mysqli_query($dblink_local,$sel);
	       if (!$res) die(mysqli_error($res));
	       while ($obj=mysqli_fetch_array($res)) {

                	switch ($object_type) {

                        case "erp_invoices":

				// init
                                $exercici=date('Y',strtotime($obj['creation_date']));
				if ($obj['payment_method']=='8') $tresoreria="570"; //caixa -pagament en efectiu
                                else $tresoreria="572"; // compte corrent

                                switch ($class) {
                                case "noves":
					/*   debit   credit
					430x TOTAL            : al client comptem que ens donara/deu un valor de TOTAL (va a debit perque a credit voldria dir que li paguem nosaltres)
					700          BASE     : a vendes comptabilitzem entrada de BASE // sempre creix per credit
					477          IVA      : a hisenda haurem de pagar IVA
                                        */
                                        $acc=add_if_not_exists($obj['sr_client'],"4300","client");
                                        echo "Afegint assentament per factura pendent ".$obj['number']."\n";
                                        add_entry("1",$acc['account'],$obj['total'],0,$obj['id'],$object_type);
                                        add_entry("1","700",0,$obj['base'],$obj['id'],$object_type);
                                        add_entry("1","477",0,$obj['total_tax'],$obj['id'],$object_type);
                                        set_object_status("1",$object_type,$obj['id']);
                                case "cobrades":
                                        /*   debit   credit
                                        570/572     TOTAL            : al banc hi posem TOTAL
                                        430x         TOTAL    : el client ja no ens deu res  (pagament)
                                        */
                                        echo "Afegint assentament per factura cobrada ".$obj['number']."\n";
                                        $acc=get_account_by_object($obj['sr_client'],"ent_clients");
                                        add_entry("1",$tresoreria,$obj['total'],0,$obj['id'],$object_type);
                                        add_entry("1",$acc['account'],0,$obj['total'],$obj['id'],$object_type);
                                        set_object_status("2",$object_type,$obj['id']);
                                        break;
                                case "devolucions":
                                        /*   debit   credit
                                        430x         TOTAL    : es una devolucio, li debem al client el TOTAL de la factura
                                        708   BASE            : incrementem compte devolucions ventes (despres per saber benefici caldra sumar tots els 70x)
                                        477   IVA             : restem IVA 
                                        */
                                        echo "Afegint assentament per factura cobrada ".$obj['number']."\n";
                                        $acc=get_account_by_object($obj['sr_client'],"ent_clients");
					add_entry("1",$acc['account'],0,$obj['total'],$obj['id'],$object_type);
                                        add_entry("1","708",$obj['base'],0,$obj['id'],$object_type);
					add_entry("1","477",$obj['total_tax'],0,$obj['id'],$object_type);
                                        set_object_status("5",$object_type,$obj['id']);
                                        break;
                                case "impagades":
                                        /*   debit   credit
					430x         TOTAL    : restem el debit anterior 
					436  TOTAL            : el passem a cobrament dubtos/improbable 
					*/
					$acc=get_account_by_object($obj['sr_client'],"ent_clients");	
				        add_entry("1",$acc['account'],0,$obj['total'],$obj['id'],$object_type);
				        add_entry("1","436",$obj['total'],0,$obj['id'],$object_type);
				        set_object_status("3",$object_type,$obj['id']);
                                        break;
				case "retornades":
					/*   debit   credit
                                        430x TOTAL            : tornem el deute TOTAL a client
                                        572          TOTAL    : restem banc el que haviem posat
                                        */
					$acc=get_account_by_object($obj['sr_client'],"ent_clients");
                                        add_entry("1",$acc['account'],0,$obj['total'],$obj['id'],$object_type);
                                        add_entry("1","572",0,$obj['total'],$obj['id'],$object_type);
                                        set_object_status("3",$object_type,$obj['id']);
                                        break;
                                case "recuperades":
                                        /*   debit   credit
                                        436          TOTAL    : restem cobrament improbable
					572  TOTAL            : al banc hi posem TOTAL
                                        */
                                        $acc=get_account_by_object($obj['sr_client'],"ent_clients");
                                        add_entry("1",$acc['account'],0,$obj['total'],$obj['id'],$object_type);
                                        add_entry("1","572",0,$obj['total'],$obj['id'],$object_type);
                                        set_object_status("2",$object_type,$obj['id']);
                                        break;
                                } // switch $class
				break;
                        case "erp_invoices_providers":

                                // init
                                if ($obj['payment_method']=='8') $tresoreria="570"; //caixa -pagament en efectiu
                                else $tresoreria="572"; // compte corrent

                                switch ($class) {
                                case "noves":
                                        /*        debit   credit
					400x              TOTAL    : proveidors
                                        6xx       BASE             : compres, obj['account_id'] (600=mercaderies, 602=altres aprovisionaments, etc.)
                                        472       IVA              : iva soportat
                                        */

					if ($obj['account_id']=='623'&&$obj['irpf']!='') {
						//serveis profesionals/creditors
	                                        $acc=add_if_not_exists($obj['sr_provider'],"410","provider");
						} else {
						//proveidor
	                                        $acc=add_if_not_exists($obj['sr_provider'],"400","provider");
					}
                                        echo "Afegint assentament per factura proveidor pendent ".$obj['number']."\n";
					add_entry("1",$acc['account'],0,$obj['total'],$obj['id'],$object_type);
                                        add_entry("1",$obj['account_id'],$obj['base'],0,$obj['id'],$object_type);
                                        add_entry("1","472",$obj['total_tax'],0,$obj['id'],$object_type);
					// retencio IRPF
					// 475            irpf    : retencio irpf a hisenda
					if ($obj['account_id']=='623'&&$obj['irpf']!='') {
					add_entry("1","475",0,$obj['irpf'],$obj['id'],$object_type);
					add_entry("1",$acc['account'],0,$obj['total'],$obj['id'],$object_type);	
					}
                                        set_object_status("1",$object_type,$obj['id']);
                                case "pagades":
                                        /*        debit   credit
					400x      TOTAL            : proveidors
					572                TOTAL   : bancs/caixa
                                        */
                                        echo "Afegint assentament per factura proveidor pagada ".$obj['number']."\n";
                                        $acc=get_account_by_object($obj['sr_provider'],"ent_providers");
					add_entry("1",$acc['account'],$obj['total'],0,$obj['id'],$object_type);
                                        add_entry("1",$tresoreria,0,$obj['total'],$obj['id'],$object_type);
                                        set_object_status("2",$object_type,$obj['id']);
                                        break;
                                case "devolucions":
                                        /*    debit   credit
                                        400x  TOTAL                : es una devolucio
                                        608           BASE         : 
                                        472           IVA          : hisenda publica iva suportat
                                        */
                                        echo "Afegint assentament per factura cobrada ".$obj['number']."\n";
                                        $acc=get_account_by_object($obj['sr_provider'],"ent_providers");
                                        add_entry("1",$acc['account'],$obj['total'],0,$obj['id'],$object_type);
                                        add_entry("1","608",0,$obj['base'],$obj['id'],$object_type);
                                        add_entry("1","472",0,$obj['total_tax'],$obj['id'],$object_type);
                                        set_object_status("3",$object_type,$obj['id']);
                                        break;
                                } // switch $class
                                break;
			case "erp_finance_bank_accounts":
	                        switch ($class) {
	                        case "nous":
	                                // alta de subcomptes dels nous comptes bancaris si es que n'hi ha
					add_if_not_exists($obj['id'],"572","erp_finance_banks_accounts");
	                                break;
	                        } // switch
	                        break;
			case "erp_finance_banks_transactions":
				switch ($class) {
                                case "prestecs-socis-a-societat":
					/*      debit    credit
                                        57x     IMPORT               : tresoreria
                                        551              IMPORT      : compte corrent de socis i administradors
                                        */
                                        echo "Afegint assentament per prestec efectiu amb socis ".$obj['number']."\n";
                                        add_entry("1",$tresoreria,$obj['import'],0,$obj['id'],$object_type);
                                        add_entry("1","551",0,$obj['import'],$obj['id'],$object_type);
                                        set_object_status("2",$object_type,$obj['id']);
                                        break;
				case "prestecs-societat-a-socis":
                                        /*      debit    credit
                                        57x              IMPORT      : tresoreria
                                        551     IMPORT               : compte corrent de socis i administradors
                                        */
                                        echo "Afegint assentament per prestec efectiu amb socis ".$obj['number']."\n";
                                        add_entry("1",$tresoreria,0,$obj['import'],$obj['id'],$object_type);
                                        add_entry("1","551",$obj['import'],0,$obj['id'],$object_type);
                                        set_object_status("2",$object_type,$obj['id']);
                                        break;
				case "credit-financer-alta":
					/*      debit    credit
                                        572     IMPORT                     : concessio credit
					5200             IMPORT ANY        : prestecs a curt termini amb entitats de credit (amortitzacio 1er any)
                                        170              IMPORT RESTANT    : deutes a llarg termini amb entitats de credit (credit pendent resta anys)

					572              despeses          : despeses banc
					626     comissions                 : comissins bancaries a serveis bancaris i similars
                                        572     serveis                    : serveis de professionals independents
                                        */
					// llegir credit de taula de credits, i calcular amortitzacio, anys, quota, ineress, comissio oportura..	
					break;
				case "credit-financer-quota":
					/*      debit    credit
                                        572              IMPORT            : quota
                                        5200    amort                      : amortitzacio a curt termini
                                        6623    interes                    : interessos de deutes amb entitats de credit
                                        */
                                        break;
                                } //switch
                                break;
		} //switch $object_type;
	} //while 
}

?>
