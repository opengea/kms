<?php
/**
 * required params:
 *
 * path - path to location of files
 * url - relative web path to the directory
 *
 * $kms->setComponent("picture","picture",array("path"=>"/var/www/vhosts/".$current_domain."/subdomains/data/httpdocs/files/catalog/pictures","url"=>"//data.".$current_domain."/files/catalog/pictures","resize_max_width"=>100,"resize_max_height"=>80,"thumb_max_width"=>200,"thumb_max_height"=>160))
 */
class picture {

    function picture($field,$params,&$dm) {

        $this->field = $field;
	$this->dm =& $dm;
        $this->path = $params['path'];
        $this->url = $params['url'];
        $this->thumb_max_width = $params['thumb_max_width'];
	$this->thumb_max_height = $params['thumb_max_height'];
        $this->resize_max_width = $params['resize_max_width'];
        $this->resize_max_height = $params['resize_max_height'];
	$this->scaleType = $params['scaleType'];
	//set paths
	if ($_GET['mod']=="lib_pictures"&&$_GET['id']!="") { //&&$_GET['_']!="ib") {
                $sel="select * from kms_lib_pictures where id=".$_GET['id'];
                $res=mysqli_query($this->dm->dblinks['client'],$sel);
                $pic=mysqli_fetch_array($res);
                if ($pic['path']!="") {
                        if (substr($pic['path'],strlen($pic['path'])-1,1)=="/") $pic['path']=substr($pic['path'],0,strlen($pic['path'])-1);
                        $this->url=$pic['path'];
                        $this->path="/var/www/vhosts/".$this->dm->client_account['domain']."/subdomains/data/httpdocs/files/catalog/".$pic['mod']."/".$pic['fieldname'];
                } else {
                        //regular picture
                         $this->path="/var/www/vhosts/".$this->dm->client_account['domain']."/subdomains/data/httpdocs/files/pictures/albums/".$pic['album_id'];
                         $this->url="//data.".$this->dm->client_account['domain']."/files/pictures/albums/".$pic['album_id'];
                }
        } else {
		$this->old_path=$this->path;
		$this->old_url=$this->url;
                $this->path.="/".$_GET['mod']."/".$this->field;
		$this->url.="/".$_GET['mod']."/".$this->field;
                mkdir ($this->path,0777,true);
	}
        if ($this->scaleType!="w" and $this->scaleType!="h") $this->scaleType="h";

        if (!is_writable($this->path)) {
                mkdir ($this->path,0777,true);
        }

        if (!is_writable($this->path)) {
            $this->dm->_error("Error in FILE component".$this->path,"'{$this->path}' does not exist or is not writable.");
            $_SESSION["screen_msgs"]="Error in FILE component".$this->path." does not exist or is not writable.";
        }
 
	$this->new_path=$this->path;
	$this->new_url=$this->url;
   }

