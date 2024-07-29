<?php
include "/usr/local/kms/lib/mod/shared/db_links.php";
include "/usr/share/kms/lib/app/webform/countryselector.php";

function available($query,$tld,$kms,$dblink_cp,$dblink_erp) {
  $username=$kms->user_account['username'];
  //get client data
  $sel="select * from kms_sys_users where username='{$username}'";
  $res=mysql_query($sel,$dblink_cp);
  $user=mysql_fetch_array($res);
if ($user['id']=="") die('user not found');
  $sel="select * from kms_isp_clients where sr_user='".$user['id']."'";
  $res=mysql_query($sel,$dblink_cp);
  $isp_client=mysql_fetch_array($res);

//preu
 $sel="select setupPrice,anualPrice from kms_ecom_services where name='.".$tld."'";
  $res=mysql_query($sel,$dblink_cp);
  $service=mysql_fetch_array($res);

  if ($isp_client['id']=="") die('Per registrar un domini a traves del panell de control has d\'entrar amb l\'usuari del client. Si sou administradors podeu fer-ho a traves dels contractes.');
   if ($service['setupPrice']!=$service['anualPrice']) $price=$service['setupPrice']."&euro;+IVA ("._KMS_ERP_CONTRACTS_RENEW." ".$service['anualPrice']."&euro;/any+IVA)";
   else $price=$service['setupPrice']."&euro;";
   echo "<font color='#00AA00'><b>"._KMS_ISP_DOMAINS_AVAILABLE." "._KMS_GL_A." ".$price."</b></span></font><br><br>"; // echo "{$preu} &euro; ";

   echo "<div style='float:left'>"._KMS_ISP_DOMAINS_REGISTERPERIOD.": <select name='period'>";
        echo "<option value='1Y'>1 "._KMS_GL_YEAR_U."</option>";
        echo "<option value='2Y'>2 "._KMS_GL_YEARS."</option>";
        echo "<option value='3Y'>3 "._KMS_GL_YEARS."</option>";
        echo "<option value='4Y'>4 "._KMS_GL_YEARS."</option>";
        echo "<option value='5Y'>5 "._KMS_GL_YEARS."</option>";
        echo "<option value='6Y'>6 "._KMS_GL_YEARS."</option>";
        echo "<option value='7Y'>7 "._KMS_GL_YEARS."</option>";
        echo "<option value='8Y'>8 "._KMS_GL_YEARS."</option>";
        echo "<option value='9Y'>9 "._KMS_GL_YEARS."</option>";
        echo "<option value='10Y'>10 "._KMS_GL_YEARS."</option>";
   echo "</select></div>";
   echo "<div style='clear:left'</div><br><div style='float:left;padding-left:10px'><input type=\"checkbox\" name=\"autorenew\" checked></div><div style='float:left;padding-top:5px'>"._KMS_DOMAIN_NAMES_AUTORENEW."</div><br><br>";
   echo "<div style='clear:left'</div><div style='float:left;padding-left:10px'><input type=\"checkbox\" name=\"custom_contacts\" onclick=\"$('#edit_contacts').toggle();refreshUI()\"></div><div style='float:left;padding-top:5px'>"._KMS_ISP_DOMAINS_EDIT_CONTACTS."</div><br><br>";
//   echo "<div style='float:left;padding-left:10px'><input type=\"checkbox\" onclick=\"\"></div><div style='float:left;padding-top:5px'>"._KMS_ISP_DOMAINS_EDIT_NAMESERVERS."</div>";
   echo "<div id='edit_contacts' style='border:1px solid #999;padding:10px;clear:left;display:none'>";
   echo "<table>";
   echo "<tr><td colspan=2><b>"._KMS_ISP_DOMAINS_OWNERC."</b> :<br><br></td></tr>";
   echo "<tr><td width='200'>"._KMS_GL_FULLNAME."</td><td><input type=\"text\" name=\"ownerc_fullname\" size=40 value=\"".$isp_client['name']."\"></td></tr>";
   echo "<tr><td>"._KMS_GL_ORGANIZATION."</td><td><input type=\"text\" name=\"ownerc_organization\" size=40 value=\"".$isp_client['name']."\"></td></tr>";
   echo "<tr><td>"._KMS_GL_ADDRESS."</td><td><input type=\"text\" name=\"ownerc_address\" size=40 value=\"".$isp_client['address']."\"></td></tr>";
   echo "<tr><td>"._KMS_GL_POSTALCODE."</td><td><input type=\"text\" name=\"ownerc_zipcode\" size=40 value=\"".$isp_client['zipcode']."\"></td></tr>";
   echo "<tr><td>"._KMS_GL_LOCATION."</td><td><input type=\"text\" name=\"ownerc_city\" size=40 value=\"".$isp_client['location']."\"></td></tr>";
   echo "<tr><td>"._KMS_GL_COUNTRY."</td><td>".webform_country_selector("ownerc_country","code",$isp_client['country'])."</td></tr>";
   echo "<tr><td>"._KMS_GL_PHONE."</td><td><input type=\"text\" name=\"ownerc_phone\" size=40 value=\"".$isp_client['phone']."\"></td></tr>";
   echo "<tr><td>"._KMS_GL_FAX."</td><td><input type=\"text\" name=\"ownerc_fax\" size=40 value=\"".$isp_client['fax']."\"></td></tr>";
   echo "<tr><td>"._KMS_GL_EMAIL."</td><td><input type=\"text\" name=\"ownerc_email\" size=40 value=\"".$isp_client['email']."\"></td></tr>";
   echo "<tr><td colspan=2><hr><b>"._KMS_ISP_DOMAINS_ADMINC."</b> :<br><br></td></tr>";
   echo "<tr><td>"._KMS_GL_FULLNAME."</td><td><input type=\"text\" name=\"adminc_fullname\" size=40 value=\"".$isp_client['name']."\"></td></tr>";
   echo "<tr><td>"._KMS_GL_ORGANIZATION."</td><td><input type=\"text\" name=\"adminc_organization\" size=40 value=\"".$isp_client['name']."\"></td></tr>";
   echo "<tr><td>"._KMS_GL_ADDRESS."</td><td><input type=\"text\" name=\"ownerc_address\" size=40 value=\"".$isp_client['address']."\"></td></tr>";
   echo "<tr><td>"._KMS_GL_POSTALCODE."</td><td><input type=\"text\" name=\"adminc_zipcode\" size=40 value=\"".$isp_client['zipcode']."\"></td></tr>";
   echo "<tr><td>"._KMS_GL_LOCATION."</td><td><input type=\"text\" name=\"adminc_city\" size=40 value=\"".$isp_client['location']."\"></td></tr>";
   echo "<tr><td>"._KMS_GL_COUNTRY."</td><td>".webform_country_selector("adminc_country","code",$isp_client['country'])."</td></tr>";
   echo "<tr><td>"._KMS_GL_PHONE."</td><td><input type=\"text\" name=\"adminc_phone\" size=40 value=\"".$isp_client['phone']."\"></td></tr>";
   echo "<tr><td>"._KMS_GL_FAX."</td><td><input type=\"text\" name=\"adminc_fax\" size=40 value=\"".$isp_client['fax']."\"></td></tr>";
   echo "<tr><td>"._KMS_GL_EMAIL."</td><td><input type=\"text\" name=\"adminc_email\" size=40 value=\"".$isp_client['email']."\"></td></tr>";
   echo "<tr><td colspan=2><hr><b>"._KMS_ISP_DOMAINS_TECHC."</b> :<br><br> </td></tr>";
   echo "<tr><td>"._KMS_GL_FULLNAME."</td><td><input type=\"text\" name=\"techc_fullname\" size=40 value=\"".$isp_client['name']."\"></td></tr>";
   echo "<tr><td>"._KMS_GL_ORGANIZATION."</td><td><input type=\"text\" name=\"techc_organization\" size=40 value=\"".$isp_client['name']."\"></td></tr>";
   echo "<tr><td>"._KMS_GL_ADDRESS."</td><td><input type=\"text\" name=\"ownerc_address\" size=40 value=\"".$isp_client['address']."\"></td></tr>";
   echo "<tr><td>"._KMS_GL_POSTALCODE."</td><td><input type=\"text\" name=\"techc_zipcode\" size=40 value=\"".$isp_client['zipcode']."\"></td></tr>";
   echo "<tr><td>"._KMS_GL_LOCATION."</td><td><input type=\"text\" name=\"techc_city\" size=40 value=\"".$isp_client['location']."\"></td></tr>";
   echo "<tr><td>"._KMS_GL_COUNTRY."</td><td>".webform_country_selector("techc_country","code",$isp_client['country'])."</td></tr>";
   echo "<tr><td>"._KMS_GL_PHONE."</td><td><input type=\"text\" name=\"techc_phone\" size=40 value=\"".$isp_client['phone']."\"></td></tr>";
   echo "<tr><td>"._KMS_GL_FAX."</td><td><input type=\"text\" name=\"techc_fax\" size=40 value=\"".$isp_client['fax']."\"></td></tr>";
   echo "<tr><td>"._KMS_GL_EMAIL."</td><td><input type=\"text\" name=\"techc_email\" size=40 value=\"".$isp_client['email']."\"></td></tr>";
   echo "</table>";
   echo "</div>";

   echo "<div style='clear:left;padding-top:10px'><input style='width: 80px;padding-left: 5px;' class='customButton highlight' onclick=\"document.location='/?domain=".$query."&tld={$tld}&action=add_domain&t=new&_=f&app=".$_GET['app']."&mod=".$_GET['mod']."'\" value=\""._KMS_ISP_DOMAINS_REGISTER_BT." &raquo;\"></div>";
//echo "<div style='clear:left;padding-top:10px'><input style='width: 80px;padding-left: 5px;' class='customButton highlight' type='submit' value=\""._KMS_ISP_DOMAINS_REGISTER_BT." &raquo;\"></div>";

}

