<?

// ----------------------------------------------
// Class ISP Client Config for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------



class isp_client_config extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

        var $mod_type       = "external";
        var $title          =_KMS_TY_ISP_CLIENT_CONFIG;
        var $load           = "/usr/local/kms/mod/isp/client_config/index.php";

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_client_config($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
//		$this->action("update_domains","/usr/local/kms/mod/isp/update_domains.php");

        }

}
?>
