<?php
/**
 * A very simple template class
 */
class template {

    var $vars;
    var $dblink;

    function template($dblink) {
	$this->dblink=$dblink;
    }

    // Set a template variable.
    function set($name, $value) {
        $this->vars[$name] = $value;
    }

    // Open, parse, and return the template file.
    function fetch($file,$kms) {
        $file = PATH_TPL . "/" . $file;

        extract($this->vars);
        ob_start();
        include($file);
        $contents = ob_get_contents();
        ob_end_clean();

        // reset vars
        $this->vars = array();

        return $contents;
    }
}
?>
