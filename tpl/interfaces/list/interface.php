<?

$kms->interface = new Array();

/*CSS
$kms->interface['menu_color'] = "#872822";
$kms->interface['header_color'] = "#872822";
$kms->interface['bg_image'] = "background.png";
*/

$kms->interface['show_menu'] = false;
$kms->interface['show_menu_labels'] = true;
$kms->interface['show_menu_views'] = true;
$kms->interface['show_menu_recents'] = true;
$kms->interface['show_menu_items'] = array(10,'fieldname');
$allowed_types = array('tag','families');
$kms->interface['labels']= array ("n"=>5,"sortby"="asc","levels"=>2,$allowed_types,"def_tag"=>"families"=);

$kms->onClickItem = "_=e&target=divX";
//$kms->onClickItem = "_=b&target=divX&app=D";

//$kms->interface['widgets'] = 

?>

<table class="application" width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="padding:0px">

<tr><td valign="top" height="100%" style="vertical-align:top">
<table class="OPT" cellpadding="0" cellspacing="0" border="0" width="100%">
<tr class="buttonbar">
<td style="vertical-align:middle;"><?=$kms->interface['top_buttons'] ?></td>
<td align="right" style="vertical-align:middle;padding-right:5px"><?=$kms->interface['filter_options'] ?></td>
</tr>
</table>

<table class="content" width="100%" cellspacing="0" cellpadding="0">
<tbody><tr><td class="leftmenu" style="vertical-align:top">
<div id="leftmenu" class="leftmenu">
<?=$kms->interface['menu_labels'] ?>
<?=$kms->interface['menu_views'] ?>
<?=$kms->interface['menu_recents'] ?>
<?=$kms->interface['menu_items'] ?>
</div>
</td>

<td><div class="menuSwitcher"><table height="100%" cellpadding="0" cellspacing="0"><tbody><tr><td valign="center"><img width="6" height="60" src="/kms/css/aqua/img/interface/bar_close.gif" id="bar_button" title="Hide/show the navigation pane" onclick="switchMenu('default','aqua');" style="cursor:pointer" alt=""></td></tr></tbody></table></div></td>

<td class="list"> 
<table cellspacing="0" cellpadding="2" width="100%" border="0" class="LIST">
<?=$kms->interface['list'] ?>
</table>

<table class="OPT" cellpadding="0" cellspacing="0" border="0" width="100%" style="padding:5px">
<?=$kms->interface['list_foot'] ?>
</table>
