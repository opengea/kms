<?

// ----------------------------------------------
// Class ISP Datacenter for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_datacenter extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

        var $mod_type       = "external";
        var $title          =_KMS_TY_ISP_DATACENTER;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_datacenter($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {

                header ("location:https://robot.your-server.de");

        }

}
?>


