<div class="pagina col-12 col-sm-12 col-md-6 col-lg-8" style="margin:auto">
<div class="article_body">

<h1><?=$page['title_'.$_GET['l']]?></h1>


<div id="subscribe">
  <p>
  <form>

<div class="row col-12 col-sm-12 col-md-6 col-lg-8 nomargins">
<div class="col-12 col-sm-12 col-md-6 col-lg-6" style="margin:auto">
  <span class="cap"><?=$ll['name']?><br></span>
<input class="classic" name="name" id="name" type="text" style="margin-bottom:10px"><br>
</div>

<div class="col-12 col-sm-12 col-md-6 col-lg-6" style="margin:auto">
 <span class="cap"><?=$ll['surname']?><br></span>
<input class="classic" name="surname" id="surname" type="text" style="margin-bottom:10px"><br>
</div> 
</div>
  
  <span class="cap"><?=$ll['email']?><br></span>
  <input class="classic" name="email" id="email" type="text" value="<?=$_GET['email']?>"><br>
<br>  <p><input id="checkbox" name="checkbox" type="checkbox" style="margin:0px"><span style="font-size:14px">&nbsp;<?=$ll['lopd']?></span></p>
  <input type="button" value="<?=$ll['send']?>" onclick="subscribeNews2($('#name').val(),$('#surname').val(),$('#email').val(),$('#checkbox').prop('checked'),'<?=$_GET['l']?>','<?=str_replace("'","`",$ll['thanksSubscribe'])?>')"><br><br>
  </form>

</div>

<div class="small greybox"><a name="lopd"></a><?=$page['body_'.$_GET['l']]?></div>


</div>
</div>
