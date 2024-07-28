<?

// intelligent color
//if (strpos($body,"<body>"))  { $s=$current_mailing['bgcolor']; echo $s;}  else {


// footer per quan obrimr desde el client de correu
$bgcolor=str_replace("#","",$bgcolor);
$bgcolor="#".$bgcolor;

if (!isset($current_mailing['show_intergrid_label'])) $current_mailing['show_intergrid_label']="1";

if ($current_mailing['show_intergrid_label']=="1"||$current_mailing['unsubscribe_link']=="1") {

$footer_add = "<!--footer_mailclient_start--><center><table style=\"width:100%;color:{$color1};background-color:{$bgcolor};padding-top:20px;height:20px;padding:8px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
if ($current_mailing['show_intergrid_label']=="0") $footer_add .= "<tr><td valign=\"center\"><span style=\"color:{$color2};font-family:arial,helvetica,tahoma,verdana;font-size:11px\">"; else $footer_add .= "<tr><td valign=\"center\"><span style=\"color:{$color2};font-family:arial,helvetica,tahoma,verdana;font-size:11px\">Powered by <a href=\"http://www.intergrid.cat/web/netmarketing?utm_source=".$utm_source."&utm_medium=".$utm_medium."&utm_campaign=".$utm_campaign."\" style=\"text-decoration:none;color:{$color2}\"><b>Intergrid KMS</b></a>";

if ($clientId!="") $footer_add .= "<img src=\"http://data.".$current_domain."/kms/mod/emailing/openMailCheck.php?dom=".$current_domain."&cid=".$clientId."&eid=".$mailingId."&to=".$to."&mod=".$mod."\">";
//$footer_add.="\">http://data.".$current_domain."/kms/mod/emailing/openMailCheck.php?dom=".$current_domain."&cid=".$clientId."&eid=".$mailingId."&to=".$to;
$footer_add .= "<br></td>";
if ($current_mailing['unsubscribe_link']==1) $footer_add .= "<td align=\"right\" style=\"vertical-align:center\"><span style=\"color:{$color2};font-family:arial,helvetica,tahoma,verdana;font-size:11px\">"._KMS_MAILING_TXT_UNSUBSCRIBETEXT1."<a href=\"http://data.".$current_domain."/kms/mod/emailing/mod/tools/unsubscribe.php?eid={$mailingId}&rcpt_email=".$to."&quest=y&lang={$current_mailing['language']}\" style=\"color:{$color1};text-decoration:none;font-weight:bold\">"._KMS_MAILING_TXT_UNSUBSCRIBETEXT2."</a></span></td>";
$footer_add .= "</tr></table><!--footer_mailclient_end-->";

}

//$footer_add="";
// footer per quan obrim desde navegador
//$footer_openonbrowser_add = "<!--footer_browser_start--><center><table width=\"".$pagewidth."\" style=\"background-color:#".$current_template['bgcolor']."\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
/*$footer_openonbrowser_add .= "<tr><td colspan=\"3\" valign=\"top\"><table width=\"100%\" height=\"50\" style=\"padding:0px;font-size:12px;color:#555;\"><tr><td style=\"font-size:12px;vertical-align:top;text-align:left\"><span style=\"font-family:arial,helvetica,tahoma,verdana;font-size:11px\">Powered by <a href=\"http://www.intergrid.cat/web/netmarketing?utm_source=<?=\$_GET['utm_source'];?>&utm_medium=<?=\$_GET['utm_medium'];?>&utm_campaign=<?=\$_GET['utm_campaign'];?>\" style=\"text-decoration:none;color:#555\">Intergrid KMS eMailing</a><img src=\"http://data.<?=\$_GET['dom'];?>/kms/mod/emailing/openMailCheck.php?dom=<?=\$_GET['dom'];?>&cid=<?=\$_GET['cid'];?>&eid=<?=\$_GET['eid'];?>&to=<?=\$_GET['to'];?>\"><br><img src=\"http://data.<?=\$_GET['dom'];?>/kms/mod/emailing/logo_intergrid.png\" width=\"70\"></span></td><td align=\"right\" style=\"vertical-align:top\"><span style=\"font-family:arial,helvetica,tahoma,verdana;font-size:11px\">"._KMS_MAILING_TXT_UNSUBSCRIBETEXT1."<a href=\"http://data.<?=\$_GET['dom'];?>/kms/mod/emailing/mod/tools/unsubscribe.php?eid=<?=\$_GET['eid'];?>&rcpt_email=<?=\$_GET['to'];?>&quest=y&lang=<?=\$_GET['lang'];?>\" style=\"color:#555;text-decoration:none\">"._KMS_MAILING_TXT_UNSUBSCRIBETEXT2."</a></span></td></tr><tr><td class=\"lopd\">--TXT_LOPD--</td></tr></table></td></tr><!--footer_browser_end-->";*/

?>
