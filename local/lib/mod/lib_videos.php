<?

// ----------------------------------------------
// Class Docs Videos for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class lib_videos extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_lib_videos";
	var $key	= "id";	
	var $fields = array("file", "thumbnail", "title", "category", "creation_date");
	var $orderby = "creation_date";
	var $notedit = array("dr_folder");

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_view = false;
        var $can_edit = true;
        var $can_delete = true;
        var $can_add   = true;
        var $import = false;
        var $export = false;
        var $search = true;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function lib_videos ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

       //*=[ SETUP ]===========================================================*/

        function setup($client_account,$user_account,$dm) {

		$this->setComponent("uniselect","category");
		$this->defvalue("status","active");
		$this->defvalue("priority","normal");
		$uploadDate = date('Y-m-d');
		$this->defvalue("creation_date",$uploadDate);
		$this->insert_label = _NEW_VIDEO;
		$this->default_content_type = "videos";
		$this->setComponent("file","file",array($this->kms_datapath."files/videos","files/videos"));
		$this->setComponent("picture","thumbnail",array("path"=>"/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/files/pictures","url"=>"http://data.".$this->current_domain."/files/pictures","resize_max_width"=>360,"resize_max_height"=>230,"thumb_max_width"=>120,"thumb_max_height"=>90));
	}

}
?>