function notavail($query,$tld,$this,$dblink_cp,$dblink_erp) {
	echo "<font color='#AA0000'><b>"._KMS_ISP_DOMAINS_NOTAVAIL."!</b></font> - <input style='width: 160px;padding-left: 5px;' class='customButton highlight' value='"._KMS_ISP_DOMAINS_TRANSFER_TXT." &raquo;' onclick=\"$('#enter_authcode').show()\">";
	echo "<div style=\"padding-top:10px;display:none\" id=\"enter_authcode\"><b>AUTHCODE :</b><input id=\"authcode\" type='text'><input type=\"button\" style='width: 80px;padding-left: 5px;' class='customButton highlight' value='"._KMS_ISP_DOMAINS_TRANSFER_BT." &raquo;' onclick=\"document.location='/?domain=".$query."&tld={$tld}&action=add_domain&t=transfer&authcode='+escape($('#authcode').val())+'&_=f&app=".$_GET['app']."&mod=".$_GET['mod']."';\"><br><br>"._KMS_ISP_DOMAINS_AUTHCODE_HELP."</div>";

}
//if ($_SERVER['REMOTE_ADDR']!='88.12.33.163') die('No disponible en aquests moments. Si us plau, torneu-ho a intentar mes tard.');

//prevent www.
$_REQUEST['query']=str_replace("www.","",strtolower($_REQUEST['query']));


