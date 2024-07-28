<?
// intelligent color detectoion
include "get_colors.php";

if ($url_body!="") $url=$url_body; else $url=$OpenOnBrowserLink;
$bgcolor=str_replace("##","#",$bgcolor);
$clickOpen = "<!--clickOpen--><table style=\"margin-bottom:0px;width:100%;color:{$color1};height:15px;padding:5px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td style=\"text-align:center\"><span style=\"color:{$color1};font-family:arial,helvetica,tahoma,verdana;font-size:11px\">"._KMS_MAILING_TXT_OPENONBROWSERTEXT1." <a href=\"".$url."\" style=\"color:{$color1};font-weight:bold;text-decoration:none\">"._KMS_MAILING_TXT_OPENONBROWSERTEXT2."</a></span></td></tr></table><!--endclickOpen-->";
if ($bgcolor!="") $clickOpen=str_replace(";height:",";background-color:{$bgcolor};height:",$clickOpen);

?>
