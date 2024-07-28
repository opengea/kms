<div class="article">

<div class="article_header">
<h1><?=$article['title_'.$_GET['l']]?>
<span class="subtitle"><?if ($article['subtitle_'.$_GET['l']]!="") echo "<br>".$article['subtitle_'.$_GET['l']]; ?></span>
</h1>

<div id="autors_article" class="center col-12 col-sm-12 col-md-10 col-lg-5" style="max-width:570px">
<h2><?$autors=explode(",",$article['author']);
$c=0;
foreach ($autors as $autorid) {
 $sele="select * from kms_cat_autors where id=".$autorid; $resa=mysqli_query($dblink,$sele); $author=mysqli_fetch_array($resa); ?>
<?if ($c>0) echo ", ";?><a href="#ex<?=$author['id']?>" rel="modal:open"><?=$author['name']?></a><?
$c++;
}

foreach ($autors as $autorid) {
 $sele="select * from kms_cat_autors where id=".$autorid; $resa=mysqli_query($dblink,$sele); $author=mysqli_fetch_array($resa); ?>
<? include "fitxa_autor.php";
}

?>
</h2>
</div>

<? $sel="select * from kms_cat_sections where id=".$article['section_id'];
$res=mysqli_query($dblink,$sel);
$seccio=mysqli_fetch_assoc($res);
?>
<br>
<div class="article_head2">
<div class="left" style="padding-top:7px"><?=$seccio['title_'.$_GET['l']]?></div>
<div class="right">

<?/*
<!-- AddToAny BEGIN -->
<a class="a2a_dd" href="https://www.addtoany.com/share"><?=$ll['share']?></a>
<script>
var a2a_config = a2a_config || {};
a2a_config.onclick = 1;
a2a_config.locale = "ca";
a2a_config.num_services = 5;
</script>
<script async src="https://static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END -->
*/?>
<?/*
<!-- AddToAny BEGIN -->
<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
<a class="a2a_dd" href="https://www.addtoany.com/share"><?=$ll['share']?></a>
<a class="a2a_button_facebook"></a>
<a class="a2a_button_twitter"></a>
<a class="a2a_button_email"></a>
<a class="a2a_button_whatsapp"></a>
<a class="a2a_button_linkedin"></a>
</div>
<script async src="https://static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END -->
*/?>
<!-- AddToAny BEGIN -->
<div class="compartir" onclick="$('.a2a_kit').toggle()"><?=$ll['share']?></div>
<div class="a2a_kit a2a_kit_size_32 a2a_default_style" style="display:none">
<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
<a class="a2a_button_facebook"></a>
<a class="a2a_button_twitter"></a>
<a class="a2a_button_email"></a>
<a class="a2a_button_whatsapp"></a>
<?/*<a class="a2a_button_linkedin"></a>*/?>
</div>
<script async src="https://static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END -->

<? 
 //find prev tip
$articlets=array();
$articlets[0]="";
$i=1;
while ($child=mysqli_fetch_assoc($res_children)) { $articlets[$i]=urlize($child['title_'.$_GET['l']]);
     if ($_GET['a']!=""&&$_GET['a']==$articlets[$i]) $index=$i;
	$i++;
 }

if ($article['parent']=="0"||$article['parent']=="") $index=0;

if ($index>0) { 
?>
<div class="prev_article"><a href="/<?=$_GET['l']?>/<?=$_GET['s']?>/<?=$_GET['p']?>/<?=$articlets[$index-1]?>">&#8592;</a></div>
<? } ?>

<div class="next_article"><a href="/<?=$_GET['l']?>/<?=$_GET['s']?>/<?=$_GET['p']?>/<?=$articlets[$index+1]?>">&#8594;</a></div>




</div>
</div>
<? if ($article['picture']!="")  { ?>
<div class="imatgeportada" style="background-image:url('/files/pictures/docs_articles/picture/<?=$article['picture']?>')"></div>
<? } ?>
<div class="peufoto col-12 col-sm-12 col-md-10 col-lg-8"><?=$article['picture_footer_'.$_GET['l']]?></div>
</div>

<div class="article_body">

<div id="entradeta"><?=$article['short_body_'.$_GET['l']]?></div>

<div class="data"><?=date('d',strtotime($article['creation_date']))?> <?=$mesos[date('m',strtotime($article['creation_date']))]?> <?=date('Y',strtotime($article['creation_date']))?></div>
<?$article['body_'.$_GET['l']]=str_replace("http://data.revistaidees.cat/","/",$article['body_'.$_GET['l']]);?>
<?=$article['body_'.$_GET['l']]?>
</div>


</div>
