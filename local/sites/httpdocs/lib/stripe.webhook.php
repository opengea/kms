<?php
//Afegir webhook a stripe event checkout.session.completed apuntant a aquest fitxer

date_default_timezone_set('Europe/Brussels');
include "../config/setup.php";
include_once "../config/scart.php";
include_once "../lib/functions.php";
//Open log
define("LOG_FILE", "../logs/stripe.log");
$fp_log = fopen(LOG_FILE,"a");
fwrite($fp_log,"[".date('Y-m-d H:i')."] received webhook!\n");

//Error handling
error_reporting(E_ALL);
if ($conf['stripe_'.$conf['stripe_mode'].'_secret_key']=="") fwrite($fp_log,"[".date('Y-m-d H:i')."] cannot load setup.php!\n");
//echo $conf['stripe_'.$conf['stripe_mode'].'_secret_key'];exit;

//Stripe
require_once('stripe/vendor/autoload.php');
\Stripe\Stripe::setApiKey($conf['stripe_'.$conf['stripe_mode'].'_secret_key']);

// You can find your endpoint's secret in your webhook settings
$endpoint_secret = 'whsec_BizcMMNGc48eF5N2p0XMxoZyCiBKshLc';
$payload = @file_get_contents('php://input');
$event = null;

try {
    $event = \Stripe\Event::constructFrom(json_decode($payload, true));
} catch(\UnexpectedValueException $e) {
    // Invalid payload
    http_response_code(400);
    exit();
}

// Handle the checkout.session.completed event
if ($event->type == 'checkout.session.completed') {
  fwrite($fp_log,"[".date('Y-m-d H:i')."] Checkout session completed\n");

  $session = $event->data->object;

  // Fulfill the purchase...
  handle_checkout_session($session);
}

http_response_code(200);

function handle_checkout_session($payment) {
	global $conf,$fp_log,$dblink;

	$dump=print_r($payment,true);
	//preparing database update
	$d=array(
                "payment_date"=>date('Y-m-d H:i:s'),
                "payment_method"=>"stripe",
                "status"=>"paid",
                "payment_id"=>$payment['id'],
                "description"=>$payment['display_items'][0]->custom->name,
                "reference_id"=>$payment['client_reference_id'],
                "card_country"=>$payment['locale'],
                "currency"=>$payment['display_items'][0]->currency,
                "amount"=>$payment['display_items'][0]->amount/100,
                "payment_intent"=>$payment['payment_intent'],
                "full_response"=>$dump
	);

        //update donation status
	include "dbconnect.php";

    	$update="UPDATE kms_cat_comandes SET payment_date='".$d['payment_date']."',payment_method='".$d['payment_method']."',status='".$d['status']."',payment_id='".$d['payment_id']."',description='".$d['description']."',card_country='".$d['card_country']."',currency='".$d['currency']."',amount_paid='".$d['amount']."',payment_intent='".$d['payment_intent']."',full_response='".mysqli_real_escape_string($dblink,$d['full_response'])."' where id='".$d['reference_id']."'"; //transaction_id."'";

	$result=mysqli_query($dblink,$update);
//        fwrite($fp_log,"[".date('Y-m-d H:i')."]".$update."\n");

	//send email notification to customer
	$sel="select * from kms_cat_comandes where id=".$d['reference_id'];
	$res=mysqli_query($dblink,$sel);
	$order=mysqli_fetch_assoc($res);

	$sel="select * from kms_cat_clients where id=".$order['customer'];
	$res=mysqli_query($dblink,$sel);
        $customer=mysqli_fetch_assoc($res);

        include "../config/locale/".$customer['idioma'].".php";
//$ll,$dblink,$url_base,$url_base_lang,$scart;
	include "scart.functions.php";

	$from_name=$conf['commerce_name'];
	$from=$conf['commerce_email'];
	$to=trim($customer['email']);
	$subject=$ll['thanks_purchase'];

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'From: '.$from_name.' <'.$from.'>' . "\r\n";


	$body=$ll['shop_confirm_email_body'];
        $body="<body style='background-color:#fff'>".$ll['shop_confirm_email_body'];

        $total="<b>".$order['total']." &euro;</b>";
        $concept="<b>".str_pad($_SESSION['operation'],5,"0",STR_PAD_LEFT)."</b>";
        $ll['add_details']=str_replace("{IMPORT}",$total,$ll['add_details']);

	$body=str_replace("@CUSTOMER_FULLNAME@",$customer['name'],$body);
        $body=str_replace("@ORDER_ID@",str_pad($order['id'],5,"0",STR_PAD_LEFT),$body);
        $body=str_replace("@ORDER_DATE@",date('d-m-Y H:i'),$body);
        $body=str_replace("@COMMERCE_WEBSITE@","<a href='".$conf['site_url']."'>".str_replace("https://www.","",$conf['site_url'])."</a>",$body);
        $body=str_replace("@SIGNATURE@","<img src='".$conf['site_url'].$conf['logo']."' style='max-width:100px'><br>".$conf['commerce_name']."<br><a href='".$conf['site_url']."'>".$conf['site_url']."</a>",$body);
        $body=str_replace("@DELIVERY_DATE@","<b>".date('d-m-Y',strtotime('+15 days'))."</b><br><br>".$ll['add_details']."<br>",$body);
	$body=str_replace("@PURCHASED_ITEMS@","<br>".add_shopping_cart($d['reference_id'],"email"),$body);
        $body="<span style='font-family:monospace;font-size:12px'>".$body."</span></body>";

	mail($to, $subject, $body, $headers, "-f {$from}");

	fwrite($fp_log,"[".date('Y-m-d H:i')."] confirmation email sent to customer to ".$to."\n");

        //notification mail to the administrator
        $subject=$ll['new_order'];
        $body="Comanda Num.: <b>".$order['id']."</b><br>Data: <b>".date('d-m-Y')."</b><br>Import: <b>".$order['total']." &euro;</b><br>Mètode de pagament: <b>Targeta bancària</b><br>Data estimada de lliurament:<b>".date('d-m-Y',strtotime('+15 days'))."</b><br>Client: <b>".$customer['name']."</b><br>Email client: <b><a href='mailto:".$customer['email']."'>".$customer['email']."</a></b><br><br>".add_shopping_cart($d['reference_id'],"email")."<br><br>Podeu administrar aquesta comanda des de l'extranet.<br><br>".$conf['commerce_name'];
        $body="<span style='font-family:monospace;font-size:12px'>".$body."</span></body>";
	$to=$conf['commerce_email'];
//        $to="j.berenguer@intergrid.cat";
        mail($to, $subject, $body, $headers, "-f {$from}");
        fwrite($fp_log,"[".date('Y-m-d H:i')."] confirmation email sent to admin to ".$to."\n");

}


fclose($fp_log);

?>
