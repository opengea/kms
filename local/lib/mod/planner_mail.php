<?

// ----------------------------------------------
// Class Planner Mail for KMS
// ----------------------------------------------
// Intergrid Tecnologies del Coneixement SL
// by Jordi Berenguer <j.berenguer@intergrid.cat>
// ----------------------------------------------

class planner_mail extends mod {

        /*=[ CONFIGURATION ]=====================================================*/

        var $table      = "kms_planner_mail";
        var $key        = "id";
        var $fields = array("flagged", "attachments", "from", "status", "subject", "to", "creation_date");
	var $hidden = array("uid","account_id","reply_status","attachments","in_reply_to","headers","structure","deleted","size","cc","cco","status");
	var $sortable = array("creation_date");
        var $orderby = "creation_date";
        var $sortdir = "desc";
	var $datasource = "array";
	var $rowclick = "view";
	var $uid        = "uid";

        /*=[ PERMISSIONS ]===========================================================*/

        var $can_view = false;
        var $can_edit = false;
        var $can_delete = true;
        var $can_add   = true;
        var $can_import = false;
        var $can_export = false;
        var $can_search = true;
        var $can_print  = false;

       //*=[ CONSTRUCTOR ]===========================================================*/

        function planner_mail ($client_account,$user_account,$dm) {
                parent::mod($client_account,$user_account,$extranet);
        }

        function setup($client_account,$user_account,$dm) {
		$this->per_page=100;
		$this->abbreviate("attachments","<img style='height:14px' src='/kms/css/aqua/img/icons/mail_attachment.png'>");
		$this->abbreviate("flagged","<img style='height:14px' src='/kms/css/aqua/img/icons/flagcol.png'>");
		$this->setStyle("attachments","width:15px;max-width:15px;padding-left:0px;padding-right:5px","be");
		$this->setStyle("status","width:25px;max-width:25px;padding-left:0px;padding-right:5px","be");
		$this->setStyle("flagged","width:15px;max-width:15px;padding-left:0px;padding-right:5px","be");
        	$this->defvalue("creation_date",date('Y-m-d'));
		$this->humanize("creation_date","Data");
		$this->setComponent("select","status",array("0"=>"<font color=#009900>NEW</font>","1"=>"<font color=#ff0000>READED</font>","2"=>"<font color=#0000ff>NOT READED</font>"));
		$this->setComponent("select","reply_status",array("0"=>"not replied","1"=>"replied","2"=>"forwarded"));
		$this->onBrowse="onBrowse";
		$this->onEdit="onEdit";
		$this->onAdd="onAdd";
		$this->defvalue("from",$user_account['email']);
		$this->setComponent("status_icon", "creation_date",  array("script"=>"datetime","show_label"=>false));
		$this->setComponent("status_icon", "flagged", array("script"=>"planner_mail_flagged","show_label"=>false));
		$this->setComponent("status_icon", "status", array("script"=>"planner_mail_status","show_label"=>false));
		$this->setComponent("status_icon", "from", array("script"=>"planner_mail_email","show_label"=>false));
		$this->setComponent("status_icon", "to",array("script"=>"planner_mail_email","show_label"=>false));
		$this->setComponent("status_icon", "subject",array("script"=>"planner_mail_subject","show_label"=>false));
		$this->setComponent("wysiwyg","body",array("type"=>"readonly"));
		$this->setStyle("creation_date","width:100px","be");
		$this->setStyle("from","width:200px","be");
	}

	function imap_connect($account,$folder) {
		if ($account['imap_port']=="") $account['imap_port']="143";
                if ($account['authentication']==0&&$account['ssl']==0) $string="/imap/novalidate-cert";
		else if ($account['authentication']==0&&$account['ssl']==1) $string="/imap/ssl/novalidate-cert";
		else if ($account['authentication']==1&&$account['ssl']==1) $string="/imap/notls";
                $serverport=$account['imap_server'].":".$account['imap_port'];
                $mbox = imap_open("{".$serverport.$string."}".$folder, $account['email'], $account['password']);
                if (!$mbox) echo "Can't connect to IMAP server ".$account['imap_server'].":".imap_last_error();
		return $mbox;
	}


