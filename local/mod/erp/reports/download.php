<?
function output_file($file, $name, $mime_type='')
{

/*
This function takes a path to a file to output ($file),
the filename that the browser will see ($name) and
the MIME type of the file ($mime_type, optional).

If you want to do something on download abort/finish,
register_shutdown_function('function_name');
*/
if(!is_readable($file)) die('File '.$file.' not found or inaccessible!');

$size = filesize($file);
$name = rawurldecode($name);

/* Figure out the MIME type (if not specified) */
$known_mime_types=array(
"pdf" => "application/pdf",
"txt" => "text/plain",
"html" => "text/html",
"htm" => "text/html",
"exe" => "application/octet-stream",
"zip" => "application/zip",
"doc" => "application/msword",
"xls" => "application/vnd.ms-excel",
"ppt" => "application/vnd.ms-powerpoint",
"gif" => "image/gif",
"png" => "image/png",
"jpeg"=> "image/jpg",
"jpg" => "image/jpg",
"php" => "text/plain"
);

if($mime_type==''){
	$file_extension = strtolower(substr(strrchr($file,"."),1));
	if(array_key_exists($file_extension, $known_mime_types)){
	$mime_type=$known_mime_types[$file_extension];
	} else {
	$mime_type="application/force-download";
	};
};

//@ob_end_clean(); //turn off output buffering to decrease cpu usage <----------------

// required for IE, otherwise Content-Disposition may be ignored
if(ini_get('zlib.output_compression')) ini_set('zlib.output_compression', 'Off');

/*
echo MP_BOUNDARY;flush();
echo "Content-Type: multipart/mixed; boundary='".MP_BOUNDARY."'\r\n";
echo "\r\n";
echo MP_BOUNDARY;flush();
echo "Content-Type: application/force-download\r\n";
echo "Content-Disposition: attachment; filename=foo.zip\r\n";
echo "\r\n";
*/


header ("Content-Type: multipart/mixed; boundary='".MP_BOUNDARY."'");
header ("Content-Type: application/force-download");
header ("Content-Disposition: attachment; filename=foo.zip");

readfile('/usr/local/kms/mod/erp/reports/report.css');
        echo MP_BOUNDARY.'--';
        flush();
        die();

/*
echo "Content-Type: text/html\r\n";
echo "\r\n";
echo 'The file will download in seconds ...';
echo MP_BOUNDARY;flush();
*/

/*
header('Content-Type: ' . $mime_type);
header('Content-Disposition: attachment; filename="'.$name.'"');
header("Content-Transfer-Encoding: binary");
header('Accept-Ranges: bytes');
*/
$header = "Content-Type: ".$mime_type."\r\n";
$header .= "Content-Disposition: attachment; filename='".$name."'\r\n";
$header .= "Content-Transfer-Encoding: binary\r\n";
//$header .= "Accept-Ranges: bytes\r\n";


/* The three lines below basically make the
download non-cacheable */
/*
header("Cache-control: private");
header('Pragma: private');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
*/
//echo "Cache-control: private\r\n";
//echo "Pragma: private\r\n";
//echo "Expires: Mon, 26 Jul 1997 05:00:00 GMT\r\n";


// multipart-download and download resuming support
if(isset($_SERVER['HTTP_RANGE']))
{
	list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
	list($range) = explode(",",$range,2);
	list($range, $range_end) = explode("-", $range);
	$range=intval($range);
	if(!$range_end) {
	$range_end=$size-1;
	} else {
	$range_end=intval($range_end);
	}
	
	$new_length = $range_end-$range+1;
	/*header("HTTP/1.1 206 Partial Content");
	header("Content-Length: $new_length");
	header("Content-Range: bytes $range-$range_end/$size");
	*/
	$header .= "HTTP/1.1 206 Partial Content\r\n";
	$header .= "Content-Length: {$new_length}\r\n";
	$header .= "Content-Range: bytes {$range}-{$range_end}/{$size}\r\n";
	$header .= "\r\n";
} else {
	$new_length=$size;
	//	header("Content-Length: ".$size);
	$header .= "Content-Length: ".$size."\r\n";
	$header .= "\r\n";
}
	
/* output the file itself */
$chunksize = 1*(1024*1024); //you may want to change this
$bytes_send = 0;
if ($file = fopen($file, 'r'))
{
	if(isset($_SERVER['HTTP_RANGE']))
	fseek($file, $range);

	while(!feof($file) &&
	(!connection_aborted()) &&
	($bytes_send<$new_length)
	)
	{
	$buffer = fread($file, $chunksize);
	print($header.$buffer); //echo($header.$buffer); // is also possible
	echo MP_BOUNDARY."--";flush();
	$bytes_send += strlen($buffer);
	}
	fclose($file);
} else {
	echo "Content-Type: text/html\r\n";
	echo "\r\n";
	echo 'Can\'t open file '.$name;
	echo MP_BOUNDARY.'--';
	flush();
	die();
}

/*echo "Content-Type: text/html\r\n";
echo "\r\n";
echo 'no ha baixat?'.$name;
echo MP_BOUNDARY.'--';
flush();
*/
die();
} 
?>

