<? 
if ($_GET['p']=="") { //$_GET['p']!=""&&$_GET['p']!="category") { // Cataleg ?>

<div class="row">
        <div class="col-12 col-sm-12 col-md-3 col-lg-3">
	<? $sel="select distinct category from kms_cat_productes";
	   $res=mysqli_query($dblink,$sel);
	   while ($cat=mysqli_fetch_assoc($res)) { ?>
		<div class="ltmenu" ><a class="linkgray" href="<?=$url_base_lang?>/cataleg/category/<?=urlize($cat['category'])?>"><?=$ll[urlize($cat['category'])]?></a></div>
	   <? } ?>
	</div>
	<div class="col-12 col-sm-12 col-md-9 col-lg-9">
	<h1 style="padding-top:0px !important"><?=$ll['menu3']?></h1>

<?
$res=mysqli_query($dblink,"select * from kms_cat_productes where status=1 order by creation_date desc");
?>
<div class="row">
<? while ($product=mysqli_fetch_assoc($res)) {

		$res2=mysqli_query($dblink,"select * from kms_cat_autors where id=".$product['autor_id']);
		$autor=mysqli_fetch_assoc($res2);

		if ($product['autor2_id']!="") {
		$res2=mysqli_query($dblink,"select * from kms_cat_autors where id=".$product['autor2_id']);
                $autor2=mysqli_fetch_assoc($res2);

		}
	?>
	<div class="llibrecat col-12 col-sm-12 col-md-6 col-lg-6 row">
		<div class="col-6 col-sm-6 col-md-6 col-lg-6">
			<a href="<?=$url_base_lang?>/cataleg/<?=urlize($product['title'])?>"><img  src="<?=$url_base?>/files/catalog/cat_productes/picture/<?=$product['picture']?>"></a>
		</div>
		 <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                       <a class="autor" href="<?=$url_base_lang?>/autors/<?=urlize($autor['name'])?>"><?=$autor['name']?></a><br>
			<? if ($product['autor2_id']!="") {?>
			 <a class="autor" href="<?=$url_base_lang?>/autors/<?=urlize($autor2['name'])?>"><?=$autor2['name']?></a><br>
			<? } ?>
		       <strong><a class="titol" href="<?=$url_base_lang?>/cataleg/<?=urlize($product['title'])?>"><?=$product['title']?></a></strong><br>

                </div>
	</div>

<? } ?>
</div>



	</div>
</div>

<? } else if ($_GET['p']=="category"&&$_GET['a']!="") { 

?>
<div class="row">
        <div class="col-12 col-sm-12 col-md-3 col-lg-3">
        <? $sel="select distinct category from kms_cat_productes";
           $res=mysqli_query($dblink,$sel);
           while ($cat=mysqli_fetch_assoc($res)) { ?>
                <div class="ltmenu" ><a class="linkgray <?if ($_GET['a']==urlize($cat['category'])) echo "selected"?>" href="<?=$url_base_lang?>/cataleg/category/<?=urlize($cat['category'])?>"><?=$ll[urlize($cat['category'])]?></a></div>
           <? } ?>
        </div>
        <div class="col-12 col-sm-12 col-md-9 col-lg-9">
        <h1 style="padding-top:0px !important"><? if ($_GET['a']=="") echo $ll['menu3']; else echo $ll[$_GET['a']];?></h1>

<?
$res=mysqli_query($dblink,"select * from kms_cat_productes where category='".$_GET['a']."' and status=1 order by creation_date desc");
?>
<div class="row">
<? while ($product=mysqli_fetch_assoc($res)) {

                $res2=mysqli_query($dblink,"select * from kms_cat_autors where id=".$product['autor_id']);
                $autor=mysqli_fetch_assoc($res2);

                if ($product['autor2_id']!="") {
                $res2=mysqli_query($dblink,"select * from kms_cat_autors where id=".$product['autor2_id']);
                $autor2=mysqli_fetch_assoc($res2);

                }
        ?>
        <div class="llibrecat col-12 col-sm-12 col-md-6 col-lg-6 row">
                <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                        <a href="<?=$url_base_lang?>/cataleg/<?=urlize($product['title'])?>"><img  src="<?=$url_base?>/files/catalog/cat_productes/picture/<?=$product['picture']?>"></a>
                </div>
                 <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                       <a class="autor" href="<?=$url_base_lang?>/autors/<?=urlize($autor['name'])?>"><?=$autor['name']?></a><br>
                        <? if ($product['autor2_id']!="") {?>
                         <a class="autor" href="<?=$url_base_lang?>/autors/<?=urlize($autor2['name'])?>"><?=$autor2['name']?></a><br>
                        <? } ?>
                       <strong><a class="titol" href="<?=$url_base_lang?>/cataleg/<?=urlize($product['title'])?>"><?=$product['title']?></a></strong><br>

                </div>
        </div>

<? } ?>
</div>



        </div>
</div>



<? } else { //fitxa llibre 
$res=mysqli_query($dblink,"select * from kms_cat_productes where status=1 order by creation_date desc");
while ($product=mysqli_fetch_assoc($res)) { if ($_GET['p']==urlize($product['title'])) break; }
$res2=mysqli_query($dblink,"select * from kms_cat_autors where id=".$product['autor_id']);
$autor=mysqli_fetch_assoc($res2);
if ($product['autor2_id']!="") {
    $res2=mysqli_query($dblink,"select * from kms_cat_autors where id=".$product['autor2_id']);
    $autor2=mysqli_fetch_assoc($res2);
}
?>

<div class="row">
        <div class="col-12 col-sm-12 col-md-3 col-lg-3">
		<img class="portada" src="<?=$url_base?>/files/catalog/cat_productes/picture/<?=$product['picture']?>">
		<form action="<?=$url_base_lang?>/shopping_cart" method="POST"><input type="hidden" name="action" value="scart_add"><input type="hidden" name="item" value="<?=$product['id']?>"><div style="text-align:center;margin-bottom:10px !important;"><?=$ll['preu']?>: <strong class='colored'><?=$product['preu']?> &euro;</strong><br><?=$ll['descompte']?></div><button class="btn"><?=$ll['add_to_shopping_cart']?></button></form>
        </div>
        <div class="col-12 col-sm-12 col-md-3 col-lg-6">
		<h3><a href="<?=$url_base_lang?>/autors/<?=urlize($autor['name'])?>"><?=$autor['name']?></a>
                        <? if ($product['autor2_id']!="") {?>
                         <br><a class="autor" href="<?=$url_base_lang?>/autors/<?=urlize($autor2['name'])?>"><?=$autor2['name']?></a>
                        <? } ?>
		</h3>
	        <h2><?=$product['title']?></h2>
		<?=$product['description']?>
		<? if ($product['link']!="") echo "<hr>".$ll['product_link']."<br><a href=\"".$product['link']."\" target=\"_blank\">".$product['link']."</a>";?>
	</div>
	<div class="col-12 col-sm-12 col-md-3 col-lg-3">
		<div class="box addpad">
		<? $elem=array("creation_date","idioma","isbn","pages","format","original_title","translation","disseny","coberta","illustracio");
		foreach ($elem as $e) {

		if ($e=="creation_date") $product[$e]=$mesos[date('m',strtotime($product[$e]))]." ".date('Y',strtotime($product[$e]));
		 if ($product[$e]!="") { ?> <div class="element"><b><?=$ll[$e]?>:</b><br><?=$product[$e]?></div> <? } ?>
		<? } ?>
		</div>
        </div>

<div class="mob width100" style="margin-top:20px"><form action="<?=$url_base_lang?>/shopping_cart" method="POST"><input type="hidden" name="action" value="scart_add"><input type="hidden" name="item" value="<?=$product['id']?>"><div style="text-align:center;margin-bottom:10px !important;"><?=$ll['preu']?>: <strong class='colored'><?=$product['preu']?> &euro;</strong><br><?=$ll['descompte']?></div><button class="btn"><?=$ll['add_to_shopping_cart']?></button></form></div>

</div>

<? } ?>

