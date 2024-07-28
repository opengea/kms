<!-- The video -->
<? //$random=array("nightrain.mp4","storm.mp4"); 
   $random=array("nightrain.mp4"); 
   $v=$random[rand(0,count($random)-1)];?>
<div id="video_bg">
<video autoplay muted loop id="fsVideo">
  <source src="/files/videos/<?=$v?>" type="video/mp4">
</video>
<div id="video_caption" class="no-gutters col-11 col-sm-10 col-md-10 col-lg-9 col-xl-6">

	<div><h3><?=$ll['_FRASE_INICI_1_']?></h3><br><?=$ll['_FRASE_INICI_2_']?><br><br>
		<br><input onclick="document.location='<?=$url_base_lang?>/metodo'" type="button" id="learn_more" class="bt" value="<?=$ll['_LEARN_MORE_']?>"/>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div id="icon_scroll_down" class="bt"><a class="scroll" href="#block1"><img src="/kms/img/icons/scroll/icons8-down-button-100.png"></a></div>

</div>
<?

// $randombg=array("1/170620073220333.jpg","1/Sala1-3.png","2/202003120509402301-.jpg"); ?>



<div id="block1" class="page-block no-gutters col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
<div class="content row col-12 col-sm-12 col-md-12 col-lg-10 col-xl-8" style="margin:auto;padding:0px">

<?

//if (substr($page['body'],0,1)=="_") echo add_widgets($ll[$page['body']]); else echo $page['body'];
?>

<div class="block no-gutters col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
	<a href="<?=$url_base_lang?>/quien-soy">
	<img src="//www.eficaciapsicologica.com/files/pictures/albums/3/202005110105414944-.jpg">
	</a>
	<div class="caption black">Conoce a<br>Gerard Martí<br><div class="bt">QUIEN SOY</div></div>
	
</div>

<div class="block no-gutters col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
        <a href="<?=$url_base_lang?>/consultas">
        <img src="//www.eficaciapsicologica.com/files/pictures/albums/3/202005110151109631-.jpg">
        </a>
        <div class="caption size2 white">Consultas<br><span>Online y Presenciales</span></div>
</div>

<div id="block3" class="block no-gutters col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
        <a href="<?=$url_base_lang?>/metodo">
        <img src="//www.eficaciapsicologica.com/files/pictures/albums/3/202005120631422225-mett.png">
        </a>
        <div class="caption size2 white">Método<br><span>Retos, herramientas y soporte</span></div>
</div>

<div id="block4" class="block no-gutters col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
        <a href="<?=$url_base_lang?>/stay-connected">
	<div class="title">EN LAS REDES SOCIALES</div>	
        <img src="//www.eficaciapsicologica.com/files/pictures/albums/3/202005110217335155-.jpg">
        </a>
</div>



</div>
</div>
