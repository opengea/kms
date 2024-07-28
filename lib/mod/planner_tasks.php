<?

// ----------------------------------------------
// Class Planner Tasks for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class planner_tasks extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_planner_tasks";
	var $key	= "id";	
	var $fields = array("id", "priority", "status", "category", "sr_client", "description", "notes", "assigned","billing_amount","creation_date");
	var $notedit = array("invoice_pending","contact_name","contact_mail","contact_phone","related_product","file","creation_time","dr_folder","sr_user","scope","type");
	var $hidden = array("sort_order","invoice_pending","related_product","creation_date","creation_time","sr_user","scope","file","type");
	var $title = "Tasques";
	var $orderby = "id";
	var $sortdir = "desc";
	var $insert_label = _NEW_TASK;
//        var $owclick = "drag"; //"edit"; //need $this->uid=$this-key; on setup()

        /*=[ PERMISSIONS ]===========================================================*/

	var $can_view = false;
	var $can_edit = true;
	var $can_delete = true;
	var $can_add   = true;
	var $can_import = false;
	var $can_export = false;
	var $can_search = true;
        var $can_print  = true;
	var $can_duplicate = true;
	
       //*=[ CONSTRUCTOR ]===========================================================*/
        function planner_tasks ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
                // set draggable
                $this->uid=$this-key;
                $this->rowclick = "drag"; //"edit"; //need $this->uid=$this-key; on setup(), and orderby="sort_order"
                //$this->orderby="sort_order";
