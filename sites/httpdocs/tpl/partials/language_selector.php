<?
$sel="select * from kms_sys_languages order by sort_order asc";
$res=mysqli_query($dblink,$sel);
if ($_GET['s']!="") $where="/".$_GET['s'];
if ($_GET['p']!="") $where.="/".$_GET['p'];
if ($_GET['a']!="") $where.="/".$_GET['a'];
if ($_GET['b']!="") $where.="/".$_GET['b'];

$selector="<div id=\"avail_languages\">";
while ($idioma=mysqli_fetch_assoc($res)) { 

	
if ($_GET['l']==$idioma['code']) { ?> 
	<a id="current_lang" href="<?=$conf['site_url']?>/<?=$idioma['code']?><?=$where?>"><?=$idioma['name']?> <div><i class="fas fa-angle-down"></i></div></a>
<? }
 else {
	$selector.="<a href=\"".$conf['site_url']."/".$idioma['code'].$where."\">".$idioma['name']."</a>";
 } 
}

$selector.="</div>";
echo $selector;

?>
