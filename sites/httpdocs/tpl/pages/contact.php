<? 
echo "hola eh";print_r($page);
$sel="select * from kms_sites_pages where permalink='".$_GET['s']."'";
$res=mysqli_query($dblink,$sel);
$page=mysqli_fetch_assoc($res);
include "newsletter.php";?>
<div class="pagina col-12 col-sm-12 col-md-6 col-lg-8" style="margin:auto">
<h1><?=$page['title_'.$_GET['l']]?></h1>
<div class="article_body"><p><?=$page['body_'.$_GET['l']]?></p></div>
</div>
