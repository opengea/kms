<?
function strtoupper_accents($str) {
        $u=urlencode($str);
        $str=urldecode(str_replace("%E2%80%99","'",$u));
        $encoding=mb_detect_encoding($str);
        if ($encoding=="UTF-8") {
                 $str_x=htmlentities(utf8_decode($str));
                 if ($str_x=="") $str_x=htmlentities($str);
                 $str=$str_x;
        }
        $str=strtoupper($str);
        $pattern = '/&([A-Z])(UML|ACUTE|CIRC|TILDE|RING|ELIG|GRAVE|SLASH|HORN|CEDIL|TH|NBSP);/e';
        $replace = "'&'.'\\1'.strtolower('\\2').';'"; //convert the important bit back to lower
        $return = preg_replace($pattern,$replace,$str);
        $return = str_replace("&ORDM;","&ordm;",$return);
        $return = str_replace("&LT;","<",$return);
        $return = str_replace("&GT;",">",$return);
        $return = str_replace("&AMP;","&",$return);
        $return = str_replace("&EURO;","&euro;",$return);
        $return = str_replace("&POUND;","&pound;",$return);
        $return = str_replace("&NBSP;","&nbsp;",$return);
        $return = str_replace("&MIDDOT;","&middot;",$return);
        return $return;
}

function alert_accents($str) {
	return rawurlencode(html_entity_decode($str));
	//cal fer alert(unescape(X))
}

function bytes($data) {
            if ($data < 1024) {
                return $data .' B';
            } elseif ($data < 1048576) {
                return round($data / 1024, 2) .' KB';
            } elseif ($data < 1073741824) {
                return round($data / 1048576, 2) . ' MB';
            } elseif ($data < 1099511627776) {
                return round($data / 1073741824, 2) . ' GB';
            } elseif ($data < 1125899906842624) {
                return round($data / 1099511627776, 2) .' TB';
            } elseif ($data < 1152921504606846976) {
                return round($data / 1125899906842624, 2) .' PB';
            } elseif ($data < 1180591620717411303424) {
                return round($data / 1152921504606846976, 2) .' EB';
            } elseif ($data < 1208925819614629174706176) {
                return round($data / 1180591620717411303424, 2) .' ZB';
            } else {
                return round($data / 1208925819614629174706176, 2) .' YB';
            }
}

function shorten($s,$limit) {
	$post_last_space=strrpos(substr($s,0,$limit)," ");
	$s=substr($s,0,$post_last_space);
	return $s;
}

function urlize ($s,$nonspace=1) {
	$s=trim($s);
	$back=$s;
	$s=str_replace("<br>","-",$s);
	$s=str_replace("<BR>","-",$s);
	$s=str_replace("&euro;","-",$s);
	$encoding=mb_detect_encoding($s);
	if ($encoding=="UTF-8") $s=htmlentities(utf8_decode($s));
	if ($s=="") $s=htmlentities($back);
	$s=strip_tags($s);
	// convertir accents a -
	$trans_tbl = get_html_translation_table(HTML_ENTITIES);
	if ($nonspace)  $s=str_replace(" ","-",$s);
	$s=str_replace("'","-",$s);
	$s=str_replace("'","-",$s);
	$s=str_replace("[","-",$s);
	$s=str_replace("]","-",$s);
	$s=str_replace(",","-",$s);
	$s=str_replace("%","-",$s);
	$s=str_replace("/","-",$s);
	$s=str_replace("(","-",$s);
	$s=str_replace(")","-",$s);
	$s=str_replace("+","-",$s);
	$s=str_replace(">","-",$s);
	$s=str_replace("<","-",$s);
	$s=str_replace("#","-",$s);
	$s=str_replace("·","-",$s);
	$s=str_replace("!","-",$s);
	$s=str_replace("_","-",$s);
	$s=str_replace("--","-",$s);
	//html replace accents
	$s=str_replace("&middot;","-",$s);
	$s=str_replace("&aacute;","a",$s);
	$s=str_replace("&eacute;","e",$s);
	$s=str_replace("&iacute;","i",$s);
	$s=str_replace("&oacute;","o",$s);
	$s=str_replace("&uacute;","u",$s);
	$s=str_replace("&Aacute;","A",$s);
	$s=str_replace("&Eacute;","E",$s);
	$s=str_replace("&Iacute;","I",$s);
	$s=str_replace("&Oacute;","O",$s);
	$s=str_replace("&Uacute;","u",$s);
	$s=str_replace("&agrave;","a",$s);
	$s=str_replace("&egrave;","e",$s);
	$s=str_replace("&igrave;","i",$s);
	$s=str_replace("&ograve;","o",$s);
	$s=str_replace("&ugrave;","u",$s);
	$s=str_replace("&Agrave;","A",$s);
	$s=str_replace("&Egrave;","E",$s);
	$s=str_replace("&Igrave;","I",$s);
	$s=str_replace("&Ograve;","O",$s);
	$s=str_replace("&Ugrave;","U",$s);
	$s=str_replace("&iuml;","i",$s);
	$s=str_replace("&uuml;","u",$s);
	$s=str_replace("&ntilde;","n",$s);
	//encoded
	$s=urlencode($s);
	
	$s=str_replace("%26Ntilde%3B","-",$s);
	$s=str_replace("%26iexcl%3B","-",$s);
	$s=str_replace("%26ordm%3B","-",$s);
	$s=str_replace("%26amp%3B","-",$s); // NO & allowed
	$s=str_replace("%26ldquo%3B","-",$s);
	$s=str_replace("%26lsquo%3B","-",$s); //cometes
	$s=str_replace("%26rsquo%3B","-",$s); //cometes
	$s=str_replace("%26rdquo%3B","-",$s);
	$s=str_replace("%26ccedil%3B","-",$s); //ç
	$s=str_replace("%26ouml%3B","o",$s);
	$s=str_replace("%26iquest%3B","-",$s); // ¿
//	if ($_SERVER['REMOTE_ADDR']=='81.0.57.125') return "---------------->".$s;
		
	$s=str_replace("%AA","-",$s);
	$s=str_replace("%AB","-",$s);
	$s=str_replace("%BB","-",$s);
	$s=str_replace("%BF","-",$s);
	$s=str_replace("%B7","-",$s); //middot
	$s=str_replace("%C7","C",$s);
	$s=str_replace("%E7","c",$s);
	//$s=str_replace("%D1","N",$s);
	//$s=str_replace("%F1","n",$s);
	$s=str_replace("%DD","Y",$s);
	$s=str_replace("%FD","y",$s);
	$s=str_replace("%FF","y",$s);
	$s=str_replace("%22","-",$s);
	$s=str_replace("%92","-",$s);
	$s=str_replace("%93","-",$s);
	$s=str_replace("%94","-",$s);
	$s=str_replace("%3F","-",$s);
	$s=str_replace("--","-",$s);
	//$s=strtolower(html_entity_decode(urldecode($s)));
	$s=strtolower(urldecode($s));
        $s=str_replace("&","-",$s);
	// test non european alphabets
	$test=str_replace("-","",$s);
	if ($test=="") $s=$back;
	return $s;
}
	
