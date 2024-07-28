<?
	//Open log 
	define("LOG_FILE", "logs/scart.log");
	$fp_log = fopen(LOG_FILE,"a");
	fwrite($fp_log,"[".date('Y-m-d H:i')."] transfer payment received\n");
	
	$total="<b>".$order['total']." &euro;</b>";
	$concept="<b>".str_pad($_SESSION['operation'],5,"0",STR_PAD_LEFT)."</b>";
	$ll['transfer_payment_text']=str_replace("{IMPORT}",$total,$ll['transfer_payment_text']);
	$ll['transfer_payment_text']=str_replace("{CONCEPTE}",$concept,$ll['transfer_payment_text']);
	echo $ll['transfer_payment_text'];

        $sel="select * from kms_cat_clients where id=".$order['customer'];
        $res=mysqli_query($dblink,$sel);
        $customer=mysqli_fetch_assoc($res);

        $from_name=$conf['commerce_name'];
        $from=$conf['commerce_email'];
        $to=trim($customer['email']);
        $subject=$ll['thanks_purchase'];

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: '.$from_name.' <'.$from.'>' . "\r\n";

        $body="<body style='background-color:#fff'>".$ll['shop_confirm_email_body'];
	$body=str_replace("@CUSTOMER_FULLNAME@",$customer['name'],$body);
	$body=str_replace("@ORDER_ID@",str_pad($order['id'],5,"0",STR_PAD_LEFT),$body);
	$body=str_replace("@ORDER_DATE@",date('d-m-Y'),$body);
	$body=str_replace("@COMMERCE_WEBSITE@","<a href='".$conf['site_url']."'>".str_replace("https://www.","",$conf['site_url'])."</a>",$body);
	$body=str_replace("@SIGNATURE@","<img src='".$conf['site_url'].$conf['logo']."' style='max-width:100px'><br>".$conf['commerce_name']."<br><a href='".$conf['site_url']."'>".$conf['site_url']."</a>",$body);
	$body=str_replace("@DELIVERY_DATE@","<b>".date('d-m-Y',strtotime('+15 days'))."</b><br><br>".$ll['transfer_payment_text'],$body);
        $body=str_replace("@PURCHASED_ITEMS@","<br>".add_shopping_cart($_SESSION['operation'],"email"),$body);
        $body="<span style='font-family:monospace;font-size:12px'>".$body."</span></body>";
        mail($to, $subject, $body, $headers, "-f {$from}");
        fwrite($fp_log,"[".date('Y-m-d H:i')."] confirmation email sent from {$from} to customer ".$to."\n");

	//notification mail to the administrator
	$subject=$ll['new_order'];
	$body="Comanda Num.: <b>".$order['id']."</b><br>Data: <b>".date('d-m-Y')."</b><br>Import: <b>".$order['total']." &euro;</b><br>Mètode de pagament: <b>Transferència</b><br>Data estimada de lliurament:<b>".date('d-m-Y',strtotime('+15 days'))."</b><br>Client: <b>".$customer['name']."</b><br>Email client: <b><a href='mailto:".$customer['email']."'>".$customer['email']."</a></b><br><br>".add_shopping_cart($_SESSION['operation'],"email")."<br><br>Podeu administrar aquesta comanda des de l'extranet.<br><br>".$conf['commerce_name'];
	$body="<span style='font-family:monospace;font-size:12px'>".$body."</span></body>";
	$to=$conf['commerce_email'];
//        $to="j.berenguer@intergrid.cat";
	mail($to, $subject, $body, $headers, "-f {$from}");
        fwrite($fp_log,"[".date('Y-m-d H:i')."] confirmation email sent to admin to ".$to."\n");

        $_SESSION['operation']=""; // empty cart


?>
