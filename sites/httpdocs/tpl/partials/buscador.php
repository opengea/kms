<div id="buscador" class="icon desktop">
<? if ($_POST['searchword']!="") $searchword=$_POST['searchword']; else $searchword=$ll['search']."...";?>
<span id="search_button" onclick="$('div#searchbox').toggle()"><i class="fa fa-search"></i></span>
<? $mobile=""; ?>
</div>
