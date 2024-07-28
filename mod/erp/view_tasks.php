<?php

include "/usr/local/kms/lib/dbi/db_localhost_connect.php";
	$result = mysqli_query($dblink_local,"SELECT sr_client FROM kms_ent_clients WHERE id='".$_GET['id']."'");
        if (!$result) {echo "error ".mysqli_error();exit;}
        $client = mysqli_fetch_assoc($result);
	$result = mysqli_query($dblink_local,"SELECT name FROM kms_ent_contacts where id=".$client['sr_client']);
	$client = mysqli_fetch_assoc($result);
//echo "https://intranet.intergrid.cat/?app=erp&_=b&erp_contracts&queryfield=sr_client&query=".urlencode($client['name']);exit;
echo "<script>document.location='https://intranet.intergrid.cat/?app=planner&_=b&mod=planner_tasks&queryfield=sr_client&query=".urlencode($client['name'])."';</script>";
