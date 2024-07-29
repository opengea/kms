<?

// ----------------------------------------------
// Class ISP Domain Register for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_registrador extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

        var $mod_type       = "external";
        var $title          = "Registrador";

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_registrador($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		header ("location:https://login.autodns.com/");

        }

}
?>