    function output_filter($data,$id) {
 
	//default
	$this->path=$this->new_path;
        $this->url=$this->new_url;

  	// shows image
        if (empty($data)) return;
	if ($_GET['mod']=="lib_pictures") {
		if ($id=="") $id=$_GET['id'];
		$sel="select * from kms_lib_pictures where id=".$id;
		include_once "/usr/local/kms/lib/dbi/openClientDB.php";include_once "/usr/local/kms/lib/dbi/dbconnect.php";
		$res=mysqli_query($this->dm->dblinks['client'],$sel);
		if (!$res) die(mysqli_error());
		$pic=mysqli_fetch_assoc($res);
		if ($pic['path']!="") {  
			if (substr($pic['path'],strlen($pic['path'])-1,1)=="/") $pic['path']=substr($pic['path'],0,strlen($pic['path'])-1);
			$this->url=$pic['path']; 
			$this->path="/var/www/vhosts/".$this->dm->client_account['domain']."/subdomains/data/httpdocs/files/catalog/".$pic['mod']."/".$pic['fieldname'];
		} else {
			//regular picture
			 $this->path="/var/www/vhosts/".$this->dm->client_account['domain']."/subdomains/data/httpdocs/files/pictures/albums/".$pic['album_id'];
			 $this->url="//data.".$this->dm->client_account['domain']."/files/pictures/albums/".$pic['album_id'];
		}

	} else if (!is_file($this->path."/".$data)) { // ensure file exists
                $this->path=$this->old_path;
                $this->url=$this->old_url;
		if (!is_file($this->path."/".$data)) return $this->path."/".$data . " (NOT FOUND)";
        }

        if (getimagesize($this->path."/".$data)) {
            // showing image if exists

            // picture for web size
            $mysock = getimagesize($this->path."/img_".$data);
            $width_web= $mysock[0];
            $height_web = $mysock[1];

            // original size
            $mysock = getimagesize($this->path."/".$data);
            $width_orig= $mysock[0];
            $height_orig = $mysock[1];

	    if ($width_orig > $height_orig) {$percentage = ($this->thumbResize / $width_orig);  } else { $percentage = ($this->thumbResize / $height_orig); }
	    if (file_exists($this->path."/mini/".$data)) { $fileToLoad = $this->url."/mini/".$data; }
	    else if (file_exists($this->path."/thumb/".$data)) { $fileToLoad = $this->url."/thumb/".$data; }
	    else if (file_exists($this->path."/img_".$data)) { $fileToLoad = $this->url."/img_".$data; }
	    else { $fileToLoad = $this->url."/".$data; }

            $txt_return = "<div class=\"picture_detail\" style='float:left;padding-right:20px'><div style='float:left'><a href='".$this->url."/".$data."'><img border=\"0\" style=\"max-height:60px\" src=\"{$fileToLoad}\"></a></div></div>";
	     if($_GET['_']!="b") { 
	    $txt_return .= "<div style='float:left'>&nbsp;&rsaquo;<a style=\"font-size:9px\" class=\"link\" href=\"{$this->url}/img_{$data}\" target=\"newtab\" title=\""._KMS_PICTURES_RESIZEDPIC." (".$width_web."x".$height_web.")\">"._KMS_PICTURES_RESIZEDPIC."</a><br>&nbsp;&rsaquo;<a style=\"font-size:9px\" class=\"link\" href=\"{$this->url}/{$data}\" target=\"newtab\" title=\""._KMS_PICTURES_ORIGINALPIC." (".$width_orig."x".$height_orig.")\">"._KMS_PICTURES_ORIGINALPIC."</a></div>";
	     }
	    $txt_return .= "</div>";
	    return $txt_return;

        } else {

            // don't need to show image
            $size = $this->_getfilesize($this->path."/".$data);
            $ext = strtolower(strrchr($data,"."));
            $icon = $this->_getIcon($ext);
            // return $icon . " <a href=\"{$this->url}/{$data}\">{$data}</a> ({$size})";

	    $dom = str_replace("extranet.","",$_SERVER['SERVER_NAME']);
//          return "<a href=\"//data.".$dom."/{$this->url}/{$data}\">{$icon}</a>";
//echo $this->path."/mini/".$data;
	    if (($ext==".jpg" || $ext==".png" || $ext==".gif")&&(file_exists($this->path."/mini/".$data))) return "<a href=\"//data.".$dom."/{$this->url}/{$data}\"><img src=\"//data.".$dom."/{$this->url}/mini/{$data}\"></a>"; else return "<a href=\"//data.".$dom."/{$this->url}/{$data}\">".$icon."</a>"; 
            // return $data;
       }
    }