if ($_REQUEST['tld']=="") { 
	//compact format
	$_REQUEST['tld']=substr($_REQUEST['query'],strrpos($_REQUEST['query'],".")+1); 
	$_REQUEST['query']=substr($_REQUEST['query'],0,strrpos($_REQUEST['query'],"."));
}
$query= trim(@$_REQUEST['query']).".".$_REQUEST['tld'];
?>
<script type="text/javascript"><?
	if (!(strlen($_REQUEST['query']) > 1))
	{?>
	function copydata() {
		if ($('#same_data').is(':checked')) $('#regdata').slideUp(); else $('#regdata').slideDown();
	}
	
	function setfocus()
	{
	   document.queryform.query.focus();
	   return;
	}

	function check() {
	if ($('#domain').val()=="") {
			alert(unescape("<?=rawurlencode(html_entity_decode(_KMS_ISP_DOMAINS_ERROR1))?>")); 
			return false;
		} else  {

			return true;
		}
	}

	<?
	}?>
//--></script>
<?
if ($_GET['t']=="transfer"||$_GET['t']=="new") {

include "add_domain.php";


} else { 
?>

<!--- formulari de cerca de domini -->
<form id="queryform" name="queryform" method="post" onsubmit="return check()"><br>
<table cellpadding="6" cellspacing="0" border="0" width="540" dir="ltr">
<tr><td>
<table width="100%" cellpadding="0" cellspacing="0" border="0" dir="ltr">
   <tr class="upperrow">
      <td align="left" valign="top" nowrap="nowrap"><font face="Arial" size="+0"><b><?=_KMS_ISP_DOMAINS_REGISTER?></b><br><br></font></td>
   </tr>
   <tr class="middlerow">

      <td align="left" valign="middle" nowrap="nowrap">www.<input type="text" name="domain" id="domain" value="<?=$_REQUEST['domain']?>" class="queryinput" />&nbsp;


<?
if ($_REQUEST['extension']=="") $tld="com"; else $tld=$_REQUEST['extension'];
?>
<select name="extension">
<?
$qry = "SELECT id,name, featured, anualPrice FROM kms_ecom_services WHERE family=1 ORDER BY name ASC, featured DESC, name ASC";
$result_extensions = mysql_query($qry,$dblink_cp);
?>

<? while ($ext = mysql_fetch_array($result_extensions)) { ?>

        <option value="<?=str_replace(".","",$ext['name'])?>" <? if (".".$tld==$ext['name']) echo " selected";?>><?=$ext['name']?></option>
<? } ?>
 
</select>
<input class="customButton highlight" type="submit" name="submit" value="<?=_KMS_ISP_DOMAINS_CHECK?>" style="cursor:pointer;cursor:hand"/></td>
</form>   </tr>
<tr>
<td></td>
</tr>

</table>
</td></tr>
</table>

<? } //else ?>

