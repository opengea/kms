<div id="ex<?=$author['id']?>" class="modal"><div class="row"><div class="col-6 col-sm-6 col-md-4 col-lg-4"><?
if ($author['picture']=="") $author['picture']="none.png"; 
	   ?><img src="/files/catalog/cat_autors/picture/<?=$author['picture']?>" style="min-height:150px;width:100%;padding-bottom:20px"></div><div class="col-6 col-sm-6 col-md-8 col-lg-8"><span style="text-transform:uppercase"><?=$author['name']?></span><br><? 

$weblnk=str_replace("https://","",str_replace("http://","",$author['link']));
if ($author['social']!="") { ?><span style="color:#999"><a style="color:#000" href="https://www.twitter.com/<?=str_replace("@","",$author['social'])?>" target="_blank"><?=$author['social']?></a></span><br><? } 
if ($author['link']!="") { ?><a href="<?=$author['link']?>" target="_blank"><?if ($author['link_name']!="") echo $author['link_name']; else echo $weblnk; ?></a><br> <? } 

if ($author['social']==""&&$author['link']!="")  { ?>&nbsp;&nbsp;<a href="<?=$author['link']?>" target="_blank"><?if ($author['link_name']!="") echo $author['link_name']; else echo $weblnk; ?></a> <? } ?><div style="padding-top:10px;"><?=$author['bio_'.$_GET['l']]?></div></div></div><a href="#" rel="modal:close"></a></div>
