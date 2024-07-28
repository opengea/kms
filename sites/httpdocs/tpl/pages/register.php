<div id="login">

<a href="<?=$url_base?>"><img src="<?=$url_base?><?=$conf['logo']?>" border=0></a>

<form id="form" method="post">
<input type="hidden" name="action" id="action" value="signin">
<?=$ll['name']?>:<br><input type="text" name="username"><br>
<?=$ll['email']?>:<br><input type="text" name="email"><br>
<?=$ll['password']?>:<br><input type="password" name="password"></br>
<input class="button" type="submit" value="<?=$ll['register']?>"><br><br>

</form>


</div>
