<?php
include "setup.php";
purge($dblink_cp);
mysqli_close($dblink_cp);
purge($dblink_erp);
mysqli_close($dblink_erp);

function purge($dblink) {
        //eliminem registres anteriors a 30 dies... 
        //la resta les deixem per si cal regenerar estadistiques
        $delete = "DELETE kms_isp_hostings_vhosts_log WHERE date<'".date('Y-m-d', strtotime("-12 month"))."'";
        $result=mysqli_query($dblink,$delete);
}
?>
