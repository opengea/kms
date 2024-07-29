<?
function translate($s,$d,$q) {

// Basic request parameters:
// s = source language (en, es..)
// d = destination language
// q = Text to be translated


$lang_pair = urlencode($s.'|'.$d);

// Google's API translator URL
$url = "http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q=".$q."&langpair=".$lang_pair;
 
// Make sure to set CURLOPT_REFERER because Google doesn't like if you leave the referrer out
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, "http://www.yoursite.com/translate.php");
$body = curl_exec($ch);
curl_close($ch);
 
$json = json_decode($body, true);


return $json['responseData']['translatedText'];

}

?>
