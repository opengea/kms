<?
//getWeb("");
function getWeb($url) {

	if (ereg("^http://", $url)) {
		$url = substr($url, (strpos ($url, "http://") + 7));
//		echo $url."\n";

	}

	$host = substr($url, 0, strpos ($url, "/"));
	$relative_path = substr($url,strpos ($url, "/"));

	$fp = fsockopen($host,80);
	fputs($fp, "GET ".$relative_path." HTTP/1.1\n");
	fputs($fp, "Host: $host\n");
	fputs($fp, "User-Agent: Intergrid\n");
	fputs($fp, "Connection: close\n\n");
	
	$result = "";
	$buf = "";
	while (!feof($fp)){
		$buf = fgets($fp,128);
		if (ereg("^<html", $buf) || ereg("^<HTML", $buf) || ereg("<!DOCTYPE HTML PUBLIC",$buf)) {
			$result = $buf;
			while (!feof($fp)){
				$string = fgets($fp,128);
				if (ereg("^</html>", $string) || ereg("^</HTML>", $string)) {
					$result .= $string;
					break;
				}else {
					$result .= $string;
				}
			}
			break;
		}
	}
	fclose($fp);
//	echo $result;
	return $result;
	
}

?>
