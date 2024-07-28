<?
if ($error=="Bad login") { ?> <center><?=$ll['invalid_login'];?></center> <? }
if ($_POST['action']=="forgot_sent") echo "<center>".$ll['password_sent']."</center>";

?>

<div id="login">

<img src="<?=$url_base?><?=$conf['logo']?>" border=0>

<form id="form" method="post">

<div class="loginbox">
<input type="hidden" name="action" id="action" value="login">
<?=$ll['username']?>:<br><input type="text" name="username"><br>
<?=$ll['password']?>:<br><input type="password" name="password"></br>
<input class="button" type="submit" value="<?=$ll['login']?>"><br>
<a href="#" class="link" type="button" onclick="$('#action').val('register');$('#form').submit();"><?=$ll['register']?></a> <span style="color:#ccc">|</span> <a href="#" class="link" style="margin-top:5px" type="button" onclick="$('#action').val('asguest');$('#form').submit();"><?=$ll['asguest']?></a><br>
<a href="#" class="link" style="margin-top:5px" type="button" onclick="$('#action').val('forgot');$('#form').submit();"><?=$ll['forgot']?></a>

</form>
</div>

</div>
