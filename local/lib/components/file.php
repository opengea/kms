<?php
/**
 * required params:
 *
 * path - path to location of files
 * webpath - relative web path to the directory
 */
class file {

    function file($field,$params,&$dm) {
        $this->field = $field;
        $this->path = $params[0];
        $this->webpath = $params[1];
        $this->dm =& $dm;
        $this->showImage_bool = $params[2];
        $this->thumbResize = $params[3];
        $this->imageResize = $params[4];
        $this->scaleType = $params[5];
//	$this->saveOriginal = $params[6];

       // default values
        if ($this->scaleType!="w" and $this->scaleType!="h") $this->scaleType="h";
        if (!isset($this->thumbResize)) { $this->thumbResize=$this->thumbHeight="75"; $this->thumbResize="100"; }

	$this->webpaththumb = $this->webpath;
	if (!isset($this->imageResize)) { $this->webpaththumb = $this->webpath."/"; }

        if (!is_writable($this->path)) {
                mkdir ($this->path);
                chmod ($this->path,0777);
	}

        if (!is_writable($this->path)) {
            $this->dm->_error("Error in FILE component".$this->path,"'{$this->path}' does not exist or is not writable.");
            $_SESSION["screen_msgs"]="Error in FILE component".$this->path." does not exist or is not writable.";
        }
    }

    function output_filter($data,$id) {
    // funcio que mostra el fitxer
        if (empty($data))  return;
	if ($_REQUEST['_action']=="Duplicate") return; 

        if (!is_file($this->path."/".$data)) { // ensure file exists
		return "<img src=\"/kms/css/aqua/img/icons/1589.gif\" title=\"".$this->path."/".$data . " (NOT FOUND)\">";
        }

	$ext = strtolower(strrchr($data,"."));
        if ($ext==".jpg" || $ext==".png" || $ext==".gif" || $ext=="jpeg") { //picture

        if (getimagesize($this->path."/".$data)&&($this->showImage_bool)) {
            // image must be showed

            // picture for web size
            $mysock = getimagesize($this->path."/img_".$data);
            $width_web= $mysock[0];
            $height_web = $mysock[1];

            // original size
            $mysock = getimagesize($this->path."/".$data);
            $width_orig= $mysock[0];
            $height_orig = $mysock[1];

	   if ($width_orig > $height_orig) { $percentage = ($this->thumbResize / $width_orig);  } else { $percentage = ($this->thumbResize / $height_orig); }
   	   if ($this->thumbHeight=="") $this->thumbHeight=$this->thumbResize+30;
	    if (isset($this->imageResize)) if (file_exists($this->path."/thumb/".$data)) $fileToLoad = $this->webpath."/thumb/".$data; else $fileToLoad = $this->webpath."/img_".$data;
            $txt_return = "<div class=\"component picture_detail\"><div><img border=\"0\" src=\"{$fileToLoad}\"></div><div>";
	    $txt_return .= "&nbsp;&rsaquo;<a style=\"font-size:9px\" class=\"link\" href=\"{$this->webpath}/img_{$data}\" target=\"newtab\" title=\""._KMS_PICTURES_RESIZEDPIC." (".$width_web."x".$height_web.")\">"._KMS_PICTURES_RESIZEDPIC."</a><br>&nbsp;&rsaquo;<a style=\"font-size:9px\" class=\"link\" href=\"{$this->webpath}/{$data}\" target=\"newtab\" title=\""._KMS_PICTURES_ORIGINALPIC." (".$width_orig."x".$height_orig.")\">"._KMS_PICTURES_ORIGINALPIC."</a>";
	    $txt_return .= "</div>";
	    return $txt_return;
        } else {
            // don't need to show image
            $size = $this->_getfilesize($this->path."/".$data);
            $ext = strtolower(strrchr($data,"."));
            $icon = $this->_getIcon($ext);
	    $dom = str_replace("extranet.","",$_SERVER['SERVER_NAME']);
	    return "<a download href=\"{$this->webpath}/{$data}\">".$icon."</a>"; 


           // return $data;
       }
        } else { // not picture
               $icon = $this->_getIcon($ext);
//		if ($this->filename=="") $this->filename="Download";
                $this->filename=$data;
                return "<a download href=\"{$this->webpath}/{$data}\" style='display:table'>".$icon." ".$this->filename."</a>";
        }

    }

