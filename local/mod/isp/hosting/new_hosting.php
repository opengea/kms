<?
include "/usr/local/kms/lib/mod/shared/db_links.php";
include "getdata.php";
if ($_POST['activate']==1) {
	if ($_GET['id']!="") {
		$hosting=$this->dbi->get_record("select * from kms_isp_hostings WHERE id=".$_GET['id'],$dblink_cp);
		$type=$hosting['type'];
	} else {
		$type=$_POST['type'];
	}
        if ($type=="Cloud Hosting"||$type=="Multidomain Cloud Hosting"||$type=="ch") {
                include "ch_manage.php";
        } else if ($type=="Virtual Private Server (VPS)"||$type=="vh") {
            //    $this->_error("",_KMS_GL_UNDER_CONSTRUCTION,"fatal");
                include "vh_manage.php";
        } else if ($type=="Dedicated Server"||$type=="dh") {
                //$this->_error("",_KMS_GL_UNDER_CONSTRUCTION,"fatal");
                include "dh_manage.php";
        }

} else {
	include "hosting_selector.php";
}