	function imap_showFolders($mbox,$account) {
                echo "<b>Carpetes</b><hr>\n";
		$serverport=$account['imap_server'].":".$account['imap_port'];
                $folders = imap_listmailbox($mbox, "{".$serverport."}", "*");
                if ($folders == false) {
                    echo "Call failed<br />\n";
                } else {
                    foreach ($folders as $val) {
                        $val=substr($val,strpos($val,"}")+1);
                        echo $val . "<br />\n";
                    }
                }
	}

	function imap_showSubscriptions($mbox,$account) {
		$serverport=$account['imap_server'].":".$account['imap_port'];
                $list = imap_getsubscribed($mbox, "{".$serverport."}", "*");
                if (is_array($list)) {
                    foreach ($list as $key => $val) {
                        echo "($key) ";
                        $val=imap_utf7_decode($val->name);$val=substr($val,strpos($val,"}")+1);
                        echo $val."<br>";
//                      echo "'" . $val->delimiter . "',";
//                      echo $val->attributes . "<br />\n";
                    }
                } else {
                    echo "imap_getmailboxes failed: " . imap_last_error() . "\n";
                }
	}

	function imap_getStatus($mbox,$account) {
		$serverport=$account['imap_server'].":".$account['imap_port'];
		$status = imap_status($mbox, "{".$serverport."}".$folder, SA_ALL);
                if ($status) {
                  echo "Messages:   " . $status->messages    . "<br />\n";
                  echo "Recent:     " . $status->recent      . "<br />\n";
                  echo "Unseen:     " . $status->unseen      . "<br />\n";  // <------------ UTIL PER WIDGET
                  echo "UIDnext:    " . $status->uidnext     . "<br />\n";
                  echo "UIDvalidity:" . $status->uidvalidity . "<br />\n";
                } else {
                  echo "imap_status failed: " . imap_last_error() . "\n";
                }

	}

	function imap_openFolder($mbox) {
		///   if(!imap_reopen($stream, $mailbox)) return false;
	}

	function imap_renameFolder($mbox) {
		// imap_renamemailbox
        }

	function imap_createFolder($mbox) {
		//imap_createmailbox
        }

	function imap_purge($mbox) {
		// elimina marcats per borrar => imap_expugne
	}

	function imap_saveDraft($mbox) {
        	// desar rsborrany, crec que amb imap_append        
        }

	function imap_getBody($mbox) {
		//imap_body
	}

	function get_folder() {
		$view_params=array();
                if ($_GET['view']=="") $folder="INBOX"; else {
                        $view = $this->dbi->get_record("SELECT * FROM kms_sys_views WHERE id='".$_GET['view']."'");
                        $view_=explode("&",$view['where']);foreach ($view_ as $p) { $l=explode("=",$p);$view_params[$l[0]]=$l[1]; }
                        $folder=$view_params['mbox'];
                }
		return $folder;
	}

	function decodeOverview($o) {
		if ($o->from==""&&$o[0]->from!="") $o=$o[0];
		if ($o->answered) $reply_status=1; else $reply_status=0;
		if (!$o->seen) $status=0; else $status=1;
		if ($o->deleted)  $deleted=1; else $deleted=0;
                if ($o->draft) $draft=1; else $draft=0;
                if ($o->flagged) $flagged=1; else $flagged=0;
		$from=utf8_encode(str_replace("_"," ",mb_decode_mimeheader($o->from)));
                $to=utf8_encode(str_replace("_"," ",mb_decode_mimeheader($o->to)));
                $subject=utf8_encode(str_replace("_"," ",mb_decode_mimeheader($o->subject)));
                $in_reply_to=htmlentities(str_replace("_"," ",mb_decode_mimeheader($o->in_reply_to)));
		$mail=array("uid"=>$o->uid,"creation_date"=>date('Y-m-d H:i',strtotime($o->date)),"reply_status"=>$reply_status,"status"=>$status,"deleted"=>$deleted,"draft"=>$draft,"flagged"=>$flagged,"from"=>$from,"to"=>$to,"cc"=>"","cco"=>"","subject"=>$subject,"in_reply_to"=>$in_reply_to,"recent"=>$o->recent);
		return $mail;
	}

