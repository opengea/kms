<?

// ----------------------------------------------
// Class Docs Multiple Uploader for KMS 
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class docs_mupload extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

        $mod_type       = "external";
        $title          =_KMS_GL_MUPLOAD;
        $load           = "/usr/share/kms/lib/plugins/mupload/kms/index.php";

       //*=[ CONSTRUCTOR ]===========================================================*/

        function docs_mupload($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {


        }

}
?>
