<div id="menu_mobile" class="icon mobile">
        <div class="group_buttons">
                <button type="button" class="navbar-toggle openbn" data-toggle="collapse" data-target=".navbar-collapse" onclick="openNav()">
                <span class="sr-only"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
        </div>

        <div id="mySidebar" class="sidebar">
          <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
          <? $mobile="_mobile";include "buscador.php"; ?>
          <? // include "language_selector.php"; ?>
          <? if ($_SESSION['username']!="guest"&&$_SESSION['username']!="") { ?><a href="<?=$url_base_lang?>/myaccount"><?=$ll['myaccount']?></a><? }
          $i=1;foreach ($menu_options as $option) {?>
          <a href="<?=$url_base_lang?>/<?=urlize($lang[$option['name']])?>" class="level1 item<?=$i?> <?=$quin?>"><span class="bg"><?=$lang[$option['name']]?></span></a>
          <? $i++;
          } ?>

<? /*     <a href="<?=$url_base_lang?>/?action=logout"><?=$ll['logout']?></a>*/?>
<?/*        <div class="desktop_only right mini"><div><?=$_SESSION['username']?></div></div>*/?>

      </div>
</div>
