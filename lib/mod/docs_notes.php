<?

// ----------------------------------------------
// Class Planner Notes for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class docs_notes extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_docs_notes";
	var $key	= "id";	
	var $fields = array("creation_date", "modified_at", "type", "title", "note","user_id","group_id","private");
	var $title = "Notes";
	var $notedit= array('');
	var $orderby = "modified_at";
	var $sortdir = "desc";
	var $readonly = array("user_id");	
	var $hidden = array("status","tags","user_id","modified_at");
        /*=[ PERMISSIONS ]===========================================================*/


       //*=[ CONSTRUCTOR ]===========================================================*/
        function docs_notes ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->humanize("dr_folder","Carpeta");
		$this->humanize("related","Tema");
		$this->humanize("note","Nota");
		$this->humanize("author","Autor");
		$this->humanize("attachment","Adjunt");
		$this->humanize("modified_at","Darrera modificació");
		$this->setComponent("file","attachment",array($this->kms_datapath."files/notes","files/notes",true));
	
		$this->defvalue("status","normal");
		$this->defvalue("priority","normal");
		//date_default_timezone_set('UTC');
		//$uploadDate = date('D j M Y');
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->setComponent("wysiwyg","note",array("type"=>"full"));
		$this->default_content_type = "notes";
		$this->default_php = "notes.php";
		$this->insert_label = "Nova nota";
		$this->humanize("group_id","Grup");
		$this->setComponent("checklist","private",array(1=>""));

		$this->setComponent("uniselect","type");
		$this->setComponent("xcombo","group_id",array("xtable"=>"kms_sys_groups","xkey"=>"id","xfield"=>"name","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));
		$this->setComponent("xcombo","user_id",array("xtable"=>"kms_sys_users","xkey"=>"id","xfield"=>"username","readonly"=>false,"linkcreate"=>true,"linkedit"=>true,"sql"=>""));



		$this->where = "(((";
		$grups=explode(",",$user_account['groups']);
		 foreach ($grups as $g) {
		 $this->where .= "group_id=".$g." or ";
		}
		$this->where=substr($this->where,0,strlen($this->where)-4);
		$this->where .= ") and (private is null or private=0)) or (user_id=".$user_account['id']." and private=1))";


		$this->defvalue("group_id",$grups[0]);
		$this->defvalue("user_id",$user_account['id']);

		if ($_GET['id']!="") $this->where .= " and id=".$_GET['id'];

                if ($_GET['id']!="") {
                $result=$this->dbi->query("select id from kms_docs_notes where ".$this->where);
                $row = $this->dbi->fetch_row($result);
		if ($row[0]=="") header('location:/?app='.$_GET['app']."&mod=docs_notes");
		}


                $this->onPreInsert = "onPreInsert";
                $this->onPreUpdate = "onPreUpdate";


	}

        function onPreInsert($post,$id) {
		$post['modified_at']=date('Y-m-d H:i:s');
		return $post;
	}
	function onPreUpdate($post,$id) {
                $post['modified_at']=date('Y-m-d H:i:s');
		return $post;
        }
}
?>
