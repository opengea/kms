<?
session_start();

// LOGIN

if ($_POST['action']=="login"&&$_POST['username']&&$_POST['password']) {
	$sel="select * from users where username=\"".$_POST['username']."\" and password=\"".$_POST['password']."\"";
	$res=mysqli_query($dblink,$sel);
	$user=mysqli_fetch_assoc($res);
	$user['privileges']=explode(",",$user['privileges']);
	if ($user['id']!="") {
		//login
		 $_SESSION['username']=$_POST['username']; 
	} else {
		 $error="Bad login";
	}
} else if ($_POST['action']=="asguest") {
	$_SESSION['username']="guest";
	$user=array();

} else if ($_POST['action']=="signin") {
	$insert="insert into users values ('',\"".$_POST['username']."\",\"".$_POST['password']."\",'".date('Y-m-d H:i:s')."','editor','".date('Y-m-d H:i:s')."','".$_POST['email']."')";
	$res=mysqli_query($dblink,$insert);
	$_GET['s']="login";

} else if ($_POST['action']=="forgot_sent"&&$_POST['email']!="") {
	//retrieve user data
        $sel="select password,email from users where email=\"".$_POST['email']."\"";
        $res=mysqli_query($dblink,$sel);
        $user=mysqli_fetch_assoc($res);
	if ($user['email']!="") {
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'From: argument <argument@intergrid.cat>' . "\r\n";
        $from="argument@intergrid.cat";
        $to=$user['email'];
        $subject.=$ll['password_recover'];
	$body="<br><br>".$ll['your_password_is']."<b>".$user['password']."</b><br><br>{argument}";
        $body="<span style='font-family:monospace;font-size:12px'>".$body."</span>";
        mail($to, $subject, $body, $headers, "-f {$from}");
	}
	$_GET['s']="login";
  //      $showhead=false;
        $page_with_no_login=true;

} else if ($_POST['action']!="") {
//	$_GET['s']=$_POST['action'];
//	$showhead=false;
	$page_with_no_login=true;
} else if ($_SESSION['username']!="") {
	//retrieve user data
        $sel="select id,username,email,privileges from users where username=\"".$_SESSION['username']."\"";
        $res=mysqli_query($dblink,$sel);
        $user=mysqli_fetch_assoc($res);
        $user['privileges']=explode(",",$user['privileges']);
} 

if ($_GET['action']=="logout") { session_destroy(); header('location:'.$url_base); }

if ($_SESSION['username']==""&&!$page_with_no_login) {$showhead=false; $_GET['s']="login"; }

?>