	function onBrowse($mod,$view) {
		$account = $this->dbi->get_record("SELECT * FROM kms_planner_mail_accounts WHERE email='".$this->user_account['email']."'");
		if (!$account['id']) return; //no mail account
		$mbox=$this->imap_connect($account,$this->get_folder());
		// ---- ordenacio de mailbox ---------------
		$sort_methods=array("creation_date"=>SORTDATE,"from"=>SORTFROM,"subject"=>SORTSUBJECT,"to"=>SORTTO,"cc"=>SORTCC,"size"=>SORTSIZE);	
		if ($_GET['sortby']!="") $this->orderby=$_GET['sortby'];
		if ($_GET['sortdir']!="") $this->sortdir=$_GET['sortdir'];
		if ($this->sortdir=="asc") $sd=0; else $sd=1;
		$sorted_mbox = imap_sort($mbox, $sort_methods[$this->orderby], $sd,SE_UID);  //,SE_UID);
		// ----- informacio de missatges (millor cridar-se via ajax colapsar) -----------
		$MC = imap_check($mbox);
		$this->num_rows=$MC->Nmsgs;
		$read_from=$mbox[0];  if ($read_from=="") $read_from=1;
		$read_to=$MC->Nmsgs; $read_to=$read_from+100;
	
		if ($_GET['page']=="") $page=1; else $page=$_GET['page'];
		$index_to=$page*$this->per_page;
		$index_from=$index_to-$this->per_page;
		if ($index_to>$MC->Nmsgs) $index_to=$MC->Nmsgs;
		if ($index_to>0) $index_to--; //begins with 0
		//echo "INDEX:".$index_from.":".$index_to."<br>";
		$this->nrows=$index_to-$index_from;
		if ($this->nrows==0) return;
		$read_from=$sorted_mbox[$index_from];
		$read_to=$sorted_mbox[$index_to];
		//echo "READ :".$read_from."..".$read_to;
		$result = imap_fetch_overview($mbox, $read_from.":".$read_to,FT_UID);
		$this->data=array();$n=0;
		foreach ($result as $o) {
			$mailinfo = $this->decodeOverview($o);
			$mailinfo['id']=$n;
			$mailinfo['account_id']=$account_id;
			array_push($this->data,$mailinfo);
			$n++;
		}
		// newer first
		$this->data=array_reverse($this->data,false);
		$_data=array();$i=0;
		foreach ($this->data as $d) {
			$_data[$i]=$d;
			$_data[$i]['id']=$i; //canviem ids
			$i++;
		}
		$this->data=$_data;

		imap_close($mbox);
			
	} //onBrowse

	function onEdit($mod,$uid) {
		$account = $this->dbi->get_record("SELECT * FROM kms_planner_mail_accounts WHERE email='".$this->user_account['email']."'");
                $mbox=$this->imap_connect($account,$this->get_folder());
		if ($_GET['_']=="e") $this->data=$this->getMail($mbox,$uid);
		imap_close($mbox);
	}

	function onAdd($mod) {
		$this->hidden = array("uid","rely_status","status","in_reply_to","headers","structure","deleted","size");
	}

