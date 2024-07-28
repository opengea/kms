<h1><?=$ll['myaccount']?></h1>

<?

        //retrieve user data
        $sel="select id,password,username,email,privileges from users where username=\"".$_SESSION['username']."\"";
        $res=mysqli_query($dblink,$sel);
        $user=mysqli_fetch_assoc($res);
        $user['privileges']=explode(",",$user['privileges']);
?>

<form method="post">
<?=$ll['username']?>:<br>
<input type="text" name="username" value="<?=$user['username']?>"><br>
<br><?=$ll['email']?>:<br>
<input type="text" name="email" value="<?=$user['email']?>"><br>
<br><?=$ll['password']?>:<br>
<input type="password" name="password" value="<?=$user['password']?>"><br>
<br>
<input type="submit" value="<?=$ll['save_changes']?>">
</form>
<br>
<?
 if ($_POST['username']!=""&&$_POST['email']!=""&&$_POST['password']!="") { 
$_SESSION['username']=$_POST['username'];
$update="update users set username=\"".$_POST['username']."\",email=\"".$_POST['email']."\",password=\"".$_POST['password']."\" where id=".$user['id'];
$res=mysqli_query($dblink,$update);
if ($res) echo $ll['updated_successfuly'];

}?>
<p><?=$ll['to_delete_your_account']?> <a style="font-size:13px" href="<?=$url_base?>/delete"><?=$ll['click_here']?></a></p>
<br>
