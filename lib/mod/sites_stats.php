<?

// ----------------------------------------------
// Class Sites Stats for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class sites_stats extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

        /*=[ CONFIGURATION ]=====================================================*/

        var $mod_type       = "external";
        var $title          =_KMS_TY_SITES_STATS;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_control_panel($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

		header ('location:http://www.'.$this->current_domain.'/webstats');
	}

}
?>