	function getMail($mbox,$uid) {
		if ($uid=="") die('[planner_mail] Error: Param UID invalid for getMail function');
		
		$data = $this->decodeOverview(imap_fetch_overview($mbox, $uid, FT_UID));
		// add headers
		$headers = imap_fetchheader($mbox, $uid, FT_UID);
		$data['headers']=$headers;
		// add body
		$body="";
                        // BODY
                        $s = imap_fetchstructure($mbox, $uid, FT_UID);//>msgno);
                        if (!$s->parts) {  // simple
				$type="simple";
                                $body=$this->getpart($mbox,$uid,$s,0,$type);  // pass 0 as part-number
				$body= $this->getBody($body);
				if ($body=="") $body = "<div style='padding:20px'>".imap_body($mbox, $uid, FT_UID)."</div>";
                        } else {  // multipart: cycle through each part
				$type="multipart";
                              foreach ($s->parts as $partno0=>$p) $body.=$this->getpart($mbox,$uid,$p,$partno0+1,$type);
				$body= $this->getBody($body);
                        }
		$data['body']=$body;
		return $data;
	}

	function isNewLine($line) {
	        $line = str_replace("\r", '', $line);
        	$line = str_replace("\n", '', $line);
	        return (strlen($line) === 0);
	}

	 function getBody($rawEmail) {
		$lines = preg_split("/(\r?\n|\r)/", $rawEmail);
		$i = 0;
	        foreach ($lines as $line) { 
			if(self::isNewLine($line)) { $rawBodyLines = array_slice($lines, $i); break; }
			$i++;
		}
	        $body = '';
	        $detectedContentType = false;
	        $contentTransferEncoding = null;
	        $charset = 'ASCII';
	        $waitingForContentStart = true;
	
	        if ($this->returnType == "") $contentTypeRegex = '/^Content-Type: ?text\/html/i';
	       			        else $contentTypeRegex = '/^Content-Type: ?text\/plain/i';
	        
	        // there could be more than one boundary
	        preg_match_all('!boundary=(.*)$!mi', $rawEmail, $matches);
	        $boundaries = $matches[1];
	        foreach($boundaries as $i => $v) $boundaries[$i] = str_replace(array("'", '"'), '', $v);
	        foreach ($rawBodyLines as $line) {
	            if (!$detectedContentType) {
	                if (preg_match($contentTypeRegex, $line, $matches)) $detectedContentType = true;
	                if(preg_match('/charset=(.*)/i', $line, $matches)) $charset = strtoupper(trim($matches[1], '"')); 
	            } else if ($detectedContentType && $waitingForContentStart) {
	                
	                if(preg_match('/charset=(.*)/i', $line, $matches)) $charset = strtoupper(trim($matches[1], '"')); 
	                if ($contentTransferEncoding == null && preg_match('/^Content-Transfer-Encoding: ?(.*)/i', $line, $matches)) {
	                    $contentTransferEncoding = $matches[1];
	                }                
	                if (self::isNewLine($line)) $waitingForContentStart = false;
	            } else { 
	                // collecting content until we find the delimiter
	                if (is_array($boundaries)) { if (in_array(substr($line, 2), $boundaries)) break; } 
			// remove last boundary
			$isboundary=false;foreach ($boundaries as $boundary) { if (strpos($line,trim($boundary))) { $isboundary=true;break; } }
	                if (!$isboundary) { $body .= $line . "\n"; }
	            }
	        }
	        if (!$detectedContentType) $body = implode("\n", $rawBodyLines);
	        // removing trailing new lines
	        $body = preg_replace('/((\r?\n)*)$/', '', $body);
	
	        if ($contentTransferEncoding == 'base64') $body = base64_decode($body);
	        else if ($contentTransferEncoding == 'quoted-printable') $body = quoted_printable_decode($body);        
	        if($charset != 'UTF-8') {
	            // FORMAT=FLOWED, despite being popular in emails, it is not supported by iconv
	            $charset = str_replace("FORMAT=FLOWED", "", $charset);
		    $bodyCopy = $body; 
		    if ($charset=="ASCII"&&$body!="") $body="<div style='padding:20px'>".str_replace("\n","<br>",htmlentities($body))."</div>";  
					else if ($body!="") $body= "<div style='padding:0px 20px 0px 20px'>".iconv($charset, 'UTF-8//TRANSLIT', $body)."</div>"; 
	            if ($body === FALSE) { 
	                $body = utf8_encode($bodyCopy);
	            }
	        }
	
	        return $body;
	}

