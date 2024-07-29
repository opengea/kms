<?
// ----------------------------------------------
// Intergrid KMS Cloud Hosting Manager Tool
// By Jordi Berenguer <j.berenguer@intergrid.cat>
// www.intergrid.cat
// ----------------------------------------------
include_once "/usr/local/kms/lib/include/functions.php";
// Constants
$bytes2Gb=1073741824;

// Setup
$used_color2="#00A0ff";
$used_color="#0070cf";
$extra_color="#f00";
$freemin_color="#e0efff";
$freemin_color2="#B0BBE0";
$freemax_color="#a2efff";
$freemax_color2="#7ABBEC";

// Bottoms i Tops per cloud hosting
$bottom_space=1;$top_space=100;
$bottom_transfer=10;$top_transfer=1000;
$bottom_vhosts=1;$top_vhosts=50;
$bottom_mailboxes=0;$top_mailboxes=300;
$bottom_subdomains=0;$top_subdomains=300;
$bottom_databases=1;$top_databases=150;
$bottom_ftps=1;$top_ftps=300;

// Get Hosting params
$basePrice=0;
$basePrice_start=-0.864;  
$basePrice_standard=-0.182; //massa diferencia, massa barato
$basePrice_pro=-0.159;
$basePrice_business=-0.166;
$basePrice_preserver=0;

// Increments mensuals per unitat


include "tarifes_ch.php";


