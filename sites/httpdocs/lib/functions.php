<?
//global vars
$gallery_id=0;

function add_widgets($contents) {
        global $gallery_id,$url_base_lang,$ll;

	//galleries
	if (strpos($contents,"[GALLERY ")) {
	$gallery_id=substr($contents,strpos($contents,"[GALLERY ")+9,1);
	if ($gallery_id) $contents=substr($contents,0,strpos($contents,"[GALLERY ")).includeToVar("tpl/partials/gallery.php").substr($contents,strpos($contents,"[GALLERY ")+11);
	}
	$widgets=array("columns","profesores","horarios","contacto");

	foreach ($widgets as $w) {
	$wu=strtoupper($w);
	//columns
	if (strpos($contents,"[".$wu."]")) $contents=substr($contents,0,strpos($contents,"[".$wu."]")).includeToVar("tpl/partials/".$w.".php").substr($contents,strpos($contents,"[".$wu."]")+strlen($wu)+2);

	}

	//sections
/*        if (strpos($contents,"[SECTION ")) {
	$pos=strpos($contents,"[SECTION ")+9;
	$len=strpos(substr($contents,$pos),"]");
        $section_name=strtolower(substr($contents,$pos,$len));
//        if ($section_name) $contents=substr($contents,0,strpos($contents,"[SECTION ")).includeToVar("tpl/partials/".$section_name.".php").substr($contents,strpos($contents,"[SECTION ")+9+$len);
        }
*/
	return $contents;

}
function includeToVar($file){
    global $dblink,$gallery_id,$url_base_lang,$ll;
    ob_start();
    require($file);
    return ob_get_clean();
}
function percent($value,$pc) {
if ($pc=="contras") return $value;
		if($value>100) $value=100;
	        else if ($value<0) $value=0;
	return $value;
}
function value2($claim_id,$carried_value) {
        global $dblink, $topic_id;
	$sel="select * from claims where id=".$claim_id." and topic_id=".$topic_id;
	if ($debug) echo "<br><br>{$sel};<br>";
	$res=mysqli_query($dblink,$sel);
	$claim=mysqli_fetch_assoc($res);

        $sel="select * from claims where parent_id=".$claim_id." and topic_id=".$topic_id;
	if ($debug) echo "<br>value2({$claim_id}) {$sel};<br>";
        $res=mysqli_query($dblink,$sel);
        $num=mysqli_num_rows($res);
        if ($num==0) $num=1;
        $factor=100/$num;
	// echo "factor=".$factor."<br>";
	if ($carried_value=="") $carried_value=100;
	$value=$carried_value;
//	if ($claim['sign']=="-") { $factor=-$factor; $value=-100; } else $value=100;
	$there_are_subclaims=false;

	while ($subclaim=mysqli_fetch_assoc($res)) {
		$there_are_subclaims=true;
		if ($debug) echo "hi ha subclaims";
	        $value=value2($subclaim['id'],$value);
		//conversio de valor!
                if ($claim['id']=="") {
			if ($subclaim['sign']=="-") $value-=$factor;
			else  $value+=$factor;

		} else {
			if ($debug) echo $value.":".$factor;
			if ($claim['sign']=="-"&&$subclaim['sign']=="-") {  $value-=$factor; }
			else if ($claim['sign']=="-"&&$subclaim['sign']!="-") { $value+=$factor; }
			else if ($claim['sign']!="-"&&$subclaim['sign']=="-") { $value-=$factor; }
			else if ($claim['sign']!="-"&&$subclaim['sign']!="-") { $value+=$factor; }
			if ($debug) echo "=>".$value."<br>";
		}

		//echo $value."<br>";
	}
	if ($debug&&!$there_are_subclaims) echo "NO hi ha subclaims<br>";
	//echo "<br>valor previ ".$value." ".$claim['sign']."<br>";
	if (!$there_are_subclaims) {
	//	if ($value==0) $value=100; 
//		 echo "<br>".$claim['title']." sign:".$claim['sign'].":".$value;
	} else {
	//	if ($debug) 
//		echo "<br>".$claim['title']." sign:".$claim['sign'].":".$value;

//		if ($claim['sign']!="-"&&$value<0) $value=-$value;
//		if (($claim['sign']=="-"&&$value>0)||($claim['sign']!="-"&&$value<0)) $value=-$value; 

//		echo " => ".$value;
		
	}

//	if ($value==0) $value=100;
//	if ($value>100) $value=100;
	$value=round($value);
	if ($debug) echo "<b>claim_id={$claim_id} valor=".$value."</b><br>";
	return $value;

}

function setValues($topic_id) {
        global $dblink, $topic_id;

        $sel="select * from claims where parent_id=0 and topic_id=".$topic_id;
        $res=mysqli_query($dblink,$sel);
        $num=mysqli_num_rows($res);
        if ($num==0) $num=1;
        $factor=100/$num;
	$total=0;
        while ($claim=mysqli_fetch_assoc($res)) {
                $value=setClaimValue($claim['id']);
		$update="update claims set value='".$value."' where id=".$claim['id'];
                $res2=mysqli_query($dblink,$update);
		$total+=$value;
        }
	return $total;
}

function setClaimValue($claim_id) {
        global $dblink,$topic_id;
        $value=0;
        $sel="select * from claims where parent_id=".$claim_id." and topic_id=".$topic_id;
        $res=mysqli_query($dblink,$sel);
        $num=mysqli_num_rows($res);
        if ($num==0) return 100;
        $factor=100/$num;
	$total=0;
	 //echo "<br>";

//if ($claim_id=="50") echo "<br>";
        while ($row=mysqli_fetch_assoc($res)) {
//if ($claim_id=="44") echo "<br>".$row['id']." ";
		 //perque s'ha d'invertir el signe en cas negatiu?
//                 if ($row['sign']=="-") $value=-$factor; else $value=$factor;
		if ($row['sign']=="-") {
			//contras
			if ($row['sign']=="-") $value=-$factor; else $value=$factor;

		} else {
			//pros
			if ($row['sign']!="-") $value=$factor; else $value=-$factor;

		}

//		 if ($row['sign']=="-") $value=$factor; else $value=-$factor;

		 $value=round($value);
		 $total+=$value;
		 $update="update claims set value='".$value."' where id=".$row['id'];
                 $res2=mysqli_query($dblink,$update);
		 //check if children
		 $sel="select * from claims where parent_id=".$row['id'];
		 $res2=mysqli_query($dblink,$sel);
	         $num=mysqli_num_rows($res2);
		 if ($num>0) setClaimValue($row['id']);

        }
	return $total;
}

/*
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

function desurlize ($s,$nonslash="") {
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
*/	
?>
