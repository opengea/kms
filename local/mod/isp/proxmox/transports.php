<?php

// Configuració
$pmg_server = 'https://mg01.intergridnetwork.net:8006';
$username = 'root@pam';
$password = 'SXHJK13GXhYaNEATapp2MVli';

// Function to log messages
function logMessage($message) {
    $logFile = 'transports.log'; 
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - " . $message . PHP_EOL, FILE_APPEND);
}

// Autenticació
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$pmg_server/api2/json/access/ticket");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['username' => $username, 'password' => $password]));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    logMessage("Curl error during authentication: $error_msg");
    die("Curl error during authentication: $error_msg");
}

$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Handle 401 Unauthorized error
if ($http_code == 401) {
    echo "Error 401: Unauthorized. Please check your credentials.\n";
    $response_data = json_decode($response, true);
    print_r($response_data);
    logMessage("HTTP error during authentication: Code $http_code, Response: $response");
    die("HTTP error during authentication: Code $http_code, Response: $response");
}

$data = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    logMessage("JSON decode error during authentication: " . json_last_error_msg());
    die("JSON decode error during authentication: " . json_last_error_msg());
}

$ticket = $data['data']['ticket'];
$csrf_prevention_token = $data['data']['CSRFPreventionToken'];
curl_close($ch);

echo "Successfully authenticated.\n";
logMessage("Successfully authenticated. Ticket: $ticket");

// Afegir Transport
$domain = 'opengea.cat';
$transport = 'smtp:[g1.intergridnetwork.net]';
$host="g1.intergridnetwork.net";
$protocol="smtp";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$pmg_server/api2/json/config/transport/".$domain);

/*
$put_data = json_encode([
    'host' => $host,
    'protocol' => $protocol
]);
*/
//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
//curl_setopt($ch, CURLOPT_POSTFIELDS, $put_data);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['domain' => $domain, 'host' => $host]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "CSRFPreventionToken: $csrf_prevention_token",
    "Cookie: PVEAuthCookie=$ticket"
]);





$response = curl_exec($ch);

if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    logMessage("Curl error during PUT request: $error_msg");
    die("Curl error during PUT request: $error_msg");
}

$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($http_code != 200) {
    logMessage("HTTP error during PUT request: Code $http_code, Response: $response");
    die("HTTP error during PUT request: Code $http_code, Response: $response");
}

$data = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    logMessage("JSON decode error during PUT request: " . json_last_error_msg());
    die("JSON decode error during PUT request: " . json_last_error_msg());
}

curl_close($ch);

// Log the response
logMessage("PUT request response: " . print_r($data, true));

echo "Response: ";
print_r($data);




?>