//		$this->uid=$this->key; //required for rowclick
        	if (!$this->_group_permissions(1,$user_account['groups'])) {
                $this->where = "(assigned='".$user_account['id']."' or assigned='')";
        	}

	$this->setComponent("xcombo","sr_client",array("xtable"=>"kms_ent_contacts","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
	$this->setComponent("xcombo","assigned",array("xtable"=>"kms_sys_users","xkey"=>"id","xfield"=>"username","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
	$this->setComponent("select","origin",array("1"=>"Tel&egrave;fon","2"=>"Ticket/email","3"=>"Presencial","4"=>"Intern"));
        $this->setComponent("uniselect","type");
	$this->humanize("origin","Origen");	
	$this->defvalue("origin",2);
	$this->humanize("start_date","Data d'inici");
	$this->humanize("billing_amount","Import");
	$this->humanize("worktime","Temps invertit");
	$this->defvalue("sr_client",1);
	$this->humanize("finalization_date","Data de finalitzaci&oacute; real");
	$this->defvalue("category","Suport");
	$this->defvalue("status","pendent");
	$this->defvalue("priority","1");
	if ($_GET['_']=="b") { $this->setComponent("select","status",array("pendent"=>"<font color=#ff0000>"._KMS_GL_STATUS_PENDING."</font>","en_proces"=>"<font color=#ff00ff><b>"._KMS_GL_STATUS_IN_PROCESS."</b></font>","espera"=>"<font color=#620>A l'espera</font>","aturat"=>"<font color=#666666>"._KMS_GL_STATUS_ATURAT."</font>","facturable"=>"<font color=#00DD00><b>** FACTURAR **</b></font>","finalitzat"=>"<font color=#00DD00><b>"._KMS_GL_STATUS_FINISHED."</b></font>","descartat"=>"Descartat")); }  else {
	$this->setComponent("select","status",array("pendent"=>"<font color=#ff0000>"._KMS_GL_STATUS_PENDING."</font>","en_proces"=>"<font color=#ff00ff><b>"._KMS_GL_STATUS_IN_PROCESS."</b></font>","espera"=>"<font color=#662200>A l'espera</font>","aturat"=>"<font color=#666666>"._KMS_GL_STATUS_ATURAT."</font>","facturable"=>"<font color=#00DD00><b>** FACTURAR **</b></font>","finalitzat"=>"<font color=#00DD00><b>"._KMS_GL_STATUS_FINISHED." (no facturar)</b></font>","descartat"=>"Descartat")); }
	$this->setComponent("select","category",array("0-kms"=>"Desenvolupament KMS","1-support"=>"Suport","2-works"=>"Enc&agrave;rrecs clients","3-domains"=>"Registres","4-gestio"=>"Gesti&oacute;","5-corp"=>"Empresa","6-sysadmin"=>"Sistemes"));
	$uploadDate = date('Y-m-d H:i:s');
	$this->defvalue("creation_date",$uploadDate);
	$this->defvalue("start_date",date('Y-m-d H:i:s'));
	$this->defvalue("final_date",$uploadDate);
	
	$this->defvalue("assigned",$_SESSION['user_id']);
	$this->defvalue("satisfaction","no avaluat");
	$this->default_content_type = "task";
	$this->default_php = "tasks.php";
//	$this->setComponent("uniselect","assigned");
	$this->setComponent("select","priority",array("0"=>"<font color=#555>baixa</font>", "1"=>"<font color=#0000aa>normal</font>","2"=>"<font color=#FF0000>alta</a>","3"=>"<font color=#ff0000><b>cr&iacute;tica</b></font>"));
//	$this->styleRow=array("field"=>"priority","styles"=>array("0"=>"background-color:#eee", "1"=>"","2"=>"background-color:#FFEFDF","3"=>"background-color:#FFBFAF"));
	$this->styleRow=array("rule"=>"styleRowRule","styles"=>array("0"=>"background-color:#eee", "1"=>"","2"=>"background-color:#FF9B88","3"=>"background-color:#FF6666","espera"=>"background-color:#fe0"));
        $this->onUpdate = "onUpdate";
	$this->onInsert = "onInsert";
	$this->humanize("scope","Causa");
	$this->setComponent("select","scope",array("1"=>"Client","2"=>"Intergrid","3"=>"Externa"));
	if ($_GET['_']=="i") array_push($this->notedit,"finalization_date"); 
	$this->setValidator("description","notnull");
	$this->setValidator("billing_amount","numeric");
	$this->defvalue("billing_amount","0");
	$this->humanize("notes","Notes internes");
	$this->setComponent("wysiwyg","notes",array("type"=>"full"));	
	$this->setComponent("wysiwyg","description",array("type"=>"full"));
	$this->humanize("description","Concepte");

}

        function styleRowRule($record) {
                if ($record->status=='espera') return 'espera'; else return $record->priority;
        }

	function onUpdate($post,$id) {
		//es on AFTER update...
		//$select="SELECT * from kms_planner_tasks where id={$id}";
		//$result=mysqli_query($this->dblinks['client'],$select);	
		//$current_task=mysqli_fetch_array($result);
		//echo "post".$post['status']." current:".$current_task['status'];
		if (($post['status']=="finalitzat"||$post['status']=="facturable")&&$post['finalization_date']=="0000-00-00 00:00:00") {
                $update="UPDATE kms_planner_tasks SET finalization_date='".date('Y-m-d H:i:s')."',priority=0 WHERE id={$id}";
		$result=mysqli_query($this->dblinks['client'],$update);
		$user=$this->dbi->get_record("select * from kms_sys_users where id=".$post['assigned']);
		$from=$user['email'];
		$to="sistemes@intergrid.cat";
		if (!$result) die('error'.mysqli_error()."<br><br>SQL:".$update);
		$this->emailNotify("[KMS Planner] Tasca finalitzada","La tasca #<b>$id</b> \"".$this->u2h($post['description'])."\" ha estat finalitzada.",$from,$o);
		}
	}

	function onInsert($post,$id) {
        	if ($post['status']=="finalitzat") {
                $update="UPDATE kms_planner_tasks SET finalization_date='".date('Y-m-d H:i:s')."',priority=0 WHERE id={$id}";
                $result=mysqli_query($this->dblinks['client'],$update);
                if (!$result) die('error'.mysqli_error()."<br><br>SQL:".$update);
                }
        }

}
?>
