<?
include "setup.php";

run($dblink_cp);
mysqli_close($dblink_cp);
echo "...cp 100%...tartarus ";
run($dblink_erp);
mysqli_close($dblink_erp);
echo "100%\n";


function run($dblink) {

		$update = "update kms_isp_hostings set used_vhosts=(select count(*) from kms_isp_hostings_vhosts where hplan_id=kms_isp_hostings.id)";
		$result=mysqli_query($dblink,$update);
		if (!$result) die('error updating database '.$update);
}
	


?>
