<?

// ----------------------------------------------
// Class ERP Finance for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class erp_accounting_plans extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

	var $table	= "kms_erp_accounting_plans";
	var $key	= "id";	
	var $fields 	= array("id", "creation_date", "description");
	var $orderby 	= "id";
	var $sortdir 	= "asc";

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_view 	= true;
        var $can_edit 	= true;
        var $can_delete = true;
        var $can_add  	= true;
        var $can_import = false;
        var $can_export = true;
        var $can_search = true;

       //*=[ CONSTRUCTOR ]===========================================================*/
        function erp_accounting_plans($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

	}

}
?>
