<h1><?=$ll['myaccount']?></h1>

<? 


if ($_GET['action']=="confirm") { 

$del="delete user where id='{$user['id']}'";
$res=mysqli_query($dblink,$del);

session_destroy();

?>
<p><?=$ll['account_deleted']?></p>
<?

} else { ?>

<p><?=$ll['cancel']?> <a href="<?=$url_base?>/delete&action=confirm"><?=$ll['click_here']?></a></p>

<? } ?>
