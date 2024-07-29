#!/usr/bin/php -q
<?

// aquest script renova els dominis, no fa factures ni toca contractes

function getlang($const,$lang,$dblink) {
        $select="select ".$lang." from kms_sys_lang where constant='{$const}'";
        $tmp_res=mysqli_query($dblink,$select);
        $txt=mysqli_fetch_array($tmp_res);
        return $txt[0];
}

//include "/usr/local/kms/lib/ssh2_exec.php";
include '/usr/local/kms/lib/mail/email.class.php';


// RENEW DOMAIN NAMES ----------------
echo "Auto domain name renewals for ".date('d-m-Y')."...\n";
include "/usr/local/kms/lib/dbi/db_localhost_connect.php";
$select="select * from kms_isp_domains WHERE auto_renew=1 and expiration_date<=NOW()";
$result=mysqli_query($link,$select);
if (!$result) die(mysqli_error($result).$select);
$now=date('Y-m-d');
$n=0;
$msg="";
while ($domain=mysqli_fetch_array($result)) {
	
	$select="select * from kms_erp_contracts where id=".$domain['sr_contract'];
	$contract_res=mysqli_query($link,$select);
	$contract=mysqli_fetch_array($contract_res);
	if ($contract['status']=="active"&&$contract['auto_renov']==1) {
		if ($contract['billing_period']=="") $contract['billing_period']="1Y";
		$add_time="+".str_replace("Y"," year",$contract['billing_period']);
		$newexpire=date('Y-m-d',strtotime($add_time,strtotime($domain['expiration_date'])));
		$update="update kms_isp_domains SET expiration_date='".$newexpire."' WHERE name='".$domain['name']."'";
		$msg.=$domain['name']." ".$domain['expiration_date']." => ".$newexpire."\n";//echo $update."\n";
		$r=mysqli_query($link,$update);
		include "/usr/local/kms/lib/dbi/db_master_connect.php";
		$r=mysqli_query($link,$update); if  (!$r) echo "mysql master error:".$update."\n";
		include "/usr/local/kms/lib/dbi/db_localhost_connect.php";
		$r=mysqli_query($link,$update); if  (!$r) echo "mysql tartarus error:".$update."\n";	
		$n++;
	}


}
if ($n==0) $msg= "nothing to do.\n\n"; else echo $msg.="\n$n domains renewed.\n\n";
echo $msg;
if ($n!=0) {
	$email = new Email("kms@intergrid.cat","sistemes@intergrid.cat", "[KMS ISP] Notify: {$n} domain names has been renewed", $msg, 0);
	$goodemail = $email->send();
}

// --------- Domain expiration alerts ----------------
$select="select * from kms_isp_domains WHERE auto_renew=0 and DATE_SUB(expiration_date,INTERVAL 10 DAY)=NOW()";
$result=mysqli_query($link,$select);
$n=0;
while ($domain=mysqli_fetch_array($result)) {
	$select="select * from kms_erp_contracts where id=".$domain['sr_contract'];
        $contract_res=mysqli_query($link,$select);
        $contract=mysqli_fetch_array($contract_res);
	$select="select * from kms_isp_clients where sr_client=".$contract['sr_client'];
	$client_res=mysqli_query($link,$select);
	$client=mysqli_fetch_array($client_res);

	$subject=getlang("_KMS_ISP_DOMAINS_NOTIFY_EXPIRATION_SUBJECT",$contract['language'],$link)." ".strtoupper($domain['name']);
	
	$body=getlang("_KMS_MAIL_SENDCONFIG_SALUTATION",$contract['language'],$link)."<br><br>".str_replace("[DOMAIN]",$domain['name'],str_replace("[DATE]",$domain['expiration_date'],getlang("_KMS_ISP_DOMAINS_NOTIFY_EXPIRATION_BODY",$contract['language'],$link)))."<br><br>".getlang("_KMS_ISP_EMAIL_SIGNATURE",$contract['language'],$link);

//	$email = new Email("kms@intergrid.cat", $client['email'], $subject, $body, 0);
	$email = new Email("kms@intergrid.cat","j.berenguer@intergrid.cat", $subject, $body, 0);
        $goodemail = $email->send();
        $n++;	

}
if ($n>0) echo $n." expirations notified.\n\n";

// ---------- SET Expirations -------------------
$select="SELECT * FROM kms_isp_domains WHERE (status='ACTIVE' OR status='LOCK') AND expiration_date<='".date('Y-m-d')."'"; //DATE_ADD(expiration_date,INTERVAL 10 DAY)=NOW()";
$result=mysqli_query($link,$select);
$n=0;
$msg="";
while ($domain=mysqli_fetch_array($result)) {
                $update="update kms_isp_domains SET status='EXPIRED' WHERE name='".$domain['name']."'";
                mysqli_query($dblink_local,$update);
		mysqli_query($dblink_cp,$update);
		$msg.=$domain['name']." (".$domain['expiration_date'].") AUTO RENEW:".$domain['auto_renew']."\n";
                $n++;
        }


        $subject="[KMS ISP] Notify: {$n} domain names has been expired";

echo $subject."\n".$msg;
if ($n!=0) {
        $email = new Email("kms@intergrid.cat","sistemes@intergrid.cat", $subject, $msg, 0);
        $goodemail = $email->send();
}

// --------- SET STATUS ACTIVE ------------------
$select="SELECT * FROM kms_isp_domains WHERE status='EXPIRED' AND expiration_date>'".date('Y-m-d')."'";
$result=mysqli_query($link,$select);
$n=0;
$msg="";
while ($domain=mysqli_fetch_array($result)) {
                $update="update kms_isp_domains SET status='ACTIVE' WHERE name='".$domain['name']."'";
                mysqli_query($dblink_local,$update);
                mysqli_query($dblink_cp,$update);
                $msg.=$domain['name']." set back to ACTIVE (".$domain['expiration_date'].")\n";
                $n++;
        }


        $subject="[KMS ISP] Notify: {$n} domain names has been set to active";

echo $subject."\n".$msg;
if ($n!=0) {
        $email = new Email("kms@intergrid.cat","sistemes@intergrid.cat", $subject, $msg, 0);
        $goodemail = $email->send();
}


// ---------- Deletions -------------------
//$delete_date=date('Y-m-d',strtotime("-30 days",strtotime(date('Y-m-d'))));
$delete_date=date('Y-m-d',strtotime("-1 days",strtotime(date('Y-m-d'))));
$select="SELECT * FROM kms_isp_domains WHERE auto_renew=0 AND status='EXPIRED' AND expiration_date<='".$delete_date."'";
$result=mysqli_query($link,$select);
$n=0;
$msg="";
while ($domain=mysqli_fetch_array($result)) {
                $delete="delete from kms_isp_domains WHERE name='".$domain['name']."'";
                mysqli_query($dblink_local,$delete);
		mysqli_query($dblink_cp,$delete);
                $msg.=$domain['name']." (".$domain['expiration_date'].")\n";
                $n++;
        }


        $subject="[KMS ISP] Notify: {$n} domain names has been deleted";

echo $subject."\n".$msg;
if ($n!=0) {
        $email = new Email("kms@intergrid.cat","sistemes@intergrid.cat", $subject, $msg, 0);
        $goodemail = $email->send();
}


?>
