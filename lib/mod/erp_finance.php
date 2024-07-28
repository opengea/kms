<?

// ----------------------------------------------
// Class ERP Finance for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class erp_finance extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_erp_finance";
	var $key	= "id";	
	var $fields 	= array("id","family", "concept", "entity", "import", "type", "periodicitat","attachment");
        var $title 	= "Moviments";
	var $orderby 	= "import";
	var $sortdir 	= "desc";

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_view 	= true;
        var $can_edit 	= true;
        var $can_delete = true;
        var $can_add  	= true;
        var $can_import = false;
        var $can_export = true;
        var $can_search = true;
	var $can_duplicate = true;
       //*=[ CONSTRUCTOR ]===========================================================*/
        function erp_finance($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->sum = array("import");
		$this->folder = $_GET['folder'];
		//$notedit = array("type");
		$title = "Moviments";
		$this->defvalue("status","pending");
		$this->defvalue("content_type","billing");
			$this->default_content_type = "billing";
		$this->default_php = "billing";

		//date_default_timezone_set('UTC');
		//$uploadDate = date('D j M Y');
		$uploadDate = date('Y-m-d');
		$this->defvalue("date",$uploadDate);
		$this->insert_label = "Nou moviment";
		$this->setComponent("wysiwyg","notes",array("type"=>"full"));
		$this->setComponent("select","bill",array("yes"=>"yes","no"=>"no"));
		$this->setComponent("select","status",array("payed"=>"<font color='#00aa00'>cobrat</a>","pending"=>"<font color='#aa0000'>pendent</a>"));
		$this->setComponent("select","type",array("fixed"=>"fix","variable"=>"variable"));
		// SELECT permet seleccionar multiples valors d'una llista de valors unics
		// si la llista es fize, posar el segon parametre a true
		$this->setComponent("uniselect","family");
		$this->setComponent("uniselect","entity");
		// CHECKBOX
		//$this->setComponent("checklist","Decoration",array("E"=>"Embroiderable","I"=>"Inscribeable"));

		// uploads
		$this->setComponent("file","attachment",array($this->kms_datapath."/files/finance","files/finance",false));
	}

}
?>
