<?
$body=str_replace("<BODY","<body",$body);
$s=substr($body,strpos($body,"<body"));$p=strpos($s,">");$s=substr($s,0,$p);
if (!strpos($s,"bgcolor=")) { $body=str_replace("<body","<body background-color='#".$current_template['bgcolor']."'",$body); $s=$current_template['bgcolor']; } else { $s=substr($s,strpos($s,"bgcolor="));$s=substr($s,10,6); }
$s=str_replace("#","",$s);

if ($current_template['bandatext_color']==""||$current_template['bandabg_color']=="") {
	//automatic colors
	if ($s>"888888") {$bgcolor="#ffffff";$color1="#777";$color2="#444"; } else { $bgcolor="#000000";$color1="#ccc";$color2="#777"; }
	if (strtolower($s)=="ffffff") $bgcolor="#eeeeee";
} else {
	//manual colors
	$bgcolor=$current_template['bandabg_color'];
	if ($current_template['bandabg_color']==$current_template['bandatext_color']) {
		//excepcio!, no pot ser el mateix color
		$c=str_replace("#","",$current_template['bandabg_color']);
		if ($c>"888888") $current_template['bandatext_color']="#000"; else $current_template['bandatext_color']="#fff";
	}
	$color1=$current_template['bandatext_color'];
	$color2=$current_template['bandatext_color'];
}
//echo $bgcolor;exit;
?>
