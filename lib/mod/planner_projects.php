<?

// ----------------------------------------------
// Class Planner Projects for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class planner_projects extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_projects";
	var $key	= "id";	
	var $fields = array("id", "name", "status", "contacts", "start_date", "end_date","cost","attachment");
	var $title = "Projectes";

       //*=[ CONSTRUCTOR ]===========================================================*/

        function planner_projects ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		$this->humanize("dr_folder","Carpeta");
		$this->humanize("final_date","Data finalitzaci&oacute;");
		$this->humanize("description","Descripci&oacute;");
		$this->humanize("satisfaction","Grau de satisfacci&oacute;");

		$this->humanize("notes","Notes");
		$this->humanize("related","En relaci&oacute; a");
		$this->humanize("priority","Prioritat");
		$this->humanize("status","Estat");

		$this->defvalue("priority","normal");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->defvalue("satisfaction","no avaluat");

		$this->default_content_type = "projects";
		$this->default_php = "projects.php";

		$this->insert_label = "Nou projecte";

	}
}

?>