<!--- fi de formulari de cerca de domini -->

<?php
if (strlen($_REQUEST['domain']) > 1)
{
?>
<br><table cellpadding="0" cellspacing="0" border="0" width="528" dir="ltr">
<tr align="left" valign="top"><td>
<?php
// Check domain; continue to next form only when domain is free
// openprovider api
require_once(dirname(__FILE__).'/api/API.php');
require_once(dirname(__FILE__).'/openprovider/app/Config/cfg.inc.php');
require_once(dirname(__FILE__).'/api/apiwrapper.inc.php');

        $api=APIConnect($cfg);
        if (APICheckDomain($_POST,$cfg,$api)) {
            $register_url='customercreation.php?domain='.$_POST['domain'].'&extension='.$_POST['extension'];
            $msg = "<span style='color:#090'>Domain name available. <a href='{$register_url}'>Click here to register</a></span>";
		available($_POST['domain'],$_POST['extension'],$this,$dblink_cp,$dblink_erp);
        }	
        else {
            $msg = "<span style='color:#900'>Domain is not available for registration</span>";
		notavail($_POST['domain'],$_POST['extension'],$this,$dblink_cp,$dblink_erp);
        }


//   echo "\n";
//   echo "<b>"._KMS_GL_RESULTS_FOR." ".$query. ":</b>\n";
// echo "\n";
?>
<?
}
else
{
?>
<?php
}
