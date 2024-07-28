<?

function fixcometes ($str) {
        // reeplace this ' caracter by \'
        $arrSearch = array("'");
        $arrReplace  = array("\'");
        $str =  str_replace ($arrSearch, $arrReplace, $str);
        // reeplace this " caracter by \"
        $arrSearch = array('"');
        $arrReplace  = array('\"');
        $str =  str_replace ($arrSearch, $arrReplace, $str);
        return $str;
}

?>

