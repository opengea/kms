<?
echo $ll['stripe_redirect'];

require_once('lib/stripe/vendor/autoload.php');
// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
$client['idioma']="es";
\Stripe\Stripe::setApiKey($conf['stripe_'.$conf['stripe_mode'].'_secret_key']);
$session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card'],
  'customer_email' => $client['email'],
  'locale'=>$client['idioma'],
  'client_reference_id'=>$order['id'],
  'line_items' => [[
    'name' => 'MARBOT EDICIONES SL',
    'description' => 'Pedido de '.$client['name'],
    'images' => ['https://www.marbotediciones.com/img/marbot-ediciones.gif'],
    'amount' => $order['total']*100,
    'currency' => 'eur',
    'quantity' => 1,
  ]],
  'success_url' => $url_base_lang."/shopping_cart/success?session_id={CHECKOUT_SESSION_ID}",
  'cancel_url' => $url_base_lang."/shopping_cart/cancel"
]);

?>
<script src="https://js.stripe.com/v3/"></script>
<script>
var stripe = Stripe('<?=$conf['stripe_'.$conf['stripe_mode'].'_public_key']?>');
stripe.redirectToCheckout({
  sessionId: '<?=$session->id?>'
}).then(function (result) {
  // If `redirectToCheckout` fails due to a browser or network
  // error, display the localized error message to your customer
  // using `result.error.message`.
});
</script>

