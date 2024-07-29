<?
$t=0;
        $sel = "SELECT * from kms_isp_domains where id=".$id;
        $res=mysqli_query($this->dm->dblinks['client'],$sel);
        $domain=mysqli_fetch_array($res);


	/*
	$pos = strpos($domain['name'], '.');
	$length = strlen($domain['name']);
	$domainName = substr($domain['name'], 0, $pos);
	$tld = substr($domain['name'], $pos, $length);

	
	$curlOb = curl_init();
        curl_setopt($curlOb, CURLOPT_URL,"https://g1.intergridnetwork.net/kms/lib/isp/domains/check_domain.php");
        curl_setopt($curlOb, CURLOPT_POST, 1);
        curl_setopt($curlOb, CURLOPT_POSTFIELDS, array("domain"=>$domainName,"extension"=>$tld));
        $XMLResponse = curl_exec($curlOb);
        curl_close ($curlOb);

	$result = simplexml_load_string($XMLResponse);
	$out.= $result;
	file_put_contents('/var/log/kms/isp_domain_status_openprovider.log', $result, FILE_APPEND);

	*/
	
	if ($domain['auto_renew']) $icon="check2.gif"; else $icon="none.png";
	        $action="/?app=".$_GET['app']."&mod=isp_domains&_=e&id=".$id;
        $out="<div style='float:left'><a href=\"$action\" title=\"".$title."\"><img src=\"/kms/css/aqua/img/small/$icon\"></a></div><div style='float:left;padding-left:5px;padding-top:2px;'>";
        if ($this->show_label) $out.=$label;
	$out.=$output;
        $out.="</div>";
?>
