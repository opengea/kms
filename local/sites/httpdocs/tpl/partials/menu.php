<?
   //load menu
   $sel=mysqli_query($dblink,"select * from kms_sites_menus where status='1'");
   $menu=mysqli_fetch_assoc($sel);
   $sel=mysqli_query($dblink,"select * from kms_sites_menus_options where status='1' and menu_id=".$menu['id']." order by sort_order asc");
   $num_opt=mysqli_num_rows($sel);
   $menu_options=array();
   while ($option=mysqli_fetch_assoc($sel)) {
	array_push($menu_options,$option);
   }

?>
<ul class="menu">
<? 
$i=1;$quin="first"; 
foreach ($menu_options as $option) {
   $permalink=urlize($lang[$option['name']]);
   if ($_GET['s']==$permalink) $addclass=" selected"; else $addclass=""; ?>
   <li class="level1 item item<?=$i?> <?=$quin?><?=$addclass?>" onmouseover="$('header.<?=$class?> ul.submenu').hide();$('header.<?=$class?> ul.submenu<?=$i?>').css('display','inline-table');"><a href="<?=$url_base_lang?>/<?=$permalink?>" class="level1 item<?=$i?> <?=$quin?>"><span class="bg"><?=$lang[$option['name']]?></span></a>
<?  if ($quin=="first") $quin="";
    //add possible submenu
    $res2=mysqli_query($dblink,"select * from kms_sites_menus where status='1' and parent_menu=".$menu['id']." and parent_opt=".$option['id']);
    $submenu=mysqli_fetch_assoc($res2);
    $has=mysqli_num_rows($res2);
    if ($has) {?>
    <ul class="submenu submenu<?=$i?>" style="display:none" onmouseout="$(this).hide();">
<?
   $res2=mysqli_query($dblink,"select * from kms_sites_menus_options where status='1' and menu_id=".$submenu['id']." order by sort_order asc");
   $sub_num_opt=mysqli_num_rows($res2);
   $submenu_options=array();
   while ($sub_option=mysqli_fetch_assoc($res2)) {
	if ($sub_option['permalink']=="") $sub_option['permalink']=urlize($lang[$sub_option['name']]);
        array_push($submenu_options,$sub_option);
   }
  $j=1;$addclass="";$quin="";
  if ($sub_num_opt) {
	foreach ($submenu_options as $sub_option) {?>
	<li class="level2 item item<?=$j?> <?=$quin?><?=$addclass?>"><a href="<?=$url_base_lang?>/<?=$sub_option['permalink']?>" class="level2 item<?=$j?> <?=$quin?>"><span class="bg"><?=$lang[$sub_option['name']]?></span></a></li>


<?	}
  }?>
  </ul>
  <?
  }
   $i++;
    if ($i==$num_opt) $quin="last";

  ?></li><?

} 
?>
<hr>
</ul>
