<?

// ----------------------------------------------
// Class ISP Backups for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_backups extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_isp_backups";
	var $key	= "id";	
	var $fields = array("creation_date","data","name","type","bytes");
	var $readonly = array("vhost_id");
	var $orderby = "creation_date";
	var $sortdir = "desc";
	var $notedit=array("bytes","data_server_id","backup_server_id","type","data","name","vhost_id","creation_date");
//	var $hidden=$this->notedit;

        /*=[ PERMISSIONS ]===========================================================*/

	var $can_view = false;
	var $can_edit = false;
	var $can_delete = false;
	var $can_add        = false;
	var $can_import = false;
	var $can_export = false;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_backups($client_account,$user_account,$dm) {

		$this->page_rows = 100;
		$this->sum = array("bytes");
                $select="SELECT * FROM kms_isp_clients where sr_user=".$user_account['id'];
                $result=mysqli_query($this->dblinks['client'],$select);
                if (!$result) die(mysqli_error($result));
                $client=mysqli_fetch_array($result);

		$this->where = "sr_client=".$client['sr_client']." and id=".$_GET['xid'];
                if ($this->_group_permissions(1,$user_account['groups']))  {
                        $this->readonly=array();
                } else if ($this->_group_permissions(3,$user_account['groups'])) {
                } else  {
			if ($client['sr_client']=="") $this->_error("","You don't have admin privileges.","fatal");
//                        $this->fields = array("postbox","mailname","status","name","hosting_id");
                        if ($_GET['_']=='b') $_GET['id']=$client['id'];
                }
		if ($_GET['xid']=="") die("'xid' param missing.");

		$sel="select * from kms_isp_hostings_vhosts where id=".$_GET['xid'];
                $res=mysqli_query($this->dblinks['client'],$sel);
                $vhost=mysqli_fetch_array($res);
		$this->where = "vhost_id='".$vhost['id']."'";
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
                $sel="select name from kms_isp_hostings_vhosts where id=".$_GET['xid'];
                $res=mysqli_query($this->dblinks['client'],$sel);
                $vhost=mysqli_fetch_array($res);
		include "/usr/local/kms/tpl/panels/isp_backups.php";
		//$this->humanize("sr_contract","Contract #");
                $this->setComponent("bytes","bytes");
	}


}
?>
