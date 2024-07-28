<?

// ----------------------------------------------
// Class ISP Firewall for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_firewall extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

        var $mod_type       = "external";
        var $title          =_KMS_TY_ISP_FIREWALL;
        var $load           = "/usr/share/kms/mod/isp/get_client_config.php";

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_firewall($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		header ("location:http://192.168.1.2");

        }

}
?>
