<?php
/**
 * required params:
 *
 * path - path to location of files
 * webpath - relative web path to the directory
 */
class sendmailing {

    function sendmailing($params,&$dm) {
        $this->email1 = $params[0];
        $this->email2 = $params[1];
        $this->dm =& $dm;

    }

    function output_filter($data) {
        if (empty($data))
            return;

        if (!is_file($this->path."/".$data)) { // ensure file exists
            return $this->path."/".$data . " (NOT FOUND)";
        }
//        echo $this->path."/".$data;
	if (getimagesize($this->path."/".$data)&&($this->showImages)) {
	    if ($this->size!="") $sizeimage = "width=".$this->size; else $sizeimage = ""; 
//	     return "<img src=\"http://www.google.com/images/nav_logo3.png\" width=\"5\" height=\"5\">";
            return "<a href=\"{$this->webpath}/{$data}\" border=\"0\"><img src=\"{$this->webpath}/{$data}\" width=40 height=40 ".$sizeimage."></a>";
        } else {
            $size = $this->_getfilesize($this->path."/".$data);
            $ext = strtolower(strrchr($data,"."));
            $icon = $this->_getIcon($ext);
	    
//            return $icon . " <a href=\"{$this->webpath}/{$data}\">{$data}</a> ({$size})";
		return "<a href=\"{$this->webpath}/{$data}\">{$icon}</a>";

        }
    }

    function display_component($value) {
?>
    <script type="text/javascript">
    function getfilename(field, value) {
        re = /^.+[\/\\]+?(.+)$/;
        document.getElementById(field).value = value.replace(re, "$1");
    }
    </script>
<?php
        print "<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\">\n";
        print "<tr><td><b>"._MB_FILENAME."</b></td><td><input type=\"text\" size=\"32\" id=\"{$this->field}\" name=\"{$this->field}\" value=\"{$value}\" /></td></tr>\n";
        #document.dm.{$this->field}.value=''
        print "<tr><td><b>"._MB_UPLOAD."</b></td><td><input type=\"file\" size=\"32\" name=\"{$this->field}_upload\" onblur=\"getfilename('{$this->field}', this.value);\" onchange=\"getfilename('{$this->field}', this.value);\" onkeyup=\"getfilename('{$this->field}', this.value);\" /></td></tr>\n";
        print "</table>";
        if (!empty($value)) {
            if (is_file($this->path."/".$value)) {
                print $this->output_filter($value);
                print "<input type=\"checkbox\" id=\"rmfile_{$this->field}\" name=\"_rmfiles[]\" value=\"{$this->field}\" />\n";
                print "<label for=\"rmfile_{$this->field}\">"._MB_REMOVEASK."</a>";
            } else {
                print $this->path."/".$value." (NOT FOUND)";
            }
        }
    }

    function input_filter($value) {
        // handle the uploaded file
        $_field	= $this->field . "_upload";
        if (is_uploaded_file($_FILES[$_field]["tmp_name"])) {
            if (!move_uploaded_file($_FILES[$_field]["tmp_name"],$this->path."/".$_FILES[$_field]["name"])) {
                $this->dm->addmsg("File upload failed.");
                return $value;
            }

            // upload success
            $this->dm->addmsg(_MB_FILE." '{$value}' "._MB_SENDED);
            return $value;
        }

        // remove file if requested
        if (@in_array($this->field,$_REQUEST['_rmfiles'])) {
            $_file = $_REQUEST[$this->field];
            if (is_file($this->path."/".$_file)) {
                if (unlink($this->path."/".$_file)) {
                    $value = "";
                    $this->dm->addmsg(_MD_REMOVEDFILE.'$_file');
                }
            }
        }

        return $value;
    }

    function _getfilesize($path) {
        $size = filesize($path);
        $j = 0;
        $ext = array("B","KB","MB","GB","TB");
        while ($size >= pow(1024,$j))
            ++$j;
        return round($size / pow(1024,$j-1) * 100) / 100 . " " . $ext[$j-1];
    }

    function _getIcon($txt) {
        switch (strtolower($txt)) {
        case ".bmp" :
            $d = "bmp.gif" ;
            break ;
        case ".gif" :
            $d = "gif.gif" ;
            break ;
        case ".png" :
            $d = "png.gif" ;
            break ;
        case ".jpg" :
            $d = "jpg.gif" ;
            break ;
        case ".jpeg":
            $d = "jpg.gif" ;
            break ;
        case ".tif" :
            $d = "image2.gif" ;
	    break ;
        case ".tiff":
            $d = "image2.gif" ;
            break ;
        case ".doc" :
            $d = "doc.gif" ;
            break ;
        case ".odt" :
            $d = "doc.gif" ;
            break ;
        case ".exe" :
        case ".com" :
        case ".bin" :
        case ".bat" :
            $d = "binary.gif" ;
            break ;
        case ".hqx" :
            $d = "binhex.gif" ;
            break ;
        case ".bas" :
        case ".c"   :
        case ".cc"  :
        case ".src" :
            $d = "c.gif" ;
            break ;
        case "file" :
            $d = "file.gif" ;
            break ;
        case "dir" :
            $d = "dir.gif" ;
            break ;
        case "opendir" :
            $d = "folder.open.gif" ;
            break ;
        case ".phps" :
        case ".php3" :
        case ".htm" :
        case ".html":
        case ".asa" :
        case ".asp" :
        case ".cfm" :
        case ".php3":
        case ".php" :
        case ".phtml" :
        case ".shtml" :
            $d = "world1.gif";
            break;
        case ".pl"	:
        case ".py"	:
            $d = "p.gif";
            break;
        case ".wrl"	:
        case ".vrml":
        case ".vrm"	:
        case ".iv"	:
            $d = "world2.gif";
            break;
        case ".ps"	:
        case ".ai"	:
        case ".eps"	:
            $d	= "a.gif";
            break;
        case ".pdf" :
            $d = "pdf.gif" ;
            break;
        case ".txt" :
        case ".ini" :
            $d = "text.gif" ;
            break;
        case ".xls" :
            $d = "box2.gif" ;
            break ;
        case ".dvi"	:
            $d = "dvi.gif";
            break;
        case ".mpg" :
            $d = "movie.gif";
	    break;
        case ".mpeg":
            $d = "movie.gif";
            break;
	case ".flv" :
            $d = "movie.gif";
            break;
        case ".aiff":
        case ".wav"	:
        case ".it"	:
        case ".mp3" :
            $d = "mp3.gif";
            break;
        case ".conf":
        case ".cfg":
        case ".scr":
        case ".sh":
        case ".shar":
        case ".csh":
        case ".ksh":
        case ".tcl":
            $d = "script.gif";
            break;
        case ".tar" :
        case ".zip" :
        case ".arc" :
        case ".sit" :
        case ".gz"  :
        case ".tgz" :
        case ".Z"   :
            $d = "compressed.gif" ;
            break ;
        case "view" :
            $d = "index.gif" ;
            break ;
        case "box"	:
            $d = "box1.gif";
            break;
        case "up" :
            $d = "back.gif" ;
            break ;
        case "blank" :
            $d = "blank.gif" ;
            break ;
        default :
            $d = "unknown.gif" ;
        }

        return "<img alt=\"\" src=\"".PATH_IMG_FILETYPES."/{$d}\" border=\"0\" />";
    }

}

?>