// ----------------- SUBMIT -----------------------
if ($_POST['new_max_space']!="") {
		//comprovacio de tarifa
		$period=$_POST['periodicitat'];
               
		//descomptes
                $months=1; $months_discount=0; //force month
                $espai=$_POST['new_max_space'];
                $transferencia=$_POST['new_max_transfer'];
                $vhosts=$_POST['max_vhosts'];
                $mailboxes=$_POST['max_mailboxes'];
		if ($_POST['pla']=="start") {
                        $basePrice=$basePrice_start;
                        $cost_espai_add=$cost_espai_add_1;
                        $cost_transferencia_add=$cost_transferencia_add_1;
                        $cost_mailboxes_add=$cost_mailboxes_add_1;
                        $cost_vhosts_add=$cost_vhosts_add_1;
                } else if ($_POST['pla']=="standard") {
                        $basePrice=$basePrice_standard;
                        $cost_espai_add=$cost_espai_add_2;
                        $cost_transferencia_add=$cost_transferencia_add_2;
                        $cost_mailboxes_add=$cost_mailboxes_add_2;
                        $cost_vhosts_add=$cost_vhosts_add_2;
                } else if ($_POST['pla']=="pro") {
                        $basePrice=$basePrice_pro;
                        $cost_espai_add=$cost_espai_add_3;
                        $cost_transferencia_add=$cost_transferencia_add_3;
                        $cost_mailboxes_add=$cost_mailboxes_add_3;
                        $cost_vhosts_add=$cost_vhosts_add_3;
                } else if ($_POST['pla']=="business") {
                        $basePrice=$basePrice_business;
                        $cost_espai_add=$cost_espai_add_4;
                        $cost_transferencia_add=$cost_transferencia_add_4;
                        $cost_mailboxes_add=$cost_mailboxes_add_4;
                        $cost_vhosts_add=$cost_vhosts_add_4;
                } else if ($_POST['pla']=="preserver") {
                        $basePrice=$basePrice_preserver;
                        $cost_espai_add=$cost_espai_add_5;
                        $cost_transferencia_add=$cost_transferencia_add_5;
                        $cost_mailboxes_add=$cost_mailboxes_add_5;
                        $cost_vhosts_add=$cost_vhosts_add_5;
                }
 
		$quota_mes=$basePrice+($espai*$cost_espai_add+$transferencia*$cost_transferencia_add+$mailboxes*$cost_mailboxes_add+$vhosts*$cost_vhosts_add);
//	echo $basePrice."+($espai*$cost_espai_add+$transferencia*$cost_transferencia_add+$mailboxes*$cost_mailboxes_add+$vhosts*$cost_vhosts_add);";
       		 $quota=$quota_mes*$months;
/*                $quota=round($quota*pow(10,2))/pow(10,2);
*/
                $quota_show=$quota;

		//apliquem tarifa en funcio de periodicitat
                if ($period=="1Y") { $months=12; $months_discount=11; }
                else if ($period=="3M") { $months=3; $months_discount=2.9; }
                else if ($period=="1M") { $months=1; $months_discount=0; }


                if ($months_discount>0) {
                        $quota_discount=$quota_mes*$months_discount;
                        $estalvi=$quota-$quota_discount;
                        $quota_discount=round($quota_discount*pow(10,2))/pow(10,2);
                        $estalvi=round($estalvi*pow(10,2))/pow(10,2);
                        $quota_show=$quota_discount;
                } else {
                        $quota=round($quota*pow(10,2))/pow(10,2);
                        $quota_show=$quota;
                }
	// SECURITY CHECK
	if ($quota_show!=$_POST['new_quota']) die ('Error. Corrupted data. No coincideixen les quotes '.$quota."|".$quota_mes."|".$quota_show."!=".$_POST['new_quota']);

	if ($_GET['app']!="sysadmin"&&$_GET['app']!="cp-admin") { 
		$select="SELECT * FROM kms_isp_clients where sr_user=".$this->user_account['id'];
		$result=mysqli_query($dblink_erp,$select);
		if (!$result) die(mysqli_error($result));
		$client=mysqli_fetch_array($result);
		$addcheck=" AND sr_client=".$client['id']; // no es sr_client??
	} else {
		$addcheck="";
	}

	include "/usr/local/kms/lib/mod/shared/db_links.php";

	if ($period=="1Y") {$_period="1Y"; $time_add="+1 year"; }
        else if ($period=="1M") {$_period="1M"; $time_add="+1 month"; }
        else if ($period=="3M") {$_period="3M"; $time_add="+3 months"; }

	if ($_POST['hosting_plan']=="start") $sr_ecom_service=13; 
        else if ($_POST['hosting_plan']=="standard")  $sr_ecom_service=14; 
        else if ($_POST['hosting_plan']=="pro")  $sr_ecom_service=15;
        else if ($_POST['hosting_plan']=="business")  $sr_ecom_service=16;
        else if ($_POST['hosting_plan']=="preserver")  $sr_ecom_service=17;
	if ($_REQUEST['action']=="hosting_manage") {
	// ------------ HOSTING MANAGE ------------------
		$hosting=$this->dbi->get_record("select * from kms_isp_hostings WHERE id=".$_GET['id'],$dblink_cp);
		if ($hosting['sr_contract']!="") {
			// update hosting
			$new_max_space_bytes=$_POST['new_max_space']*$bytes2Gb;
			$new_max_transfer_bytes=$_POST['new_max_transfer']*$bytes2Gb;
			$update="UPDATE kms_isp_hostings SET sr_ecom_service='".$sr_ecom_service."',max_space='".$new_max_space_bytes."',max_transfer='".$new_max_transfer_bytes."',max_mailboxes='".$_POST['max_mailboxes']."',max_vhosts='".$_POST['max_vhosts']."' WHERE id=".$_GET['id'];
			$res=mysqli_query($dblink_cp,$update);
			$res=mysqli_query($dblink_erp,$update);
			// update vhosts limits of this hosting
			$update="UPDATE kms_isp_hostings_vhosts SET max_space='".$new_max_space_bytes."',max_transfer='".$new_max_transfer_bytes."' where hosting_id=".$_GET['id'];
			$res=mysqli_query($dblink_cp,$update);
	                $res=mysqli_query($dblink_erp,$update);
			// update contract
			$update="UPDATE kms_erp_contracts SET sr_ecom_service='".$sr_ecom_service."',price='{$quota_show}',billing_period='{$_period}' WHERE id=".$hosting['sr_contract'];
			$res=mysqli_query($dblink_cp,$update);
	                $res=mysqli_query($dblink_erp,$update);
			echo "<script language=\"javascript\">redirect('/?app=".$_GET['app']."&mod=".$_GET['mod']."');</script>";
		} else {
			die('Error. Corrupt data.');
		}

	} else if ($_REQUEST['action']=="new_hosting") {
	// -------------- NEW HOSTING -------------------
//echo "New hosting setup....";
		$client=$this->dbi->get_record("SELECT * FROM kms_isp_clients where sr_user=".$this->user_account['id'],$dblink_cp);
		$contract=array("creation_date"=>date('Y-m-d H:i:s'),"status"=>"active","sr_client"=>$client['sr_client'],"sr_ecom_service"=>$sr_ecom_service,"initial_date"=>date('Y-m-d H:i:s'),"end_date"=>date('Y-m-d H:i:s'),"billing_period"=>$_period,"auto_renov"=>1,"alta"=>0,"price"=>$quota_show,"payment_method"=>$client['sr_payment_method'],"invoice_pending"=>1);
//echo $this->dbi->make_insert($contract,"kms_erp_contracts");exit;
		$contract['id']=$this->dbi->insert_record("kms_erp_contracts",$contract,$dblink_cp,$dblink_erp);
//		$contract['id']=$this->dbi->insert_record("kms_erp_contracts",$contract,$dblink_erp);
		//Call function onInsert!...but we are in CP!
		$contracts = new erp_contracts($this->client_account,$this->user_account,$this->dm);
		$contract['isp_client_id']=$client['id'];
		$x=$contracts->onInsert($contract,$contract['id']); //create hosting
		//Set custom limits
		$hosting=$this->dbi->get_record("select * from kms_isp_hostings WHERE sr_contract=".$contract['id'],$dblink_cp);
                if ($hosting['sr_contract']!="") {
                        // update hosting
                        $new_max_space_bytes=$_POST['new_max_space']*$bytes2Gb;
                        $new_max_transfer_bytes=$_POST['new_max_transfer']*$bytes2Gb;
                        $update="UPDATE kms_isp_hostings SET sr_ecom_service='".$sr_ecom_service."',max_space='".$new_max_space_bytes."',max_transfer='".$new_max_transfer_bytes."',max_mailboxes='".$_POST['max_mailboxes']."',max_vhosts='".$_POST['max_vhosts']."' WHERE sr_contract=".$contract['id'];
                        $res=mysqli_query($dblink_cp,$update);
                        $res=mysqli_query($dblink_erp,$update);
                        // update vhosts limits of this hosting
                        $update="UPDATE kms_isp_hostings_vhosts SET max_space='".$new_max_space_bytes."',max_transfer='".$new_max_transfer_bytes."' where hosting_id=".$hosting['id'];
                        $res=mysqli_query($dblink_cp,$update);
                        $res=mysqli_query($dblink_erp,$update);
                        // update contract
                        $update="UPDATE kms_erp_contracts SET sr_ecom_service='".$sr_ecom_service."',price='{$quota_show}',billing_period='{$_period}' WHERE id=".$contract['id'];
                        $res=mysqli_query($dblink_cp,$update);
                        $res=mysqli_query($dblink_erp,$update);
                        echo "<script language=\"javascript\">redirect('/?app=".$_GET['app']."&mod=".$_GET['mod']."');</script>";
                } else {
                        die("Hosting created but not updated. Fix the limits again.");
                }
		//echo "Done.";
	echo "<script language='javascript'>document.location='/?app=".$_GET['app']."&mod=isp_hostings';</script>";
	}
} else {
// ----------------- MANAGE ----------------------
        include "/usr/local/kms/lib/mod/shared/db_links.php";
	if ($_GET['id']!="") {
        $hosting=$this->dbi->get_record("select * from kms_isp_hostings WHERE id=".$_GET['id'],$dblink_cp);
	$contract=$this->dbi->get_record("select * from kms_erp_contracts WHERE id=".$hosting['sr_contract'],$dblink_erp);
if ($hosting['sr_ecom_service']==13) $client_plan="start";
   else if ($hosting['sr_ecom_service']==14) $client_plan="standard";
   else if ($hosting['sr_ecom_service']==15) $client_plan="pro";
   else if ($hosting['sr_ecom_service']==16) $client_plan="business";
   else if ($hosting['sr_ecom_service']==17) $client_plan="preserver";
   else $client_plan="standard";
	}

if ($_GET['id']=="") {
	$client_plan="standard";
	$new=true;
	// NEW HOSTING. Take the standard values
	$hosting=$this->dbi->get_record("select * from kms_isp_hostings_plans where name=\"Cloud Hosting Standard\"");
	$space_used=0;
	$transfer_used=0;
	$mailboxes_used=0;
	$vhosts_used=0;
	$subdomains_used=0;
	$databases_used=0;
	$ftps_used=0;
	// LIMIT DE CONTRACTE
        $max_space=$hosting['max_space']/$bytes2Gb;
        $max_transfer=$hosting['max_transfer']/$bytes2Gb;
        $max_vhosts=$hosting['max_vhosts'];
        $max_mailboxes=$hosting['max_mailboxes'];

        if ($max_mailboxes=="") $max_mailboxes=0;
        if ($max_transfer=="") $max_transfer=0;
        if ($max_vhosts=="") $max_vhosts=0;
        if ($max_space=="") $max_space=0;


} else {

	$new=false;
	$select="select * from kms_isp_hostings where id=".$_GET['id'];
	$res=mysqli_query($dblink_cp,$select);
	$hosting=mysqli_fetch_array($res);
	// Get current usage 
	if (date('Y-m')!=$_REQUEST['date'])  {
	// el script serveix per consultar dates passades... si hi ha dades.
	//$select2="select * from kms_isp_hostings_log where hplan_id=".$hosting['id']." and date like '".date('Y-m')."%'";
	//$res=mysqli_query($dblink_cp,$select2);
	//$hosting_log=mysqli_fetch_array($res);
	$hosting_log=$hosting;
	} else {
	$hosting_log=$hosting;
	}

	// RECURSOS UTILITZATS
	$space_used=round(($hosting_log['used_space']/$bytes2Gb)*100)/100; // 2 decimals
	$transfer_used=round(($hosting_log['used_transfer']/$bytes2Gb)*100)/100; //2 decimals
	
	//$vhosts_used=$hosting_log['used_vhosts'];
	// take real value
	$tmp=$this->dbi->get_record("select count(*) from kms_isp_hostings_vhosts where hosting_id=".$_GET['id']);
	$vhosts_used=$tmp[0];
	// take real value
	$tmp=$this->dbi->get_record("select count(*) from kms_isp_mailboxes where vhost_id=ANY (select id from kms_isp_hostings_vhosts where hosting_id='".$_GET['id']."')");
	
	$mailboxes_used=$tmp[0];//$hosting_log['used_mailboxes'];
	
	// LIMIT DE CONTRACTE
	$max_space=$hosting_log['max_space']/$bytes2Gb;
	$max_transfer=$hosting_log['max_transfer']/$bytes2Gb;
	$max_vhosts=$hosting_log['max_vhosts'];
	$max_mailboxes=$hosting_log['max_mailboxes'];
	if ($max_mailboxes=="") $max_mailboxes=0;
	if ($max_transfer=="") $max_transfer=0;
	if ($max_vhosts=="") $max_vhosts=0;
	if ($max_space=="") $max_space=0;	
}
if (!is_numeric($mailboxes_used)) $mailboxes_used=0;
if (!is_numeric($vhosts_used)) $vhosts_used=1;

// LIMIT DE CONTRACTE (PERCENTATGE)
$max_space_pc=round(($max_space*100)/$top_space);
$max_transfer_pc=round(($max_transfer*100)/$top_transfer);
$max_vhosts_pc=round(($max_vhosts*100)/$top_vhosts);
$max_mailboxes_pc=round(($max_mailboxes*100)/$top_mailboxes);

// NEEDED?
$ratio_space=1; // 1 a 1
$ratio_transfer=5; // x5
$ratio_vhosts=0.5; //la meitat
$ratio_mailboxes=$top_mailboxes/$top_space;
$ratio_subdomains=$top_subdomains/$top_space;
$ratio_databases=$top_databases/$top_space;
$ratio_ftps=$top_ftps/$top_space;

// RECURSOS UTILITZATS (PERCENTATGE)
$space_used_pc=round(($space_used*100)/$top_space);
$transfer_used_pc=round(($transfer_used*100)/$top_transfer);
$vhosts_used_pc=round(($vhosts_used*100)/$top_vhosts);
$mailboxes_used_pc=round(($mailboxes_used*100)/$top_mailboxes);

?>
<script language="javascript">
ocult=true;
function toggleFeatures() {
	$('#full_features').slideToggle('fast');
	if (ocult) {  ocult=false; $('#see').html("<?=_KMS_ISP_HOSTINGS_CLOSE_FEATURES?>"); }
	else { ocult=true; $('#see').html("<?=_KMS_ISP_HOSTINGS_SEE_FEATURES?>"); }

	setTimeout('refreshUI()',200);
}
function valida() {
        valid=validateLimits($('#space').val(),"limit_space");
        if (valid) valid=validateLimits($('#transfer').val(),"limit_transfer");
        if (valid) valid=validateLimits($('#mailboxes').val(),"limit_mailboxes");
        if (valid) valid=validateLimits($('#vhosts').val(),"limit_vhosts");

        if (!valid) {
		alert(unescape('<?=alert_accents(_KMS_ISP_HOSTING_ALERT_OVERQUOTA)?>'));
		return false;
	} else {
        	if ($('input#accept').is(':checked')) return true;
	        else alert(unescape('<?=alert_accents(_KMS_GL_TERMS_MUST_AGREE)?>'));
        }
	return false;
}


//Set global limits
bottom_space=<?=$bottom_space?>;top_space=<?=$top_space?>;
bottom_transfer=<?=$bottom_transfer?>;top_transfer=<?=$top_transfer?>;
bottom_vhosts=<?=$bottom_vhosts?>;top_vhosts=<?=$top_vhosts?>;
bottom_mailboxes=<?=$bottom_mailboxes?>;top_mailboxes=<?=$top_mailboxes?>;
//Set ratios
ratio_space=<?=$ratio_space?>;
ratio_transfer=<?=$ratio_transfer?>;
ratio_vhosts=<?=$ratio_vhosts?>;

        function setSlide(name,value) {
		$('#'+name).slider('value',value);
		name2=name.replace('limit_','');
		$('input#new_max_'+name2).val($('input#'+name2).val());
                $('input#'+name2).val(value);
		value=checkLimits(value,$('#min_'+name).val(),$('#max_'+name).val(),name);
        }

	function setLimits(name,min,max,step,value) {
		$('input#min_'+name).val(min);
		$('input#max_'+name).val(max);
		$('#'+name).slider("option","min",0);
		$('#'+name).slider("option","max",max);
		$('#'+name).slider("option","step",step);
//		timer=setTimeout("$('#'"+name+").slider('value',"+value+")",50);
		timer=setTimeout("setSlide('"+name+"',"+value+")",50);
	}
	function changeplan(value) {
		$('input#hosting_plan').val(value);
		if (value=="start") { 
		setLimits('limit_space',<?=$pla['start']['space']['min']?>,<?=$pla['start']['space']['max']?>,<?=$pla['start']['space']['step']?>,<?=$pla['start']['space']['value']?>);
		setLimits('limit_transfer',<?=$pla['start']['transfer']['min']?>,<?=$pla['start']['transfer']['max']?>,<?=$pla['start']['transfer']['step']?>,<?=$pla['start']['transfer']['value']?>);
		setLimits('limit_mailboxes',<?=$pla['start']['emails']['min']?>,<?=$pla['start']['emails']['max']?>,<?=$pla['start']['emails']['step']?>,<?=$pla['start']['emails']['value']?>);
		setLimits('limit_vhosts',<?=$pla['start']['domains']['min']?>,<?=$pla['start']['domains']['max']?>,<?=$pla['start']['domains']['step']?>,<?=$pla['start']['domains']['value']?>);
		basePrice=<?=$basePrice_start?>;	
		cost_espai_add=<?=$cost_espai_add_1?>;
		cost_transferencia_add=<?=$cost_transferencia_add_1?>;
		cost_mailboxes_add=<?=$cost_mailboxes_add_1?>;
		cost_vhosts_add=<?=$cost_vhosts_add_1?>;
		}
		else if (value=="standard") { 
                setLimits('limit_space',<?=$pla['standard']['space']['min']?>,<?=$pla['standard']['space']['max']?>,<?=$pla['standard']['space']['step']?>,<?=$pla['standard']['space']['value']?>);
                setLimits('limit_transfer',<?=$pla['standard']['transfer']['min']?>,<?=$pla['standard']['transfer']['max']?>,<?=$pla['standard']['transfer']['step']?>,<?=$pla['standard']['transfer']['value']?>);
                setLimits('limit_mailboxes',<?=$pla['standard']['emails']['min']?>,<?=$pla['standard']['emails']['max']?>,<?=$pla['standard']['emails']['step']?>,<?=$pla['standard']['emails']['value']?>);
                setLimits('limit_vhosts',<?=$pla['standard']['domains']['min']?>,<?=$pla['standard']['domains']['max']?>,<?=$pla['standard']['domains']['step']?>,<?=$pla['standard']['domains']['value']?>);

		basePrice=<?=$basePrice_standard?>;
                cost_espai_add=<?=$cost_espai_add_2?>;
                cost_transferencia_add=<?=$cost_transferencia_add_2?>;
                cost_mailboxes_add=<?=$cost_mailboxes_add_2?>;
                cost_vhosts_add=<?=$cost_vhosts_add_2?>;
                }
		else if (value=="pro") {
                setLimits('limit_space',<?=$pla['pro']['space']['min']?>,<?=$pla['pro']['space']['max']?>,<?=$pla['pro']['space']['step']?>,<?=$pla['pro']['space']['value']?>);
                setLimits('limit_transfer',<?=$pla['pro']['transfer']['min']?>,<?=$pla['pro']['transfer']['max']?>,<?=$pla['pro']['transfer']['step']?>,<?=$pla['pro']['transfer']['value']?>);
                setLimits('limit_mailboxes',<?=$pla['pro']['emails']['min']?>,<?=$pla['pro']['emails']['max']?>,<?=$pla['pro']['emails']['step']?>,<?=$pla['pro']['emails']['value']?>);
                setLimits('limit_vhosts',<?=$pla['pro']['domains']['min']?>,<?=$pla['pro']['domains']['max']?>,<?=$pla['pro']['domains']['step']?>,<?=$pla['pro']['domains']['value']?>);

                basePrice=<?=$basePrice_pro?>;
                cost_espai_add=<?=$cost_espai_add_3?>;
                cost_transferencia_add=<?=$cost_transferencia_add_3?>;
                cost_mailboxes_add=<?=$cost_mailboxes_add_3?>;
                cost_vhosts_add=<?=$cost_vhosts_add_3?>;                }
		else if (value=="business") {
                setLimits('limit_space',<?=$pla['business']['space']['min']?>,<?=$pla['business']['space']['max']?>,<?=$pla['business']['space']['step']?>,<?=$pla['business']['space']['value']?>);
                setLimits('limit_transfer',<?=$pla['business']['transfer']['min']?>,<?=$pla['business']['transfer']['max']?>,<?=$pla['business']['transfer']['step']?>,<?=$pla['business']['transfer']['value']?>);
                setLimits('limit_mailboxes',<?=$pla['business']['emails']['min']?>,<?=$pla['business']['emails']['max']?>,<?=$pla['business']['emails']['step']?>,<?=$pla['business']['emails']['value']?>);
                setLimits('limit_vhosts',<?=$pla['business']['domains']['min']?>,<?=$pla['business']['domains']['max']?>,<?=$pla['business']['domains']['step']?>,<?=$pla['business']['domains']['value']?>);

                basePrice=<?=$basePrice_business?>;
                cost_espai_add=<?=$cost_espai_add_4?>;
                cost_transferencia_add=<?=$cost_transferencia_add_4?>;
                cost_mailboxes_add=<?=$cost_mailboxes_add_4?>;
                cost_vhosts_add=<?=$cost_vhosts_add_4?>;
                }
		else if (value=="preserver") {
                setLimits('limit_space',<?=$pla['preserver']['space']['min']?>,<?=$pla['preserver']['space']['max']?>,<?=$pla['preserver']['space']['step']?>,<?=$pla['preserver']['space']['value']?>);
                setLimits('limit_transfer',<?=$pla['preserver']['transfer']['min']?>,<?=$pla['preserver']['transfer']['max']?>,<?=$pla['preserver']['transfer']['step']?>,<?=$pla['preserver']['transfer']['value']?>);
                setLimits('limit_mailboxes',<?=$pla['preserver']['emails']['min']?>,<?=$pla['preserver']['emails']['max']?>,<?=$pla['preserver']['emails']['step']?>,<?=$pla['preserver']['emails']['value']?>);
                setLimits('limit_vhosts',<?=$pla['preserver']['domains']['min']?>,<?=$pla['preserver']['domains']['max']?>,<?=$pla['preserver']['domains']['step']?>,<?=$pla['preserver']['domains']['value']?>);

                basePrice=<?=$basePrice_preserver?>;
                cost_espai_add=<?=$cost_espai_add_5?>;
                cost_transferencia_add=<?=$cost_transferencia_add_5?>;
                cost_mailboxes_add=<?=$cost_mailboxes_add_5?>;
                cost_vhosts_add=<?=$cost_vhosts_add_5?>;
                }

		checkLimits($('#space').val,$('#min_space').val(),$('#max_space').val(),"limit_space");
		checkLimits($('#transfer').val,$('#min_transfer').val(),$('#max_transfer').val(),"limit_transfer");
		checkLimits($('#mailboxes').val,$('#min_mailboxes').val(),$('#max_mailboxes').val(),"limit_mailboxes");
		checkLimits($('#vhosts').val,$('#min_vhosts').val(),$('#max_vhosts').val(),"limit_vhosts");
		<? if (!$new) { ?> timer=setTimeout("setCurrentMaxs()",100); <? } ?>
	
	}
	function configure(value,name) {
		name2=name.replace('limit_','');
		$('input#new_max_'+name2).val($('input#'+name2).val());
		value=checkLimits(value,$('#min_'+name).val(),$('#max_'+name).val(),name);
		if (name=='limit_space') {
				$('input#max_space').val(value);
				$('input#space').val($('input#max_space').val());
		} else if (name=='limit_transfer') {
				$('input#max_transfer').val(value);
				$('input#transfer').val($('input#max_transfer').val());
		} else if (name=='limit_vhosts') {
				$('input#max_vhosts').val(value);
				$('input#vhosts').val($('input#max_vhosts').val());
		} else if (name=='limit_mailboxes') {
				$('input#max_mailboxes').val(value);
				$('input#mailboxes').val($('input#max_mailboxes').val());
		}
		timer=setTimeout("fillSliders()",1);//	fillSliders();
		setQuota();
		updateForm();	
	}

	function updateForm() {
		max_space_bytes=$('#limit_space').slider('value');
		max_transfer_bytes=$('#limit_transfer').slider('value');
		max_space_bytes=max_space_bytes*<?=$bytes2Gb?>;
		max_transfer_bytes=max_transfer_bytes*<?=$bytes2Gb?>;
		$('input#max_space').val(max_space_bytes);
		$('input#max_transfer').val(max_transfer_bytes);
		$('input#max_vhosts').val($('#limit_vhosts').slider('value'));
	}

	function warnShow(msg) {
		$('#warn').html(msg); 
                if (document.actiu) $('#warn').show('fast');
	}

	function validateLimits(value,name) {
		if (name=="limit_space") used=<?=$space_used?>;
                else if (name=="limit_transfer") used=<?=$transfer_used?>;
                else if (name=="limit_mailboxes") used=<?=$mailboxes_used?>;
                else if (name=="limit_vhosts") used=<?=$vhosts_used?>;
                if (name=="limit_space"||name=="limit_transfer") unit="GB"; 
                else if (name=="limit_vhosts") unit="<?=strtolower(_KMS_TY_ISP_DOMAINS)?>";
                else if (name=="mailboxes") unit="@";

                if (parseFloat(value)<parseFloat(used)) {
                        timer2=setTimeout("warnShow('<?=_KMS_ISP_HOSTING_MANAGE_WARN3?>"+used+" "+unit+")')",500);
			return false;
                } 
                return true;
        }

	function checkLimits(value,min,max,name) {
		if (name=="limit_space") used=<?=$space_used?>;
		else if (name=="limit_transfer") used=<?=$transfer_used?>;
		else if (name=="limit_mailboxes") used=<?=$mailboxes_used?>;
		else if (name=="limit_vhosts") used=<?=$vhosts_used?>;

		if (name=="limit_space"||name=="limit_transfer") unit="GB"; 
		else if (name=="limit_vhosts") unit="<?=strtolower(_KMS_TY_ISP_DOMAINS)?>";
		else if (name=="mailboxes") unit="@";

		if (parseFloat(value)<parseFloat(min)) { <?// per sota del minim no deixa baixar?>
			$('#'+name).trigger("mouseup");
			timer=setTimeout("$('#"+name+"').slider('value',"+min+")",1);		
			timer2=setTimeout("warnShow('<?=_KMS_ISP_HOSTING_MANAGE_WARN1?> "+min+" "+unit+" <?=_KMS_ISP_HOSTING_MANAGE_WARN2?>')",100);
			return min; 
		} else if (parseFloat(value)>parseFloat(max)) { <?// per sobre del limit?>
	//		$('#'+name).trigger("mouseup");
			name2=name.replace('limit_','');
			$('input#'+name2).val(max);
                        timer=setTimeout("$('#"+name+"').slider('value',"+max+")",1);           
                        timer2=setTimeout("warnShow('<?=_KMS_ISP_HOSTING_MANAGE_WARN4?> "+max+" "+unit+" <?=_KMS_ISP_HOSTING_MANAGE_WARN2?>')",100);
                        return max;

		} else if (parseFloat(value)<parseFloat(used)) { //per sota del consumit?>
                        timer2=setTimeout("warnShow('<?=_KMS_ISP_HOSTING_MANAGE_WARN3?>"+used+" "+unit+")')",500);
                        return value; <?//used  (deixem value perque no rectifiquem)?>
		} else { <?//tot ok?>
			$('#warn').html('');$('#warn').hide();
		}
		return value;
	}
	function setQuota(fix) {
		period=$('#periodicitat').val();
		if (fix==1) document.fixPeriod=period;
		
		months=1; months_discount=0; //force month	
		espai=$('#limit_space').slider('value');
                transferencia=$('#limit_transfer').slider('value');
                vhosts=$('#limit_vhosts').slider('value');
                mailboxes=$('#limit_mailboxes').slider('value');

		quota_mes=basePrice+(espai*cost_espai_add+transferencia*cost_transferencia_add+mailboxes*cost_mailboxes_add+vhosts*cost_vhosts_add);
//alert(quota_mes);

                quota=quota_mes*months;

	        quota=Math.round(quota*Math.pow(10,2))/Math.pow(10,2);
                quota_show=quota;
		if (quota_show<10) { 
			// quota mensual < 10 monstrem nomes any
			period="1Y"; $('#periodicitat').val("1Y"); period_text="<?=_KMS_GL_YEAR_U?>"; months=12; months_discount=11; discount="<?=_KMS_WEB_ECOM_DISCOUNT_1MONTH?>"; 
			$('#period_month').hide();
                        $('#period_quarter').hide();
                        $('#periodicitat').val('1Y');
                        $('#new_quota').val(quota_show);
                        $('#quota').html(quota_show+"<span style='font-size:13px;padding-top:7px'> &euro;/"+period_text.toLowerCase()+"</span>");
                        $('#quota_discount').html('');
                        $('#quota_discount').hide();
			$('#period_year').html("<?=_KMS_GL_YEAR?>");
		} else {
			// quota mensual > 10 per tant mostrem totes les opcions
			if (period=="1Y") { period_text="<?=_KMS_GL_YEAR_U?>"; months=12; months_discount=11; discount="<?=_KMS_WEB_ECOM_DISCOUNT_1MONTH?>"; }
	                else if (period=="3M") { period_text="<?=_KMS_GL_QUARTER_U?>"; months=3; months_discount=2.9; discount="<?=_KMS_WEB_ECOM_DISCOUNT_1WEEK?>";  }
        	        else if (period=="1M") { period_text="<?=_KMS_GL_MONTHLY_U?>"; months=1; months_discount=0; }
		//	if (document.fixPeriod!="") $('#periodicitat').val(document.fixPeriod); else $('#periodicitat').val('1M');
                        $('#period_month').show();
                        $('#period_quarter').show();
                        $('#period_year').html("<?=_KMS_GL_YEAR?> (20% <?=_KMS_WEB_ECOM_OPT_DISCOUNT?>)");
		}
		quota=quota_mes*months;
		if (months_discount>0) {
			quota_discount=quota_mes*months_discount;
			estalvi=quota-quota_discount;
			quota_discount=Math.round(quota_discount*Math.pow(10,2))/Math.pow(10,2);
			estalvi=Math.round(estalvi*Math.pow(10,2))/Math.pow(10,2); 
			quota_show=quota_discount;
		} else {
			quota=Math.round(quota*Math.pow(10,2))/Math.pow(10,2);
			quota_show=quota;
		}
		$('#new_quota').val(quota_show);
		if ($('#periodicitat').val()=="3M") _quota=$('#new_quota').val()/3;
                else if  ($('#periodicitat').val()=="1Y") _quota=$('#new_quota').val()/12;
                else if ($('#periodicitat').val()=="1M") _quota=$('#new_quota').val();
//alert(period+","+quota_mes+","+quota_show+","+_quota);
		$('#quota').html(quota_show+"<span style='font-size:13px;padding-top:7px'> &euro;/"+period_text.toLowerCase()+"</span>");
		if (months_discount!=0) { //&&parseFloat(_quota)>10) {
			$('#custom_quota').css('height','55px'); 
			if (period=="3M") estalvi_anual=estalvi*4; else estalvi_anual=estalvi;
			discount="-"+estalvi_anual+"&euro; d'estalvi anual";
			$('#quota_discount').html(discount);
			$('#quota_discount').show();	
			//$('#period_year').html("<?=_KMS_GL_YEAR?> (20% <?=_KMS_WEB_ECOM_OPT_DISCOUNT?>)");
		}  else {
			$('#custom_quota').css('height','40px');
			$('#quota_discount').hide();
			//$('#period_year').html("<?=_KMS_GL_YEAR?>");
		}
	}
/*	function setResources(value,pc,name) {
		mailboxes_val=Math.round(((value*<?=$ratio_mailboxes?>)+1));
		mailboxes_pc=((mailboxes_val*100)/<?=$top_mailboxes?>);
		mailboxes_used_pc=((<?=$mailboxes_used?>*100)/<?=$top_mailboxes?>);
		if (mailboxes_pc>100) mailboxes_pc=100;
		$('#limit_mailboxes').css("background-image","-webkit-linear-gradient(left, <?=$used_color?> 0px, <?=$used_color?> "+mailboxes_used_pc+"%,#D6DDE5 "+mailboxes_used_pc+"%, #0f0 "+mailboxes_pc+"%,#D6DDE5 "+mailboxes_pc+"%)");

		subdomains_val=Math.round(((value*<?=$ratio_subdomains?>)+1));
                subdomains_pc=((subdomains_val*100)/<?=$top_subdomains?>);
                subdomains_used_pc=((<?=$subdomains_used?>*100)/<?=$top_subdomains?>);
		if (subdomains_pc>100) subdomains_pc=100;
                $('#limit_subdomains').css("background-image","-webkit-linear-gradient(left, <?=$used_color?> 0px, <?=$used_color?> "+subdomains_used_pc+"%,#D6DDE5 "+subdomains_used_pc+"%, #0f0 "+subdomains_pc+"%,#D6DDE5 "+subdomains_pc+"%)");
	
		databases_val=Math.round(((value*<?=$ratio_databases?>)+1));
                databases_pc=((databases_val*100)/<?=$top_databases?>);
                databases_used_pc=((<?=$databases_used?>*100)/<?=$top_databases?>);
		if (databases_pc>100) databases_pc=100;
                $('#limit_databases').css("background-image","-webkit-linear-gradient(left, <?=$used_color?> 0px, <?=$used_color?> "+databases_used_pc+"%,#D6DDE5 "+databases_used_pc+"%, #0f0 "+databases_pc+"%,#D6DDE5 "+databases_pc+"%)");

		ftps_val=Math.round(((value*<?=$ratio_ftps?>)+1));
                ftps_pc=((ftps_val*100)/<?=$top_ftps?>);
                ftps_used_pc=((<?=$ftps_used?>*100)/<?=$top_ftps?>);
		if (ftps_pc>100) ftps_pc=100;
                $('#limit_ftps').css("background-image","-webkit-linear-gradient(left, <?=$used_color?> 0px, <?=$used_color?> "+ftps_used_pc+"%,#D6DDE5 "+ftps_used_pc+"%, #0f0 "+ftps_pc+"%,#D6DDE5 "+ftps_pc+"%)");
	}
*/
	function paint(colors) {
		s="";
		for (i=0; i<colors.length; i++) {
			s+=colors[i][0]+" "+colors[i][1]+",";
		}
		s=s.substr(0,s.length-1);
		return s;
	}

        function fillSliders() {

		<? /*** SPACE ****/ ?>
		max_space_pc=((($('#max_space').val()/<?=$bytes2Gb?>)-$('#limit_space').slider('option','min'))*100)/($('#limit_space').slider('option','max')-$('#limit_space').slider('option','min'));
		new_max_space_pc=(($('#new_max_space').val()-$('#limit_space').slider('option','min'))*100)/($('#limit_space').slider('option','max')-$('#limit_space').slider('option','min'));
		space_used_pc=(<?=$space_used?>*100)/$('#limit_space').slider('option','max');
                colors=Array();
                if (space_used_pc>max_space_pc) {
			colors[0]=Array();
			colors[0][0]="<?=$used_color?>";
			colors[0][1]="0%";
			colors[1]=Array();
                        colors[1][0]="<?=$used_color2?>";
                        colors[1][1]=max_space_pc+"%";

			colors[2]=Array();
                        colors[2][0]="<?=$extra_color?>";
                        colors[2][1]=max_space_pc+"%";
			colors[3]=Array();
                        colors[3][0]="<?=$extra_color?>";
                        colors[3][1]=space_used_pc+"%";

                        colors[4]=Array();
                        colors[4][0]="<?=$freemax_color?>";
                        colors[4][1]=space_used_pc+"%"
                        colors[5]=Array();
                        colors[5][0]="<?=$freemax_color2?>";
                        colors[5][1]=new_max_space_pc+"%";
			colors[6]=Array();
                        colors[6][0]="#fff";
                        colors[6][1]=new_max_space_pc+"%";
			colors[7]=Array();
                        colors[7][0]="#fff";
                        colors[7][1]="100%";
		} else {
			colors[0]=Array();
                        colors[0][0]="<?=$used_color?>";
                        colors[0][1]="0%";
                        colors[1]=Array();
                        colors[1][0]="<?=$used_color2?>";
                        colors[1][1]=space_used_pc+"%"
                        colors[2]=Array();
                        colors[2][0]="<?=$freemax_color?>";
                        colors[2][1]=space_used_pc+"%"
                        colors[3]=Array();
                        colors[3][0]="<?=$freemax_color2?>";
                        colors[3][1]=max_space_pc+"%";
                        colors[4]=Array();
                        colors[4][0]="#fff";
                        colors[4][1]=max_space_pc+"%";
                        colors[5]=Array();
                        colors[5][0]="#fff";
                        colors[5][1]="100%";
		}
		estil=paint(colors);
		$('#limit_space').css("background-image","url('/kms/css/aqua/img/interface/slider_bg.png'), -webkit-linear-gradient(left, "+estil+")");
		$('#limit_space').css("background-image","url('/kms/css/aqua/img/interface/slider_bg.png'), -moz-linear-gradient(left, "+estil+")");

               <? /*** TRANSFER ****/ ?>
                max_transfer_pc=((($('#max_transfer').val()/<?=$bytes2Gb?>)-$('#limit_transfer').slider('option','min'))*100)/($('#limit_transfer').slider('option','max')-$('#limit_transfer').slider('option','min'));
                new_max_transfer_pc=(($('#new_max_transfer').val()-$('#limit_transfer').slider('option','min'))*100)/($('#limit_transfer').slider('option','max')-$('#limit_transfer').slider('option','min'));
                transfer_used_pc=(<?=$transfer_used?>*100)/$('#limit_transfer').slider('option','max');
                colors=Array();
                if (transfer_used_pc>max_transfer_pc) {
                        colors[0]=Array();
                        colors[0][0]="<?=$used_color?>";
                        colors[0][1]="0%";
                        colors[1]=Array();
                        colors[1][0]="<?=$used_color2?>";
                        colors[1][1]=max_transfer_pc+"%";

                        colors[2]=Array();
                        colors[2][0]="<?=$extra_color?>";
                        colors[2][1]=max_transfer_pc+"%";
                        colors[3]=Array();
                        colors[3][0]="<?=$extra_color?>";
                        colors[3][1]=transfer_used_pc+"%";

                        colors[4]=Array();
                        colors[4][0]="<?=$freemax_color?>";
                        colors[4][1]=transfer_used_pc+"%"
                        colors[5]=Array();
                        colors[5][0]="<?=$freemax_color2?>";
                        colors[5][1]=new_max_transfer_pc+"%";
                        colors[6]=Array();
                        colors[6][0]="#fff";
                        colors[6][1]=new_max_transfer_pc+"%";
                        colors[7]=Array();
                        colors[7][0]="#fff";
                        colors[7][1]="100%";
                } else {
                        colors[0]=Array();
                        colors[0][0]="<?=$used_color?>";
                        colors[0][1]="0%";
                        colors[1]=Array();
                        colors[1][0]="<?=$used_color2?>";
                        colors[1][1]=transfer_used_pc+"%"
                        colors[2]=Array();
                        colors[2][0]="<?=$freemax_color?>";
                        colors[2][1]=transfer_used_pc+"%"
                        colors[3]=Array();
                        colors[3][0]="<?=$freemax_color2?>";
                        colors[3][1]=max_transfer_pc+"%";
                        colors[4]=Array();
                        colors[4][0]="#fff";
                        colors[4][1]=max_transfer_pc+"%";
                        colors[5]=Array();
                        colors[5][0]="#fff";
                        colors[5][1]="100%";
                }
                estil=paint(colors);
                $('#limit_transfer').css("background-image","url('/kms/css/aqua/img/interface/slider_bg.png'), -webkit-linear-gradient(left, "+estil+")");
                $('#limit_transfer').css("background-image","url('/kms/css/aqua/img/interface/slider_bg.png'), -moz-linear-gradient(left, "+estil+")");

		<? /*** MAILBOXES ****/ ?>
  
                max_mailboxes_pc=((($('#max_mailboxes').val())-$('#limit_mailboxes').slider('option','min'))*100)/($('#limit_mailboxes').slider('option','max')-$('#limit_mailboxes').slider('option','min'));
                max_mailboxes_pc=(($('#max_mailboxes').val()-$('#limit_mailboxes').slider('option','min'))*100)/($('#limit_mailboxes').slider('option','max')-$('#limit_mailboxes').slider('option','min'));
                mailboxes_used_pc=(<?=$mailboxes_used?>*100)/$('#limit_mailboxes').slider('option','max');
                colors=Array();
                if (mailboxes_used_pc>max_mailboxes_pc) {
                        colors[0]=Array();
                        colors[0][0]="<?=$used_color?>";
                        colors[0][1]="0%";
                        colors[1]=Array();
                        colors[1][0]="<?=$used_color2?>";
                        colors[1][1]=max_mailboxes_pc+"%";

                        colors[2]=Array();
                        colors[2][0]="<?=$extra_color?>";
                        colors[2][1]=max_mailboxes_pc+"%";
                        colors[3]=Array();
                        colors[3][0]="<?=$extra_color?>";
                        colors[3][1]=mailboxes_used_pc+"%";

                        colors[4]=Array();
                        colors[4][0]="<?=$freemax_color?>";
                        colors[4][1]=mailboxes_used_pc+"%"
                        colors[5]=Array();
                        colors[5][0]="<?=$freemax_color2?>";
                        colors[5][1]=max_mailboxes_pc+"%";
                        colors[6]=Array();
                        colors[6][0]="#fff";
                        colors[6][1]=max_mailboxes_pc+"%";
                        colors[7]=Array();
                        colors[7][0]="#fff";
                        colors[7][1]="100%";
                } else {
                        colors[0]=Array();
                        colors[0][0]="<?=$used_color?>";
                        colors[0][1]="0%";
                        colors[1]=Array();
                        colors[1][0]="<?=$used_color2?>";
                        colors[1][1]=mailboxes_used_pc+"%"
                        colors[2]=Array();
                        colors[2][0]="<?=$freemax_color?>";
                        colors[2][1]=mailboxes_used_pc+"%"
                        colors[3]=Array();
                        colors[3][0]="<?=$freemax_color2?>";
                        colors[3][1]=max_mailboxes_pc+"%";
                        colors[4]=Array();
                        colors[4][0]="#fff";
                        colors[4][1]=max_mailboxes_pc+"%";
                        colors[5]=Array();
                        colors[5][0]="#fff";
                        colors[5][1]="100%";
                }
                estil=paint(colors);
                $('#limit_mailboxes').css("background-image","url('/kms/css/aqua/img/interface/slider_bg.png'), -webkit-linear-gradient(left, "+estil+")");
                $('#limit_mailboxes').css("background-image","url('/kms/css/aqua/img/interface/slider_bg.png'), -moz-linear-gradient(left, "+estil+")");

		<? /*** VHOSTS ****/ ?>
                max_vhosts_pc=((($('#max_vhosts').val())-$('#limit_vhosts').slider('option','min'))*100)/($('#limit_vhosts').slider('option','max')-$('#limit_vhosts').slider('option','min'));
                max_vhosts_pc=(($('#max_vhosts').val()-$('#limit_vhosts').slider('option','min'))*100)/($('#limit_vhosts').slider('option','max')-$('#limit_vhosts').slider('option','min'));
                vhosts_used_pc=(<?=$vhosts_used?>*100)/$('#limit_vhosts').slider('option','max');
                colors=Array();
                if (vhosts_used_pc>max_vhosts_pc) {
                        colors[0]=Array();
                        colors[0][0]="<?=$used_color?>";
                        colors[0][1]="0%";
                        colors[1]=Array();
                        colors[1][0]="<?=$used_color2?>";
                        colors[1][1]=max_vhosts_pc+"%";

                        colors[2]=Array();
                        colors[2][0]="<?=$extra_color?>";
                        colors[2][1]=max_vhosts_pc+"%";
                        colors[3]=Array();
                        colors[3][0]="<?=$extra_color?>";
                        colors[3][1]=vhosts_used_pc+"%";

                        colors[4]=Array();
                        colors[4][0]="<?=$freemax_color?>";
                        colors[4][1]=vhosts_used_pc+"%"
                        colors[5]=Array();
                        colors[5][0]="<?=$freemax_color2?>";
                        colors[5][1]=max_vhosts_pc+"%";
                        colors[6]=Array();
                        colors[6][0]="#fff";
                        colors[6][1]=max_vhosts_pc+"%";
                        colors[7]=Array();
                        colors[7][0]="#fff";
                        colors[7][1]="100%";
                } else {
                        colors[0]=Array();
                        colors[0][0]="<?=$used_color?>";
                        colors[0][1]="0%";
                        colors[1]=Array();
                        colors[1][0]="<?=$used_color2?>";
                        colors[1][1]=vhosts_used_pc+"%"
                        colors[2]=Array();
                        colors[2][0]="<?=$freemax_color?>";
                        colors[2][1]=vhosts_used_pc+"%"
                        colors[3]=Array();
                        colors[3][0]="<?=$freemax_color2?>";
                        colors[3][1]=max_vhosts_pc+"%";
                        colors[4]=Array();
                        colors[4][0]="#fff";
                        colors[4][1]=max_vhosts_pc+"%";
                        colors[5]=Array();
                        colors[5][0]="#fff";
                        colors[5][1]="100%";
                }
                estil=paint(colors);
                $('#limit_vhosts').css("background-image","url('/kms/css/aqua/img/interface/slider_bg.png'), -webkit-linear-gradient(left, "+estil+")");
                $('#limit_vhosts').css("background-image","url('/kms/css/aqua/img/interface/slider_bg.png'), -moz-linear-gradient(left, "+estil+")");

	}

</script>
<?
function drawIndex($class,$value,$min,$max,$top,$unit,$name,$segments) {
	$used_color="#00a0ff";
/*	$s="<div class=\"slider_index seg_$segments\">";
	$interval=$top/$segments;
	$n=$min;
	$show_unit=$unit;
	for ($i=0;$i<=$segments;$i++) {
		$s.="<div class=\"slider_tab seg_$segments\">".$n."".$show_unit."</div>";
	  	if ($n==$min) {$show_unit="";$n=0;}
		$n+=$interval;
		if ($n==$top) $show_unit=$unit;
	}
	$s.="</div>";*/
	$pc=(($value*100)/$top);
	$max_pc = (($max*100/$top));
	if ($class=="fix") $bgcolor="#D6DDE5"; else $bgcolor="#fff";
	$s.="<div class=\"slider $class\" id=\"$name\" style=\"background-image:-webkit-linear-gradient(left, ".$used_color." 0px, ".$used_color." ".$pc."%,$bgcolor ".$pc."%);\"></div>";
	$s.="<script>function fix_$name() { $('#$name').slider('value',$max_pc); } setTimeout(\"fix_$name()\",500);";
	$step=$segments*.25;
	if ($segments==20) $step=5;
	else if ($segments==10) $step=10;
	$s.="$('#$name').slider({ step:".$step.",change: function(event, ui) { configure($('#$name').slider('value'),'$name'); },slide: function(event, ui) { configure(ui.value,'$name'); }});";
	$s.="</script>";
	return $s;
}
?>
<form action="/?_=f&id=<?=$_GET['id']?>&app=<?=$_GET['app']?>&mod=<?=$_GET['mod']?>&action=<?=$_GET['action']?>" id="manage" name="manage" method="post">

<table class="limits">
<tr>
    <td></td>
    <td>
	<img src="/kms/css/aqua/img/interface/cloud-hosting.png"><br>
	<br><h2><?
	echo _KMS_ISP_HOSTING_MANAGE.": ";
	if ($_REQUEST['type']!="") {
		$title=_KMS_ISP_HOSTING_.strtoupper($_REQUEST['type']);
		echo constant($title);
	} else echo $hosting['description']." ".$hosting['domain'];
	?></h2>
	<span style="font-size:12px"><?=_KMS_ISP_HOSTINGS_CH_MANAGE?>
<? if ($new) echo "<br>"._KMS_ISP_HOSTINGS_CH_MANAGE2;?></span>
	<br><br><br><br>
    </td>
    <td></td>
</tr>
<tr>
    <td class="slider_name" style="padding-bottom:10px"><b><?=_KMS_ISP_HOSTING_PLAN?></b></td>
    <td>
	<table id="cloudselector" style="display:none">
	<tr>	<td>
		<div id="plans_description" style="margin-left:0px;display:none">
		<table width="550"><tr>
		<td width=95 style="padding-left:10px"><div style="float:left"><input id="pla0" type="radio" value="start" name="pla" onchange="changeplan(this.value)"<? if ($client_plan=="start") echo " checked"?>></div><div class="plan"><div style="position:absolute;margin-top:-35px;margin-left:-35px"><a href="#" onclick="$('input#pla0').click()"><img src="/kms/css/aqua/img/big/ch_basic.png"></a></div>Start</div></td><td width=110><div style="float:left"><input id="pla1" type="radio" value="standard" name="pla" onchange="changeplan(this.value)"<? if ($client_plan=="standard") echo " checked"?>></div><div class="plan"><div style="position:absolute;margin-top:-35px;margin-left:-35px"><a href="#" onclick="$('input#pla1').click()"><img src="/kms/css/aqua/img/big/ch_standard.png"></a></div>Standard</div></td><td width=90><div style="float:left"><input id="pla2" type="radio" value="pro" name="pla" onchange="changeplan(this.value)"<? if ($client_plan=="pro") echo " checked"?>></div><div class="plan"><div style="position:absolute;margin-top:-35px;;margin-left:-35px"><a href="#" onclick="$('input#pla2').click()"><img src="/kms/css/aqua/img/big/ch_pro.png"></a></div>Pro</div></td><td><div style="float:left"><input id="pla3" type="radio" value="business" name="pla" onchange="changeplan(this.value)"<? if ($client_plan=="business") echo " checked"?>></div><div class="plan"><div style="position:absolute;margin-top:-35px;margin-left:-35px"><a href="#" onclick="$('input#pla3').click()"><img src="/kms/css/aqua/img/big/ch_business.png"></a></div>Business</div></td><td width=123><div style="float:left"><input  id="pla4" type="radio" value="preserver" name="pla" onchange="changeplan(this.value)"<? if ($client_plan=="preserver") echo " checked"?>></div><div class="plan"><div style="position:absolute;margin-top:-35px;margin-left:-35px"><a href="#" onclick="$('input#pla4').click()"><img src="/kms/css/aqua/img/big/ch_preserver.png"></a></div>Pre-server</div></td></tr></table>
		</div>
		</td>
	</tr>
	</table>

    </td>
    <td></td>
</tr>
<tr class="sep2">

     <td class="slider_name" style="vertical-align:top;padding-top:15px"><?=_KMS_ISP_HOSTINGS_FEATURES?></td>
     <td style="text-align:center">
<div class="notice"><a id="see" ref="#" onclick="toggleFeatures()"><?=_KMS_ISP_HOSTINGS_SEE_FEATURES?></a></div><div id="full_features" style="display:none"><br>
		<table width="560" border="0">
		<tr class="group"><td colspan=2><?=_KMS_ISP_HOSTINGS_F_AVAILABILITY?></td></tr>
		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_OS?></td><td><?=_KMS_ISP_HOSTING_FEATURE_OS_EXPLAIN?></td></tr>
		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_BANDWIDTH?></td><td><?=_KMS_ISP_HOSTING_FEATURE_BANDWIDTH_EXPLAIN?></td></tr>
		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_ARQ?></td><td><?=_KMS_ISP_HOSTING_FEATURE_ARQ_EXPLAIN?></td></tr>
		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_PERFORMANCE?></td><td><?=_KMS_ISP_HOSTING_FEATURE_PERFORMANCE_EXPLAIN?></td></tr>
                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_AVAIL?></td><td><?=_KMS_ISP_HOSTING_FEATURE_SLA_EXPLAIN?></td></tr>
		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_NETWORK?></td><td><?=_KMS_ISP_HOSTING_FEATURE_NETWORK_EXPLAIN?></td></tr>
		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_MONITORING?></td><td><?=_KMS_ISP_HOSTING_FEATURE_MONITORING_EXPLAIN?></td></tr>
                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_DC?></td><td><?=_KMS_ISP_HOSTING_FEATURE_DC_EXPLAIN?></td></tr>
		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_DC_CERT?></td><td><?=_KMS_ISP_HOSTING_FEATURE_DC_CERT_EXPLAIN?></td></tr>
                <tr class="group"><td colspan=2><?=_KMS_ISP_HOSTINGS_F_ADMIN?></td></tr>
                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_CONTROLPANEL?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_CP_DOMAINROBOT?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_FLEXIBLE_HOSTING?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_RESELLER_CP?></td><td><?=_KMS_GL_OPTIONAL?></td></tr>
		

		<tr class="group"><td colspan=2><?=_KMS_ISP_HOSTINGS_F_EMAIL?></td></tr>
		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_MAILQUOTA?></td><td><?=_KMS_ISP_HOSTING_FEATURE_MAILQUOTA_EXPLAIN?></td></tr>

		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_WEBMAIL?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_EMAIL_ALIAS?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
	        <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_EMAIL_AUTORESPONDER?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_ANTISPAM?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_ANTIVIRUS?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>

		<tr class="group"><td colspan=2><?=_KMS_ISP_HOSTINGS_F_WEBSPACE?></td></tr>

		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_WEBFORWARDING?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_DOMAINALIAS?></td><td><?=_KMS_GL_UNLIMITED2?></td></tr>
		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_DNS?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>

		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_FTPS?></td><td><?=_KMS_ISP_HOSTING_FEATURE_FTPS_EXPLAIN?></td></tr>

		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_SUBDOMAINS?></td><td><?=_KMS_ISP_HOSTING_FEATURE_SUBDOMAINS_EXPLAIN?></td></tr>
		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_MULTIDOMAIN?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_FILEMANAGER?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_DIP?></td><td>--</td></tr>
                <tr class="group"><td colspan=2><?=_KMS_ISP_HOSTINGS_F_PRO?></td></tr>

                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_PROGRAMMING?></td><td><?=_KMS_ISP_HOSTING_FEATURE_PROGRAMMING_EXPLAIN?></td></tr>
                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_DATABASES?></td><td><?=_KMS_GL_UNLIMITED3?></td></tr>
                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_DDBB_SPACE?></td><td><?=_KMS_GL_UNLIMITED?></td></tr>
	        <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_CRONTABLES?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_ERRORPAGES?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_CMS_COMPATIBLE?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_FLASH_COMPATIBLE?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_DIRHTACCESS?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_SSH?></td><td><?=_KMS_GL_OPTIONAL?></td></tr>

                <tr class="group"><td colspan=2><?=_KMS_ISP_HOSTINGS_F_WARANTY?></td></tr>

                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_SLA?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>

		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_SUPPORT_PHONE?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_SUPPORT_SYS?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_30DAYSW?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
                <tr class="group"><td colspan=2><?=_KMS_ISP_HOSTINGS_F_SECURITY?></td></tr>

                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_BACKUPS?></td><td><?=_KMS_ISP_HOSTING_FEATURE_BACKUPS_EXPLAIN?></td></tr>
		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_DIRPERM?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_DIRPROT?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_CERT?></td><td><?=_KMS_ISP_HOSTING_FEATURE_CERT_EXPLAIN?></td></tr>

                <tr class="group"><td colspan=2><?=_KMS_ISP_HOSTINGS_F_WEBSITES?></td></tr>

                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_KMS_SITES?></td><td><?=_KMS_GL_OPTIONAL?></td></tr>
                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_KMS_ECOM?></td><td><?=_KMS_GL_OPTIONAL?></td></tr>
                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_KMS_SITES_CUSTOM?></td><td><?=_KMS_GL_OPTIONAL?></td></tr>
                <tr class="group"><td colspan=2><?=_KMS_ISP_HOSTINGS_F_MARKETING?></td></tr>

                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_WEBSTATS?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_SEARCHENGINES?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
                <tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_SITEMAPS?></td><td><img src='/kms/css/aqua/img/small/check2.gif'></td></tr>
		<tr class="feature"><td class="f1"><?=_KMS_ISP_HOSTING_FEATURE_KMS_MAILING?></td><td><?=_KMS_GL_OPTIONAL?></td></tr>

		</table><br>
<div class="notice"><a href="#" onclick="toggleFeatures()"><?=_KMS_ISP_HOSTINGS_CLOSE_FEATURES?></a></div>
     </div></td>
     <td></td>
</tr>
<tr class="sep2">
     <td class="slider_name"><?=_KMS_ISP_CONTRACT?></td>
     <td><select id="periodicitat" name="periodicitat" onchange="setQuota(1)">
<?
        if ($_GET['action']!="new_hosting") {
		$add1="";
		if ($contract['billing_period']=="1M") $add1="selected"; 
		else if ($contract['billing_period']=="3M") $add2="selected";
		else if ($contract['billing_period']=="1Y") $add3="selected";
		else { $add1=" selected"; }
	} else {
		$add1=" selected"; $add2=$add3="";
	}
	?>
	<option id="period_month" value="1M" <?=$add1?>><?=_KMS_GL_MONTHLY?></option>
	<option id="period_quarter" value="3M" <?=$add2?>><?=_KMS_GL_QUARTER?></option>
	<option id="period_year" value="1Y" <?=$add3?>><?=_KMS_GL_YEAR?><? echo " (20% "._KMS_WEB_ECOM_OPT_DISCOUNT.")"?></option>
	</select>

<script>
period="<?=$contract['billing_period']?>"; $('#periodicitat').val("<?=$contract['billing_period']?>");
</script>
      </td>
      <td></td>
</tr>
<tr class="sep2">
    <td class="slider_name"><span title="<?=_KMS_ISP_HOSTINGS_SPACE_EXPLAIN?>" style="cursor:hand"><?=_KMS_ISP_HOSTINGS_SPACE?></span></td>
    <td><div id="index_space"><?echo drawIndex("flex",$space_used,$bottom_space,$max_space,$top_space,"G","limit_space",20)?></div></td>
    <td><input class='numericbox'  id='space' onchange="setSlide('limit_space',this.value)"> GB <? if (!$new) { ?>(<?=strtolower(_KMS_GL_USED)?> <?=$space_used?> GB)<?}?></div></td>
</tr>

<? /*<tr>
<td></td>
<td style='text-align:center'>
<div id="infonote"></div>
<a href="#" onclick="$('#space_details').toggle()">Mostrar/ocultar detalls</a>
</td>
<td></td>
</tr>
*/?>
<? /*
<tr id="space_details" style="display:none">
<td colspan=3>    <table width="100%" border="0">
	<tr>
	    <td class="slider_name"><?=_KMS_TY_ISP_MAILBOXES?></td>
	    <td><?echo drawIndex("fix",$mailboxes_used,$bottom_mailboxes,$max_mailboxes,$top_mailboxes,"","limit_mailboxes",10)?></td>
	    <td></td>
	</tr>
	<tr>
	    <td class="slider_name"><?=_KMS_TY_ISP_SUBDOMAINS?></td>
	    <td><?echo drawIndex("fix",$subdomains_used,$bottom_subdomains,$max_subdomains,$top_subdomains,"","limit_subdomains",10)?></td>
	    <td></td>
	</tr>
	<tr>
	    <td class="slider_name"><?=_KMS_TY_ISP_DATABASES?></td>
	    <td><?echo drawIndex("fix",$databases_used,$bottom_databases,$max_databases,$top_databases,"","limit_databases",10)?></td>
	    <td></td>
	</tr>
	<tr>
	    <td class="slider_name"><?=_KMS_TY_ISP_FTPS?></td>
	    <td><?echo drawIndex("fix",$ftps_used,$bottom_ftps,$max_ftps,$top_ftps,"","limit_ftps",10)?></td>
	    <td></td>
	</tr>
	</table>
</td>
</tr>*/?>
<tr class="sep2">
    <td class="slider_name"><span title="<?=_KMS_ISP_HOSTINGS_TRANSFER_EXPLAIN?>" style="cursor:hand"><?=_KMS_ISP_HOSTINGS_TRANSFER_SHORT?></span></td>
    <td><div id="index_transfer"><?echo drawIndex("flex",$transfer_used,$bottom_transfer,$max_transfer,$top_transfer,"G","limit_transfer",20)?></div></td>
    <td><input class='numericbox' id="transfer" onchange="setSlide('limit_transfer',this.value)"> GB <? if (!$new) {?>(<?=strtolower(_KMS_GL_USED)?> <?=$transfer_used?> GB)<?}?></td>
</tr>
<tr class="sep2">
    <td class="slider_name"><?=_KMS_TY_ISP_MAILBOXES?></td>
    <td><div id="index_mailboxes"><?echo drawIndex("flex",$mailboxes_used,$bottom_mailboxes,$max_mailboxes,$top_mailboxes,"","limit_mailboxes",10)?></div></td>
    <td><input class='numericbox' id="mailboxes" onchange="setSlide('limit_mailboxes',this.value)"> @ <? if (!$new) {?> (<?=strtolower(_KMS_GL_USED)?> <?=$mailboxes_used?>)<?}?></td>
</tr>
<tr class="sep2">
    <td class="slider_name"><?=_KMS_TY_ISP_VHOSTS?></td>
    <td><div id="index_vhosts"><?echo drawIndex("flex",$vhosts_used,$bottom_vhosts,$max_vhosts,$top_vhosts,"","limit_vhosts",10)?></div></td>
    <td><input class='numericbox' id="vhosts" onchange="setSlide('limit_vhosts',this.value)"><? if (!$new) {?> (<?=strtolower(_KMS_GL_USED)?> <?=$vhosts_used?>)<?}?></td>
</tr>
<tr class="sep2">
<td></td>
<td>
	<div id="warn" class="warn" style="background-color:#fee;padding:5px;border:1px dotted #d00;width:550px;margin-bottom:10px;display:none"></div>

<? /*	<div style="float:left;margin-top:3px;background-color:<?=$freemin_color?>;width:10px;height:10px"></div><div style="margin-left:5px;float:left"><?=_KMS_ISP_HOSTING_MANAGE_RESOURCES_MIN?></div>*/?>
        <div style="clear:left"></div>
        <div style="float:left;margin-top:3px;background-color:<?=$freemax_color?>;width:10px;height:10px"></div><div style="margin-left:5px;float:left"><?=_KMS_ISP_HOSTING_MANAGE_RESOURCES_MAX?></div>
        <div style="clear:left"></div>
<? if ($_REQUEST['action']!="new_hosting") { ?>
        <div style="float:left;margin-top:3px;background-color:<?=$used_color?>;width:10px;height:10px"></div><div style="margin-left:5px;float:left"><?=_KMS_ISP_HOSTING_MANAGE_RESOURCES_USED?></div>
        <div style="clear:left"></div>
        <div style="float:left;margin-top:3px;background-color:<?=$extra_color?>;width:10px;height:10px"></div><div style="margin-left:5px;float:left"><?=_KMS_ISP_HOSTING_MANAGE_RESOURCES_OVER?></div>
        <div style="clear:left"></div>
<?} ?>
</td>

<td></td>
</tr>

<tr class="sep2">
<td></td>
<td>
	<table width="550"><tr>
		<td><center><div id="custom_quota"><div style='clear:left;padding-bottom:2px;'><?=_KMS_ISP_HOSTING_CUSTOM_QUOTA?></div><div id="quota"><?=$current_quota?></div><div id="quota_discount"></div></div><br><span style="color:#555"><?=_KMS_ISP_ALTA_DE_SERVEI?>: 0 &euro;</span></center></td>
		</tr>
	</table>
</td>
<td></td>
</tr>
<tr class="sep2">
<td></td>
<td width=500 style="padding:0px">
<input type="hidden" name="activate" id="activate" value=1>
<input type="hidden" name="type" id="type" value="ch">
<input type="hidden" name="hosting_plan" id="hosting_plan" value="<?=$client_plan?>">
<input type="hidden" name="new_max_space" id="new_max_space" value="<?=$hosting_log['max_space']?>">
<input type="hidden" name="new_max_transfer" id="new_max_transfer" value="<?=$hosting_log['max_transfer']?>">
<input type="hidden" name="max_space" id="max_space" value="<?=$hosting_log['max_space']?>">
<input type="hidden" name="max_transfer" id="max_transfer" value="<?=$hosting_log['max_transfer']?>">
<input type="hidden" name="max_mailboxes" id="max_mailboxes" value="<?=$hosting_log['max_mailboxes']?>">
<input type="hidden" name="max_vhosts" id="max_vhosts" value="<?=$hosting_log['max_vhosts']?>">
<input type="hidden" name="min_limit_space" id="min_limit_space" value="<?=$hosting_log['bottom_space']?>">
<input type="hidden" name="min_limit_transfer" id="min_limit_transfer" value="<?=$hosting_log['bottom_transfer']?>">
<input type="hidden" name="min_limit_mailboxes" id="min_limit_mailboxes" value="<?=$hosting_log['bottom_mailboxes']?>">
<input type="hidden" name="min_limit_vhosts" id="min_limit_vhosts" value="<?=$hosting_log['bottom_vhosts']?>">
<input type="hidden" name="max_limit_space" id="max_limit_space" value="<?=$hosting_log['top_space']?>">
<input type="hidden" name="max_limit_transfer" id="max_limit_transfer" value="<?=$hosting_log['top_transfer']?>">
<input type="hidden" name="max_limit_mailboxes" id="max_limit_mailboxes" value="<?=$hosting_log['top_mailboxes']?>">
<input type="hidden" name="max_limit_vhosts" id="max_limit_vhosts" value="<?=$hosting_log['top_vhosts']?>">
<input type="hidden" name="new_quota"  id="new_quota" value="">
<div id="conditions" style="display:none">
<div style="padding-left:35px;padding-bottom:4px;"><h3><?=_KMS_ISP_HOSTINGS_TERMS_TITLE?></h3></div>
<?=_KMS_ISP_HOSTINGS_TERMS?>
<center><br><br><input type="button" class="customButton" value="<?=_KMS_GL_CLOSE?>" onclick="closePopup()"></center>
</div>
<div style="float:left"><input type="checkbox" id="accept" name="accept" style="margin:0px;padding:0px;width:auto"></div>
<div style="float:left;padding-left:5px;padding-top:3px">
<?
$link="<a href=\"#\" onclick=\"openPopup('text',$('#conditions').html(),550,410)\">"._KMS_ECOM_CONTRACTS_CONDITIONS."</a>";

 if (!$new) {
 	if ($_SESSION['lang']=="ca") $condicions=str_replace("condicions del contracte",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT_CHANGES));
	else if ($_SESSION['lang']=="es") $condicions=str_replace("condiciones del contrato",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT_CHANGES));
	else if  ($_SESSION['lang']=="en") $condicions=str_replace("contract conditions",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT_CHANGES));
	else if ($_SESSION['lang']=="eu") $condicions=str_replace("condiciones del contrato",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT_CHANGES));
	echo $condicions;
  } else {
	if ($_SESSION['lang']=="ca") $condicions2=str_replace("condicions",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT));
	else if ($_SESSION['lang']=="es") $condicions2=str_replace("condiciones",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT));
	else if  ($_SESSION['lang']=="en") $condicions2=str_replace("terms and conditions",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT));
	else if ($_SESSION['lang']=="eu") $condicions2=str_replace("condiciones",$link,strip_tags(_KMS_ISP_HOSTING_ACCEPT));
	echo $condicions2;
  } 
