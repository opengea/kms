<?
$res=mysqli_query($dblink,"select * from kms_sites_galleries where id={$gallery_id} and status=1");
$gallery=mysqli_fetch_assoc($res);
$res=mysqli_query($dblink,"select * from kms_lib_pictures where album_id='".$gallery['play_album']."' order by sort_order");
?>
<div class="slider row">
<? while ($pic=mysqli_fetch_assoc($res)) {?>
	<div class="llibre col-12 col-sm-12 col-md-3 col-lg-3">
		<img style="" src="<?=$url_base?>/files/pictures/albums/1/<?=$pic['file']?>">
	</div>

<? } ?>
</div>

<script type="text/javascript" src="/lib/slick/slick.min.js"></script>

<script>
$('.slider').slick({
  infinite: true,
  dots: false,
  arrows: <? if ($gallery['directionNav']) echo "true"; else echo "false";?>,
  speed: <?=$gallery['animSpeed']?>,
  slidesToShow: 1,
  slidesToScroll: 1,
  responsive: [
	{ breakpoint: 900,
	  settings: {
		  arrows: <? if ($gallery['directionNav']) echo "true"; else echo "false";?>,
		  slidesToShow: 1,
		  slidesToScroll: 1,
	  }
	}]
});
</script>
