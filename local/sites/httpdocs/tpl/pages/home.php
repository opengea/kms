
<? $randombg=array("1/170620073220333.jpg","1/Sala1-3.png","2/202003120509402301-.jpg"); ?>


<div id="img_portada" class="container-fluid" _style="background-image:url('http://www.ashtangayogabcn.com/files/pictures/albums/<?=$randombg[rand(0,count($randombg)-1)]?>')">
</div>


<div class="page col-12 col-sm-12 col-md-10 col-lg-6 col-xl-8">

<?

if (substr($page['body'],0,1)=="_") echo add_widgets($ll[$page['body']]); else echo $page['body'];
?>

</div>