    function display_component($value) {
	// es mostra en el dataEditor

	$out="
    <script type=\"text/javascript\">
    function getfilename(field, value) {
        re = \"/^.+[\/\\]+?(.+)$/\";
        document.getElementById(field).value = value.replace(re, \"$1\");
    }
    </script>";

	if ($_REQUEST['_action']=="Duplicate") $value="";
        $out.= "<div class=\"component\">\n";
	$out.= "<div><b></b></div><div><input type=\"hidden\" size=\"32\" id=\"{$this->field}\" name=\"{$this->field}\" value=\"{$value}\" /></div>\n";
        #document.dm.{$this->field}.value=''
        $out.= "<div><b>"._MB_UPLOAD."</b></div><div><input type=\"file\" size=\"32\" name=\"{$this->field}_upload\" onblur=\"getfilename('{$this->field}', this.value);\" onchange=\"getfilename('{$this->field}', this.value);\" onkeyup=\"getfilename('{$this->field}', this.value);\" /></div>\n";
        $out.= "</div>";
//	if ($_GET['_action']=="Duplicate") $this->field="";
        if (!empty($value)) {
            if (is_file($this->path."/".$value)) {
                $out.= $this->output_filter($value,null);
                $out.= "<input type=\"checkbox\" id=\"rmfile_{$this->field}\" name=\"_rmfiles[]\" value=\"{$this->field}\" />\n";
                $out.= "<label for=\"rmfile_{$this->field}\">"._MB_REMOVEASK."</a>";
            } else {
                $out.= $this->path."/".$value." (NOT FOUND)";
            }
        }
	return $out;
    }

    function input_filter($value) {
        // handle the uploaded file
        $_field = $this->field . "_upload";
        if (is_uploaded_file($_FILES[$_field]["tmp_name"])) {
        // rename the filename
            $ext = strtolower(strrchr($_FILES[$_field]["name"],"."));
            $targetFilename_orig = date('ymdHis').rand(0,500).$ext;
            if (!move_uploaded_file($_FILES[$_field]["tmp_name"],$this->path."/".$targetFilename_orig)) {
                $this->dm->addmsg("File upload failed.");
                $_SESSION["screen_msgs"]="File upload failed.";
                return "ko";//$targetFilename_orig;
            }

            // upload success
            $this->dm->addmsg(_MB_FILE." '{$value}' "._MB_SENDED);

            // save resized picture
               if (isset($this->imageResize)) {
                   include_once('/usr/local/kms/lib/resizeImg/SimpleImage.php');

                   $dirload = $this->path."/";
                   $dirsave = $this->path."/";
                   $image = new SimpleImage();
                   // extract orig_ from filename
                   $image->load($dirload.$targetFilename_orig);
                   $mysock = getimagesize($dirload.$targetFilename_orig);
                   $width= $mysock[0];
                   $height = $mysock[1];

                   if ($this->scaleType=='h') {
                                        $rel=$width/$height;
                                        $width = $this->imageResize;
                                        $height = $this->imageResize/$rel;
                                } else {
                                        $rel = $height/$width;
                                        $height = $this->imageResize;
                                        $width = $this->imageResize/$rel;
                                }

 //                  $height = round($height * $percentage);
                   $image->resize($width,$height);
                   $image->save($dirsave."img_".$targetFilename_orig);
                  $this->webpath = $this->webpath;
                }

            // create thumbnail
               if (isset($this->thumbResize)) {

                   include_once('/usr/local/kms/lib/resizeImg/SimpleImage.php');

                   $dirload = $this->path."/";
                   $dirsave = $this->path."/thumb/";
                   $image = new SimpleImage();
                   $image->load($dirload.$targetFilename_orig);
                   $mysock = getimagesize($dirload.$targetFilename_orig);
                   $width= $mysock[0];
                   $height = $mysock[1];

                   if ($this->scaleType=='h') {
                                        $rel=$width/$height;
                                        $width = $this->thumbResize;
                                        $height = $this->thumbResize/$rel;
                                } else {
                                        $rel = $height/$width;
                                        $height = $this->thumbResize;
                                        $width = $this->thumbResize/$rel;
                                }

                   $image->resize($width,$height);
                   $image->save($dirsave.$targetFilename_orig);
                   $this->webpath = $this->webpath."/thumb/";
                }


            return $targetFilename_orig;
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
            $d = "word.gif" ;
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
        case ".pl"      :
        case ".py"      :
            $d = "p.gif";
            break;
        case ".wrl"     :
        case ".vrml":
        case ".vrm"     :
        case ".iv"      :
            $d = "world2.gif";
            break;
        case ".ps"      :
        case ".ai"      :
        case ".eps"     :
            $d  = "a.gif";
            break;
        case ".pdf" :
            $d = "pdf.gif" ;
            break;
        case ".txt" :
        case ".ini" :
            $d = "text.gif" ;
            break;
        case ".xls" :
            $d = "excel.gif" ;
            break ;
        case ".dvi"     :
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
        case ".wav"     :
        case ".it"      :
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
        case "box"      :
            $d = "box1.gif";
            break;
        case "up" :
            $d = "back.gif" ;
            break ;
	 case ".ppt" :
            $d = "powerpoint.gif" ;
            break ;
	 case ".pps" :
            $d = "powerpoint.gif" ;
            break ;
	 case ".avi" :
            $d = "avi.png" ;
	    break;
	 case ".mpg" :
            break;
            $d = "mpg.gif" ;	
            break ;
	 case ".mpeg" :
            $d = "mpg.gif" ;
            break ;
        case "blank" :
            $d = "blank.gif" ;
            break ;
        default :
            $d = "unknown.gif" ;
        }
        return "<img src=\"".PATH_IMG_FILETYPES."/{$d}\" border=0 />";
    }

}

?>
