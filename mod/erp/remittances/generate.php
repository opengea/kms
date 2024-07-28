<?php
session_start();
setlocale(LC_CTYPE,"es_ES");

if (!$_SESSION['user_logged']) {
echo "Session expired or user not logged. Please, autenticate first";exit;
header ('location: http://intranet.intergrid.cat');
}
// read domain and subdomain, open intergrid kms
include "/usr/local/kms/lib/dbi/db_localhost_connect.php";
require_once ('/usr/share/kms/lib/reports/download.php');
if (($_SESSION['user_logged']!= true)||($this->current_subdomain!="intranet")) die ("Access denied. Session invalid.");
if ($_GET['mod']!="erp_remittances") die('invalid call');
// -----------------  Get remmitance and collect data ---------------------------
$result = mysqli_query($dblink_local,"SELECT * FROM kms_erp_remittances WHERE id='{$_GET['id']}'");
if (!$result) {echo "error".mysqli_error();exit;}
$remittance = mysqli_fetch_array($result);
if ($remittance['file']!="") {
	//ja esta creada
	$select="SELECT * FROM kms_erp_invoices WHERE sr_remittance=".$remittance['id']." order by sr_client";
} else {
	//$select="SELECT * FROM kms_erp_invoices WHERE payment_date>='".$remittance['from_date']."' AND payment_date<='".$remittance['to_date']."' AND status='pendent' AND (payment_method='3' OR payment_method='9' OR payment_method='4' OR payment_method='5') AND total>0 AND sr_remittance=0 order by sr_client";
	$select="SELECT * FROM kms_erp_invoices WHERE payment_date>='".$remittance['from_date']."' AND payment_date<='".$remittance['to_date']."' AND (status='pendent' or status='impagada') AND (payment_method='3' OR payment_method='9' OR payment_method='4' OR payment_method='5') AND total>0 AND sr_remittance=0 order by sr_client";
}
$result = mysqli_query($dblink_local,$select);

