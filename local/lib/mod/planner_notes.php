<?

// ----------------------------------------------
// Class Planner Notes for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class planner_notes extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_planner_notes";
	var $key	= "id";	
	var $fields = array("creation_date", "status", "type", "note");
	var $title = "Notes";
	var $notedit= array('dr_folder');
	var $orderby = "creation_date";

        /*=[ PERMISSIONS ]===========================================================*/


       //*=[ CONSTRUCTOR ]===========================================================*/
        function planner_notes ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->humanize("dr_folder","Carpeta");
		$this->humanize("related","Tema");
		$this->humanize("note","Nota");
		$this->humanize("author","Autor");
		$this->humanize("attachment","Adjunt");
	
		$this->defvalue("status","normal");
		$this->defvalue("priority","normal");
		//date_default_timezone_set('UTC');
		//$uploadDate = date('D j M Y');
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);

		$this->default_content_type = "notes";
		$this->default_php = "notes.php";
		$this->insert_label = "Nova nota";

		$this->setComponent("checklist","mailing_publish",array("Y"=>"Si","N"=>"No"));
		$this->setComponent("uniselect","related");
	}

}
?>
