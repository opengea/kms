<?

// ----------------------------------------------
// Class ISP Dokuwiki for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class isp_dokuwiki extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

        var $mod_type       = "external";
        var $title          =_KMS_TY_ISP_DOKUWIKI;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function isp_dokuwiki($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
                header ("location:http://code.intergrid.cat/wiki/doku.php");
        }

}
?>
