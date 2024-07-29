<?
include "../config/setup.php";
include "dbconnect.php";
if ($_POST['l']=="ca") $_POST['l']="ct";
//check if exists
$_POST['email']=trim(strtolower($_POST['email']));
$sel="select status,newsletter,email from kms_ent_contacts where email='".$_POST['email']."'";
$res=mysqli_query($dblink,$sel);
$row=mysqli_fetch_assoc($res);
if ($row['email']==$_POST['email']) {
	if ($row['newsletter']!="1") { //update

	$update="update kms_ent_contacts set newsletter=1 where email='".$_POST['email']."'";
	$res=mysqli_query($dblink,$update);

	} else {
		//nothing already exists
	}
} else {

	$insert="insert into kms_ent_contacts (name,surname,email,newsletter,status,creation_date,language) values (\"".trim(ucwords(strtolower($_POST['name'])))."\",\"".trim(ucwords(strtolower($_POST['surname'])))."\",\"".$_POST['email']."\",'1','active','".date('Y-m-d H:i:s')."','".$_POST['l']."')";
	$res=mysqli_query($dblink,$insert);
	if (!$res) echo "something went wrong\n".$insert; else echo "Added new address to the newsletter";
}

?>
