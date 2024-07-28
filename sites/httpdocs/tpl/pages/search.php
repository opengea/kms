<h1>Resultados de búsqueda</h1>
<b>Buscando por <?=$_POST['searchword']?></b><br>
<div class="row">
        <div class="col-12 col-sm-12 col-md-3 col-lg-3">
        <? $sel="select * from kms_sites_pages where body like \"%".$_POST['searchword']."%\"";
           $res=mysqli_query($dblink,$sel);
           while ($cat=mysqli_fetch_assoc($res)) { ?>
                <div class="ltmenu" ><a class="linkgray <?if ($_GET['a']==urlize($cat['category'])) echo "selected"?>" href="<?=$url_base?>/cataleg/category/<?=urlize($cat['category'])?>"><?=$ll[urlize($cat['category'])]?></a></div>
           <? } ?>
        </div>
        <div class="col-12 col-sm-12 col-md-9 col-lg-9">
	<? if ($_GET['a']!="") { ?>        <h1 style="padding-top:0px"><?=$ll[$_GET['a']];?></h1> <? } ?>

<?
//cerca per titol
$res=mysqli_query($dblink,"select * from kms_cat_productes where title like \"%".$_POST['searchword']."%\" and status=1 order by creation_date desc");
?>
<? $once=false;
while ($product=mysqli_fetch_assoc($res)) {

		if (!$once) { ?> <h1 style="padding-top:0px"><?=$ll['menu3']?></h1><div class="row"> <? $once=true;}

                $res2=mysqli_query($dblink,"select * from kms_cat_autors where id=".$product['autor_id']);
                $autor=mysqli_fetch_assoc($res2);

                if ($product['autor2_id']!="") {
                $res2=mysqli_query($dblink,"select * from kms_cat_autors where id=".$product['autor2_id']);
                $autor2=mysqli_fetch_assoc($res2);

                }
        ?>
        <div class="llibrecat col-12 col-sm-12 col-md-6 col-lg-6 row">
                <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                        <a href="<?=$url_base?>/cataleg/<?=urlize($product['title'])?>"><img  src="<?=$url_base?>/files/catalog/cat_productes/picture/<?=$product['picture']?>"></a>
                </div>
                 <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                       <a class="autor" href="<?=$url_base?>/autors/<?=urlize($autor['name'])?>"><?=$autor['name']?></a><br>
                        <? if ($product['autor2_id']!="") {?>
                         <a class="autor" href="<?=$url_base?>/autors/<?=urlize($autor2['name'])?>"><?=$autor2['name']?></a><br>
                        <? } ?>
                       <strong><a class="titol" href="<?=$url_base?>/cataleg/<?=urlize($product['title'])?>"><?=$product['title']?></a></strong><br>

                </div>
        </div>

<?
}
if ($once) echo "</div>";
?>
</div>
</div>