	function getpart($mbox,$uid,$p,$partno,$type) {
	    // $partno = '1', '2', '2.1', '2.1.3', etc for multipart, 0 if simple
	    global $htmlmsg,$plainmsg,$charset,$attachments;
	    // DECODE DATA
	    if ($partno) { //multipart
			$data =imap_fetchbody($mbox,$uid,$partnoi,FT_UID);
		} else { 
			// simple
			$data =imap_body($mbox,$uid,FT_UID);
//			$data=str_replace("\r","<br>",$data);
		//	$data=htmlentities($data);
			//echo mb_detect_encoding($data);
			//$data=urlencode($data);
//			$data=str_replace("","<br>",$data);
		}
	     
	    // Any part may be encoded, even plain text messages, so check everything.
	    if ($p->encoding==4)
	        $data = quoted_printable_decode($data);
	    elseif ($p->encoding==3)
	        $data = base64_decode($data);
	    // PARAMETERS
	    // get all parameters, like charset, filenames of attachments, etc.
	    $params = array();
	    if ($p->parameters)
	        foreach ($p->parameters as $x)
	            $params[strtolower($x->attribute)] = $x->value;
	    if ($p->dparameters)
	        foreach ($p->dparameters as $x)
	            $params[strtolower($x->attribute)] = $x->value;
	    // ATTACHMENTS
	    // Any part with a filename is an attachment,
	    // so an attached text file (type 0) is not mistaken as the message.
	    if ($params['filename'] || $params['name']) {
	        // filename may be given as 'Filename' or 'Name' or both
	        $filename = ($params['filename'])? $params['filename'] : $params['name'];
	        // filename may be encoded, so see imap_mime_header_decode()
	        $attachments[$filename] = $data;  // this is a problem if two files have same name
	    }
	
	    // TEXT
	    if ($p->type==0 && $data) {
	        // Messages may be split in different parts because of inline attachments,
	        // so append parts together with blank row.
	        if (strtolower($p->subtype)=='plain')
	            $plainmsg.= trim($data)."\n\n";
	        else
	            $htmlmsg.= $data ."<br><br>";
	        $charset = $params['charset'];  // assume all parts are same charset
	    }
	
	    // EMBEDDED MESSAGE
	    // Many bounce notifications embed the original message as type 2,
	    // but AOL uses type 1 (multipart), which is not handled here.
	    // There are no PHP functions to parse embedded messages,
	    // so this just appends the raw source to the main message.
	    elseif ($p->type==2 && $data) {
	        $plainmsg.= $data."\n\n";
	    }
	
	    // SUBPART RECURSION
	    if ($p->parts) {
	        foreach ($p->parts as $partno0=>$p2)
	            $this->getpart($mbox,$uid,$p2,$partno.'.'.($partno0+1));  // 1.2, 1.2.1, etc.
	    }

	    if ($type=="multipart") { 
//                        $htmlmsg=preg_replace( '/style=(["\'])[^\1]*?\1/i', '', $htmlmsg, -1 );
/*			$htmlmsg=preg_replace( '/face=(["\'])[^\1]*?\1/i', '', $htmlmsg, -1 );
			$htmlmsg=preg_replace( '/size=(["\'])[^\1]*?\1/i', '', $htmlmsg, -1 );
			$htmlmsg=preg_replace( '/font-family[^\1]*?;/i', '', $htmlmsg, -1 );
			$htmlmsg=strip_tags($htmlmsg);
*/
			// remove empty tags
			//$pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/";  
			//$htmlmsg=preg_replace($pattern, '', $htmlmsg);


			return $htmlmsg; 
		} else { return $plainmsg; }
	}

} //class
?>
