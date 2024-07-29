<?php
define( 'HOST', 'https://gateway.autodns.com' );
define( 'XML_FILE', 'request.xml' );
$xml = implode( "", file(XML_FILE) );
header( 'Content-Type: text/xml' );
echo requestCurl( $xml );
function requestCurl( $data ) {
$ch = curl_init( HOST );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
if( !$data = curl_exec( $ch )) {
echo 'Curl execution error.', curl_error( $ch ) ."\n";
return FALSE;
}
curl_close( $ch );
return $data;
}
?>
