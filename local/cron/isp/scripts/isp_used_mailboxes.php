<?php
include "setup.php";

$update="update kms_isp_hostings set used_mailboxes=(select count(*) from kms_isp_mailboxes where vhost_id in (select id from kms_isp_hostings_vhosts where hosting_id=kms_isp_hostings.id))";
mysqli_query($dblink_cp,$update);
mysqli_close($dblink_cp);
echo "...cp 100%...tartarus ";
mysqli_query($dblink_erp,$update);
mysqli_close($dblink_erp);
echo "100%\n";

?>