function desurlize ($s,$nonslash) {
$s=urlencode($s);
$s=str_replace("%C3%9F","%",$s); // Beta
$s=str_replace("%C3%BA","%",$s);
$s=str_replace("%C3%A9","%",$s);
$s=str_replace("%C3%B2","%",$s);
$s=str_replace("%C3%B3","%",$s);
$s=str_replace("%C2%B7","%",$s); //middot
$s=str_replace("[","%",$s);
$s=str_replace("]","%",$s);
$s=str_replace("%3A","%",$s);
$s=str_replace("%C2%93","%",$s);
$s=str_replace("%C2%94","%",$s);
$s=str_replace("%C3%AF","%",$s);
$s=str_replace("%C3%A7","%",$s);
$s=str_replace("%C2%92","%",$s);
$s=str_replace("%C3%A8","%",$s);
$s=str_replace("%28","%",$s);
$s=str_replace("%29","%",$s);
$s=str_replace("%C3%A1","%",$s);
$s=str_replace("%C3%A0","%",$s);
$s=str_replace("%C2%BA","%",$s);
$s=str_replace("%C2%AB","%",$s);
$s=str_replace("%C2%BB","%",$s);
$s=str_replace("%C3%BC","u",$s);
$s=str_replace("%C3%8D","I",$s);
$s=str_replace("%C3%88","E",$s);
$s=str_replace("%E2%80%99","%",$s);
$s=urldecode($s);
$s=str_replace("'","%",$s);
if ($nonslash!=1) $s=str_replace("-","%",$s);
$s=str_replace("ò","%",$s);
$s=str_replace("ó","%",$s);
$s=str_replace("è","%",$s);
$s=str_replace("é","%",$s);
$s=str_replace("í","%",$s);
$s=str_replace("?","%",$s);
$s=str_replace("| ","%",$s);
$s=str_replace("~@","%",$s);// A obert
$s=str_replace("~H","%",$s); // Eobert

$s=str_replace("~M","%",$s);// I tancat
$s=str_replace("~S","%",$s); //O tancat
$s=str_replace("~I","%",$s);// E tancat
$s=str_replace("~A","%",$s); //A tancat
$s=str_replace("ñ","%",$s);
$s=str_replace("~Q","%",$s); // enya majusc
//$s=str_replace("%C3%BA",$s);
//echo $s;
return $s;
}

function cleanstr($s) {
$s=urlencode($s);
$s=str_replace("%96","-",$s);
$s=str_replace("%92","'",$s);
$s=str_replace("%60","'",$s);
$s=str_replace("%91","'",$s);
$s=str_replace("%92","'",$s);
$s=str_replace("%E2%80%99","'",$s);
$s=str_replace("%93","\"",$s);
$s=str_replace("%94","\"",$s);
$s=str_replace("%97","-",$s);
$s=str_replace("%AB","&laquo;",$s);
$s=str_replace("%BB","&raquo;",$s);
$s=str_replace("%85","...",$s);
$s=str_replace("%80","&euro;",$s);
//if ($_SERVER['REMOTE_ADDR']=='85.48.253.234') { echo $s; }
$s=urldecode($s);

return $s;

}

function removeBadChars($str) {
        $str = str_replace  ('¿', '%', $str);
        return $str;
}


function saveEuros($s) {
$s=urlencode($s);
$s=str_replace("%E2%82%AC","%26euro%3B",$s);
$s=str_replace("%C3%82%C2%BF","%26iquest%3B",$s);
return urldecode($s);
//return urldecode($s);
}

function normalizeDate($d,$format) {
	return date($format,strtotime($d));
}

function getConf ($mod,$field) {
                if ($field!="") {
                        $sel="SELECT value FROM kms_{$mod} WHERE name='{$field}'";
                        $result = mysql_query($sel);
                        $value  = mysql_fetch_array($result);
                        return $value[0];
                } else {
                        //all
                        $sel="SELECT name,value FROM kms_{$mod}";
                        $data=array();
                        while ($row=mysql_fetch_array($result)) {
                                $data[$row['name']]=$row['value'];
                        }
                        return $data;
                }       
}

?>
