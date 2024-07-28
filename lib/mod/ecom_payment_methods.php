<?
// ----------------------------------------------
// Class Ecommerce Payment Methods for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class ecom_payment_methods extends mod {

        /*=[ CONFIGURACIO ]=====================================================*/

	var $table	= "kms_ecom_payment_methods";
	var $key	= "id";	
	var $fields = array("id",  "payment_name", "payment_quota", "payment_days","bank_charges" );
	var $title = "Formes de pagament";
	var $orderby = "payment_name";
	var $insert_label = "Nova forma de pagament";

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_edit           = true;
        var $can_delete         = true;
        var $can_add            = true;
        var $can_import         = false;
        var $can_export         = true;
        var $can_duplicate      = true;

      //*=[ CONSTRUCTOR ]===========================================================*/

        function ecom_payment_methods ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

	}
 }
?>