    function display_component($value) {
	// shows in dataEditor
	$out="
    <script type=\"text/javascript\">
    function getfilename(field, value) {
        re = \"/^.+[\/\\]+?(.+)$/\";
        document.getElementById(field).value = value.replace(re, \"$1\");
    }
    </script>";

	$out.= "<div class='picture'>";
	$out.= "<input type=\"hidden\" size=\"32\" id=\"{$this->field}\" name=\"{$this->field}\" value=\"{$value}\" />\n";


	if (!empty($value)) {
            if (is_file($this->path."/".$value)) {
                $out.= $this->output_filter($value,null);
		}
	}
	$out.="<div class='file' style='float:left'>";
//      $out.= "<div><b>"._MB_UPLOAD."</b></div>"
	$out.="<div style='clear:left'><input type=\"file\" size=\"32\" name=\"{$this->field}_upload\" onblur=\"getfilename('{$this->field}', this.value);\" onchange=\"getfilename('{$this->field}', this.value);\" onkeyup=\"getfilename('{$this->field}', this.value);\" /></div>\n";
        if (!empty($value)) {
            if (is_file($this->path."/".$value)) {
                $out.= "<div style='clear:left'><input type=\"checkbox\" id=\"rmfile_{$this->field}\" name=\"_rmfiles[]\" value=\"{$this->field}\" />\n";
                $out.= "<label for=\"rmfile_{$this->field}\">"._MB_REMOVEASK."</a></div>";
            } else {
                $this->path=$this->old_path;
                $this->url=$this->old_url;

		if (!is_file($this->path."/".$value)) $out.= $this->path."/".$value." (NOT FOUND.)";
            }
        }
	$out.= "</div>";
	$out.= "</div>";
	if ($this->dm->comments[$this->field]!="") $out .="&nbsp;&nbsp;<span id='comment_".$this->field."'>".$this->dm->comments[$this->field]."</span>\n";
	return $out;
    }

    function input_filter($value) {

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

        // uploads and resizes
        $_field = $this->field . "_upload";
        if (is_uploaded_file($_FILES[$_field]["tmp_name"])) {

	   //remove old files
            $_file = $_REQUEST[$this->field];
            if (is_file($this->path."/".$_file)) {
                if (unlink($this->path."/".$_file)) {
                    $value = "";
                }
            }
    	    if (is_file($this->path."/img_".$_file)) {
                if (unlink($this->path."/img_".$_file)) {
                    $value = "";
                }
            }
	     if (is_file($this->path."/thumb/".$_file)) {
                if (unlink($this->path."/thumb/".$_file)) {
                    $value = "";
                }
            }
	    if (is_file($this->path."/mini/".$_file)) {
                if (unlink($this->path."/mini/".$_file)) {
                    $value = "";
                }
            }


        // rename the filename
            $ext = strtolower(strrchr($_FILES[$_field]["name"],"."));
            $name= substr($_FILES[$_field]["name"],0,strrpos($_FILES[$_field]["name"],"."));
	    $name= urlize($name);//str_replace(" ","-",$name);

	    $sel="select id from kms_lib_pictures order by id desc limit 1";
	    $res=mysqli_query($this->dm->dblinks['client'],$sel);
	    $last=mysqli_fetch_array($res);
	    $picture_id=$last[0]+1;

            $targetFilename_orig = $name."-{$picture_id}".$ext;//date('ymdHis').rand(0,500).$ext;
            if (!move_uploaded_file($_FILES[$_field]["tmp_name"],$this->path."/".$targetFilename_orig)) {
                $this->dm->addmsg("File upload failed.");
                $_SESSION["screen_msgs"]="File upload failed.";
                return "ko";//$targetFilename_orig;
            }

            // upload success
            $this->dm->addmsg(_MB_FILE." '{$value}' "._MB_SENDED);

            // save resized picture
                   include_once('/usr/local/kms/lib/resizeImg/SimpleImage.php');

                   $dirload = $this->path."/";
                   $dirsave = $this->path."/";
                   $image = new SimpleImage();
                   // extract orig_ from filename
                   $image->load($dirload.$targetFilename_orig);
                   $mysock = getimagesize($dirload.$targetFilename_orig);
                   $width= $mysock[0];
                   $height = $mysock[1];

	            if ($this->scaleType=='w') {
                                        $rel=$width/$height;
                                        $width_to = $this->resize_max_width;
                                        $height_to = round($this->resize_max_width/$rel);
                                } else {
                                        $rel = $height/$width;
                                        $height_to = $this->resize_max_height;
                                        $width_to = round($this->resize_max_height/$rel);
                                }

	   // escalem nomes si fa falta!
	   if ($width>$width_to&&$height>$height_to) {
			//echo "scale: yes";exit;
                  $image->resize($width_to,$height_to);
	   }

	   // si es passa del limit reajustem

           if ($width_to>$this->resize_max_width) { 
                        $width_to=$this->resize_max_width;
                        $rel=$width/$height;
                        $height_to = round($width_to/$rel);
           }
           if ($height_to>$this->resize_max_height) {
                        $height_to=$this->resize_max_height;
                        $rel = $height/$width;
                        $width_to = round($height_to/$rel);
           }


           $image->save($dirsave."img_".$targetFilename_orig);

            // create thumbnail
            $dirsave = $this->path."/thumb/";

            if ($this->scaleType=='w') {
                                        $rel=$width/$height;
                                        $width_to = $this->thumb_max_width;
                                        $height_to = round($this->thumb_max_width/$rel);
                                } else {
                                        $rel = $height/$width;
                                        $height_to = $this->thumb_max_height;
                                        $width_to = round($this->thumb_max_height/$rel);
                                }

	           // si es passa del limit reajustem
           if ($width_to>$this->thumb_max_width) { 
			$width_to=$this->thumb_max_width;
			$rel=$width/$height;
			$height_to = round($width_to/$rel);
	   }
           if ($height_to>$this->thumb_max_height) {
			$height_to=$this->thumb_max_height;
			$rel = $height/$width;
			$width_to = round($height_to/$rel);
	   }

            $image->resize($width_to,$height_to);
            $image->save($dirsave.$targetFilename_orig);
            $this->url_=$this->url;
            $this->url = $this->url."/thumb/";

	// Mini Resize for internal use
        $dirsave = $this->path."/mini/";
	$mini_max_width = 80;
	$mini_max_height = 80;

        if ($this->scaleType=='w') {
                     $rel=$width/$height;
                     $width_to = $mini_max_width;
                     $height_to = round($mini_max_width/$rel);
             } else {
                     $rel = $height/$width;
                     $height_to = $mini_max_height;
                     $width_to = round($mini_max_height/$rel);
             }

            $image->resize($width_to,$height_to);
            $image->save($dirsave.$targetFilename_orig);

            $value=$targetFilename_orig;
        }

                //save on lib_pictures

	if ($_GET['mod']!="lib_pictures"&&$targetFilename_orig!="") {
	        $description= $name; //substr($targetFilename_orig,0,strrpos($targetFilename_orig,"."));
		$origin_id=$_GET['id'];
	        $insert="insert into kms_lib_pictures (status,creation_date,path,file,`mod`,fieldname,origin_id,description,caption,album_id,owner) VALUES ('1','".date('Y-m-d H:i:s')."','{$this->url_}','".$targetFilename_orig."','{$_GET['mod']}','{$this->field}','{$origin_id}','{$description}','','','')";
	        $res=mysqli_query($this->dm->dblinks['client'],$insert);
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

        return "<img alt=\"\" src=\"".PATH_IMG_FILETYPES."/{$d}\" border=\"0\" />";
    }

}

?>
