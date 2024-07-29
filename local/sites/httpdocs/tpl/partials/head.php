<? $language = array ("ca"=>"cat","es"=>"es");//,"en"=>"en"); ?>
<?/*?>
<div class="top no-gutters">
<div class="col-12 col-sm-12 col-md-12 col-lg-11 col-xl-8" style="margin:auto">

        <div class="bt-nav-top-bar left">
	<span>
	<i class="fas fa-phone-alt"></i>&nbsp;&nbsp; <a href="tel:<?=str_replace("-","",$ll['_TELEFONO'])?>"><?=$ll['_TELEFONO']?></a>
	<span class="spacer"></span>
	<i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp; <a href="<?=$ll['_LINK_GOOGLE_MAPS']?>" target="_blank"><?=$ll['_BUSINESS_ADDRESS']?></a>
	</span>
	</div>

	<div class="bt-nav-top-bar right">
                <div class="languageSelector">
                  <? include "language_selector.php"; ?>
                </div>

		<div class="social_buttons">
			<ul>
			<li><a title="Youtube" href="<?=$ll['_YOUTUBE_LINK']?>" target="_blank"><i class="fab fa-youtube"></i></a></li>
                        <li><a title="Instagram" href="<?=$ll['_INSTA_LINK']?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
                        <li><a title="Facebook" href="<?=$ll['_FB_LINK']?>" target="_blank"><i class="fab fa-facebook"></i></a></li>
			</ul>
		</div>

	</div>
</div>
</div>
<? */ ?>
<header class="normal">

<div class="row head no-gutters col-12 col-sm-12 col-md-12 col-lg-11 col-xl-8 col-xxl-7">
	<div id="logo" class="col-8 col-sm-9 col-md-4 col-lg-3 col-xl-3">
		<a href="<?=$url_base_lang?>">
		<div class="logo"><img src="<?=$conf['logo']?>"></div>
		</a>
	</div>
	<div id="menu_desktop" class="col-0 col-sm-0 col-md-7 col-lg-8 col-xl-8">	
	<? $class="normal";include "menu.php"; ?>
	</div>

	<div id="menu_options" class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1">
	<? include "menu_mobile.php"; ?>
	<? include "buscador.php"; ?>
	<? //include "shopping_cart.php";?>
	</div>
</div>
</header>
<header class="invert">
<div class="row head no-gutters col-12 col-sm-12 col-md-12 col-lg-11 col-xl-8 col-xxl-7">
        <div id="logo" class="col-8 col-sm-9 col-md-4 col-lg-3 col-xm-3">
                <a href="<?=$url_base_lang?>">
                <div class="logo invert"><img src="<?=$conf['logo']?>"></div>
                </a>
        </div>
        <div id="menu_desktop" class="col-0 col-sm-0 col-md-7 col-lg-8 col-xl-8">
        <? $class="invert";include "menu.php"; ?>
        </div>

        <div id="menu_options" class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1">
	<? include "menu_mobile.php"; ?>
        <? include "buscador.php"; ?>
        <? //include "shopping_cart.php";?>
        </div>
</div>
</header>

<div id="header-bg" style="background-repeat:no-repeat;background-image:url('<?=$url_base?>/files/pictures/albums/3/<?=$bg[$_GET['s']]?>')">
<div class="title"><h3><?=$ll[$page['title']]?></h3></div>
</div>