?>
</div>
<br><br><br>
<input type="hidden" name="activate" value="1">
<input class="customButton highlight big" type="submit" onclick="return valida()" name="submit" value="<?=_KMS_GL_ACCEPT?>" style="cursor:pointer;cursor:hand;width:80px;text-align:center">
&nbsp;
<input class="customButton big" type="button" value="<?=_404_RTS?>" style="cursor:pointer;cursor:hand;width:100px;text-align:center" onclick="history.back()">
</form>
</td>
<td></td>
</tr>
</table>
<div id="debug" style="background-color:#fee"></div>
<script language="javascript">
timer=setTimeout("changeplan(\"<?=$client_plan?>\");",500);//default
timer=setTimeout("document.actiu=1",500);
<? if (!$new) { ?>timer2=setTimeout("setCurrentMaxs()",500);<? }?>

function setCurrentMaxs() {
	$('input#space').val(<?=$max_space?>);setSlide('limit_space',<?=$max_space?>);
	$('input#transfer').val(<?=$max_transfer?>);setSlide('limit_transfer',<?=$max_transfer?>);
	$('input#mailboxes').val(<?=$max_mailboxes?>);setSlide('limit_mailboxes',<?=$max_mailboxes?>);
	$('input#vhosts').val(<?=$max_vhosts?>);setSlide('limit_vhosts',<?=$max_vhosts?>);
}

$('input#mailboxes').val(<?=$max_mailboxes?>);
$(document).ready( function() { $('#plans_description').show(); $('#cloudselector').show() } );

</script>

<? } ?>