$current_client="";
$remesa=array();
$n=0;$total=0;
while ($invoice = mysqli_fetch_array($result)) {
		        $invoice['total']+=$invoice['bank_charges'];

        if ($current_client!=$invoice['sr_client']) {
		$remesa[$current_client]['description']=substr($remesa[$current_client]['description'],0,strlen($remesa[$current_client]['description'])-1);
                if ($remesa[$current_client]['total']>0) $n++;
                $current_client=$invoice['sr_client'];
                $remesa[$current_client]=array();
                $sel = "SELECT * from kms_ent_contacts INNER JOIN kms_ent_clients ON kms_ent_clients.sr_client='".$invoice['sr_client']."' where kms_ent_contacts.id=".$invoice['sr_client'];
                $res = mysqli_query($dblink_local,$sel);
                if (!$res) {echo mysqli_error();exit;}
                $client = mysqli_fetch_array($res);
//echo "-".$client['name']."-<br>";
                $remesa[$current_client]['client_name']=utf8_decode($client['name']);//$client['name'];//utf8_decode($client['name']);
	        $client['bank_accountNumber']=str_replace(" ","",$client['bank_accountNumber']);
	        $client['bank_accountNumber']=str_replace("-","",$client['bank_accountNumber']);
	        if (strlen($client['bank_accountNumber'])>20) $client['bank_accountNumber']=substr($client['bank_accountNumber'],4); //skip 4 digits of IBAN
	        $remesa[$current_client]['bank_accountNumber']=$client['bank_accountNumber'];
        }
        $remesa[$current_client]['total']+=$invoice['total'];
        $remesa[$current_client]['description'].=$invoice['id'].",";
	$total+=$invoice['total'];
}
$remesa[$current_client]['description']=substr($remesa[$current_client]['description'],0,strlen($remesa[$current_client]['description'])-1);
if ($remesa[$current_client]['total']>0) $n++;
if (!isset($_POST['generate'])) { 
//------------------PREVIEW --------------------
//echo $select;
echo "<div style=\"background-color:#fff;padding:0px\"><center><div style='width:auto;text-align:left;background-color:#fff;padding:0px 20px 20px 20px'>";
echo "<h1>Generaci&oacute; de remesa</h1>";
echo "Generaci&oacute; de remesa de per&iacute;ode <b>".date('d-m-Y',strtotime($remittance['from_date']))."</b> a <b>".date('d-m-Y',strtotime($remittance['to_date']))."</b><br><br>";
if (!$result) {echo mysqli_error();exit;}
echo "<table cellpadding=3 cellspacing=0 border=0 width=750>";
echo "<tr style='background-color:#ddd;font-weight:bold'><td>Concepte (Factures)</td><td>Client</td><td align='right'>Import</td><td>Compte</td></tr>";
foreach ($remesa as $sr_client=>$r) {
	if ($r['total']>0) {

		echo "<tr><td width=100>".$r['description']."</td><td>".htmlentities(utf8_encode($r['client_name']))."</td><td align=right>".$r['total']." &euro;</td><td>".$r['bank_accountNumber']."</td></tr>";
	}
}
echo "<tr style='background-color:#eef'><td></td><td><b>Total (".$n." rebuts)</b></td><td align=right><b>".$total." &euro;</b></td><td></td></tr>";
echo "</table>";

?>
<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" target="_self" lang="<?=$client_data['language']?>">
<input type="hidden" name="generate">
<br>
<?
if ($remittance['file']!="") {
 echo('Aquesta remesa ja ha estat emesa anteriorment.<br>Per consultar el llistat de rebuts fes clic sobre del fitxer de la remesa.<br>');
} else {
?><input type="submit" class="button" value="Generar"><?
}?>
</form>
<?

echo "</div></center></div>";


} else {
//------------------GENERATE------------------------

function formatN($str,$len) {
	// Number
        $dif=strlen($str)-$len;
        if ($dif==0) return $str;
        else if ($dif>0) return substr($str,0,$len);
        else return str_repeat("0",$dif*-1).$str;
}

function formatM($str,$len) {
	// Money
	$str=floatval($str);
	$str=str_replace(".","",money_format("%.2n",$str));
        $dif=strlen($str)-$len;
        if ($dif==0) return $str;
        else if ($dif>0) return substr($str,0,$len);
        else return str_repeat("0",$dif*-1).$str;
}



function formatT($str,$len) {
	// Text
	$dif=strlen($str)-$len;
	if ($dif==0) return $str;
	else if ($dif>0) return substr($str,0,$len);
	else return $str.str_repeat(" ",$dif*-1);
}

function remove_accents($string) {
    $string = strtr($string,
       "\xA1\xAA\xBA\xBF\xC0\xC1\xC2\xC3\xC5\xC7
        \xC8\xC9\xCA\xCB\xCC\xCD\xCE\xCF\xD0\xD1
        \xD2\xD3\xD4\xD5\xD8\xD9\xDA\xDB\xDD\xE0
        \xE1\xE2\xE3\xE5\xE7\xE8\xE9\xEA\xEB\xEC
        \xED\xEE\xEF\xF0\xF1\xF2\xF3\xF4\xF5\xF8
        \xF9\xFA\xFB\xFD\xFF",
        "!ao?AAAAAC
        EEEEIIIIDN
        OOOOOUUUYa
        aaaaceeeei
        iiidnooooo
        uuuyy");   
    $string = strtr($string, array("\xC4"=>"Ae", "\xC6"=>"AE", "\xD6"=>"Oe", "\xDC"=>"Ue", "\xDE"=>"TH", "\xDF"=>"ss", "\xE4"=>"ae", "\xE6"=>"ae", "\xF6"=>"oe", "\xFC"=>"ue", "\xFE"=>"th"));
    return($string);
}

$out="";
//$result = mysqli_query($dblink_local,"SELECT * FROM kms_erp_remittances WHERE id='{$_GET['id']}'");
//if (!$result) {echo mysqli_error();exit;}
//$remittance = mysqli_fetch_array($result);

// capcalera presentador
$select="SELECT * FROM kms_ent_contacts WHERE id=1";
$result = mysqli_query($dblink_local,$select);
$presentador=mysqli_fetch_array($result);
$select="SELECT * FROM kms_ent_clients WHERE sr_client=1";
$result = mysqli_query($dblink_local,$select);
$pclient=mysqli_fetch_array($result);
$pclient['cif']=str_replace("ES","",$pclient['cif']);
$pclient['bank_accountNumber']=str_replace(" ","",$pclient['bank_accountNumber']);
$pclient['bank_accountNumber']=str_replace("-","",$pclient['bank_accountNumber']);
if (strlen($pclient['bank_accountNumber'])>20) $pclient['bank_accountNumber']=substr($pclient['bank_accountNumber'],4); //skip 4 digits of IBAN

$out.="5180".formatN($pclient['cif'],9)."000".date('dmy').str_repeat(" ",6).formatT(remove_accents($presentador['shortname']),40).str_repeat(" ",20)."21003264".str_repeat(" ",12).str_repeat(" ",40).str_repeat(" ",14)."\n";
$out.="5380".formatN($pclient['cif'],9)."000".date('dmy').date('dmy',strtotime($remittance['billing_date'])).formatT(remove_accents($presentador['shortname']),40).$pclient['bank_accountNumber'].str_repeat(" ",8)."01".str_repeat(" ",10).str_repeat(" ",40).str_repeat(" ",14)."\n";

// bucle 
$n=1;
foreach ($remesa as $sr_client=>$r) {
        if ($r['total']>0) {

	$opc16=date('dmy').formatN($n,10);
	$concepte40=formatT("R-".$remittance['id']." ".$r['description']." ".money_format("%.2n",$r['total']),40);
        $out.="5680".formatN($pclient['cif'],9)."000".formatN($sr_client,12).formatT(remove_accents($r['client_name']),40).$r['bank_accountNumber'].formatM($r['total'],10).$opc16.$concepte40.str_repeat(" ",8)."\n";
	$n++;
	}
}
$n--;
// Total ordenant
$out.="5880".formatN($pclient['cif'],9)."000".str_repeat(" ",12).str_repeat(" ",40).str_repeat(" ",20).formatM($total,10).str_repeat(" ",6).formatN($n,10).formatN($n+2,10).str_repeat(" ",20).str_repeat(" ",18)."\n";
// Total general
$out.="5980".formatN($pclient['cif'],9)."000".str_repeat(" ",12).str_repeat(" ",40).formatN(1,4).str_repeat(" ",16).formatM($total,10).str_repeat(" ",6).formatN($n,10).formatN($n+4,10).str_repeat(" ",20).str_repeat(" ",18);

//echo "<pre>$out</pre>";

// save file
  $file="/var/www/vhosts/intergrid.cat/subdomains/data/httpdocs/files/erp/remittances/remesa".$remittance['id'].".txt";
  $fp = fopen($file, "w");
  if ($fp) {fwrite($fp, $out); echo "<br><br><br><br><br><br>fitxer generat."; } else die ('error writing '.$file);
  fclose($fp);

// update remittance (db)
$update = "UPDATE kms_erp_remittances SET file='remesa{$remittance['id']}.txt',generated_date='".date('Y-m-d H:i:s')."',status='generat',records={$n},import='{$total}' WHERE id={$remittance['id']}";
$result = mysqli_query($dblink_local,$update); 

// update status of invoices

$update="UPDATE kms_erp_invoices SET status='cobrat',sr_remittance='".$remittance['id']."',paid_on_date='".date('Y-m-d')."' WHERE payment_date>='".$remittance['from_date']."' AND payment_date<='".$remittance['to_date']."' AND (status='pendent' or status='impagada') AND (payment_method='3' OR payment_method='9' OR payment_method='4' OR payment_method='5') and total>0 AND sr_remittance=0";
$result = mysqli_query($dblink_local,$update);
//update isp_invoices
include "/usr/local/kms/lib/dbi/kms_erp_dbconnect.php";
$update="UPDATE kms_isp_invoices SET status='cobrat',sr_remittance='".$remittance['id']."',paid_on_date='".date('Y-m-d')."' WHERE payment_date>='".$remittance['from_date']."' AND payment_date<='".$remittance['to_date']."' AND (status='pendent' or status='impagada') AND (payment_method='3' OR payment_method='9' OR payment_method='4' OR payment_method='5') and total>0 AND sr_remittance=0";
$result = mysqli_query($dblink_local,$update);
include "/usr/local/kms/lib/dbi/db_master_connect.php";
$update="UPDATE kms_isp_invoices SET status='cobrat',sr_remittance='".$remittance['id']."',paid_on_date='".date('Y-m-d')."' WHERE payment_date>='".$remittance['from_date']."' AND payment_date<='".$remittance['to_date']."' AND (status='pendent' or status='impagada') AND (payment_method='3' OR payment_method='9' OR payment_method='4' OR payment_method='5') and total>0 AND sr_remittance=0";
$result = mysqli_query($dblink_local,$update);

} ?>
