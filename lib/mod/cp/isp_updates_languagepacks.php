<?

// ----------------------------------------------
// Class ISP Updates Language packs for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_updates_languagepacks extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

        var $mod_type       = "external";
        var $title          = _KMS_TY_ISP_SITES_MAKE_LANG;
	var $load = "/usr/local/kms/mod/isp/updates/update_languagepacks.php";

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_dokuwiki($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

        }

}
?>
