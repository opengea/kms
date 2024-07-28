<?php
 /*
 * req params:
 *
 * path - path to location of files
 * webpath - relative web path to the directory
 * size - dimensions of the thumbnail image to generate
 */
class thumbnail {

    var $prefix   = "t_";
    var $convert  = "/usr/X11R6/bin/convert";

    function thumbnail($field,$params,&$dm) {
        $this->field = $field;
        $this->path = $params[0];
        $this->webpath = $params[1];
        $this->size = !empty($params[2]) ? $params[2] : "100x100";
        $this->dm =& $dm;

        if ($this->dm->hasComponent($this->field,"file")) {
            if (!is_writable($this->path)) {
                $this->dm->_error("Error in THUMBNAIL component","'{$this->path}' does not exist or is not writable.");
            }
        } else {
            $this->dm->_error("Error in THUMBNAIL component","THUMBNAIL component may only be applied to fields with FILE component.");
        }
    }

    function output_filter($data) {
        if (!file_exists($this->path."/".$data)) { // ensure file exists
            return $this->path."/".$data . " (NOT FOUND)";
        }
        return "<a href=\"{$this->webpath}/{$data}\">{$data}</a>";
    }

    function input_filter() {
        if ($vars[$this->field] = $this->_upload($this->field)) {
            $this->addmsg("Uploaded file {$_filename}.");
        }
    }

    function _format_image($arr,$file) {
        $path = $arr["path"];
        $reldir = $arr["reldir"];

        $imgsize = @getimagesize($path."/".$file);

        if (is_array($this->thumbs[$field])) { // check for thumbnail component
            $_file	= $this->prefix . $file;

            if (!file_exists($t_path."/".$t_file)) { // not found, generate thumbnail
                exec("{$this->convert} -geometry {$t_size} {$path}/{$file} {$t_path}/{$t_file}");
                $this->addmsg("Generated thumbnail {$t_file}");
            }
            return "<a href=\"javascript:openwindow('{$reldir}/{$file}','{$imgsize[0]}','{$imgsize[1]}'); void(0);\"><img src=\"{$t_reldir}/{$t_file}\" {$_size[3]} border=\"1\" alt=\"{$file} (".filesize($path."/".$file)." bytes)\"></a>";
        } else { // no thumbnail support
            return "<img src=\"{$reldir}/{$file}\" {$imgsize[3]} alt=\"{$file} (".filesize($path."/".$file)." bytes)\" border=\"1\">";
        }
    }

}

?>
