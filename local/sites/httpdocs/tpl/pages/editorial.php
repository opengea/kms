<?
if ($_GET['l']=="ca") $sel="select * from kms_sites_pages where id=1";
else if ($_GET['l']=="es") $sel="select * from kms_sites_pages where id=2";
else if ($_GET['l']=="en") $sel="select * from kms_sites_pages where id=3";

$res=mysqli_query($dblink,$sel);
$page=mysqli_fetch_assoc($res);

?>
<div class="row">
        <div class="llibre col-12 col-sm-12 col-md-3 col-lg-3">
                <img  src="<?=$url_base?>/files/pictures/sir-marbot.jpg">
	</div>
	<div class="llibre col-12 col-sm-12 col-md-9 col-lg-9">
                <h2><?=$page['title']?></h2>
		<hr>
		<?=$page['body']?><br><br>	
        </div>

</div>
