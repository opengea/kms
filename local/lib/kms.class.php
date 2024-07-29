<?php
// ******************************************************************
//
// 	Intergrid KMS Kernel Class
//
//	Package version : 2.1
//      Last update     : 12/01/2015
// 	Author		: Jordi Berenguer
// 	Company 	: Intergrid Tecnologies del coneixement SL
// 	Country		: Catalonia
//      Email           : j.berenguer@intergrid.cat
//	Website		: www.intergrid.cat
//
// ******************************************************************

if (!isset($_SESSION)) session_start();
//Load KMS Configuration
include "/etc/kms/kms.conf.php";
// Security firewall
include "/usr/share/kms/lib/firewall/polices.php";
// Http communitations setup
require "/usr/local/kms/lib/http_setup.php";
// Database management class
include_once("/usr/local/kms/lib/dataDBI.php");
// Template class 
include_once("/usr/local/kms/lib/template.php");
// Application Interface class
include_once("/usr/local/kms/lib/appInterface.class.php");
// Send Email Class
include_once("/usr/local/kms/lib/mail/email.class.php");
// Tools
include_once("/usr/local/kms/lib/include/functions.php");

class intergridKMS {

	// Secutiry key
	private static $authkey="JADF7320cSJdcj3750492x42dj244";

	// Global variables
	var $version		= "2.1"; //load from sys_kms_version
	var $client_account	= array(); // kms client on master kms server
        var $extranet           = array(); // client extranet configuration
	var $user_account	= array(); // user account in client database
	var $dblinks		= array(); // database connections
	var $enkey		= '<W(574KX3-s-7EI-8dQq[XoHamFk,V';
        var $enpwd              = "mu64PO9Pm3LTHsooSPOdvrsKJdphLLAG1PLhJuKgs3I=";//localhost

	// Constructor
	function intergridKMS() {
	  global $setup;
	  $this->_debug();
	  if ($_SESSION['exec_mode']=="api") $this->_set_domain($_SESSION['domain']); else $this->_get_domain(); 
	  $this->dbi = new dataDBI();
	  $this->tpl = new template($this->dbi->db_connect('client',$this->dbi));
	  if ($_SESSION['exec_mode']=="api") $this->_set_domain($_SESSION['domain']); else $this->_get_domain();
	  $this->kms_datapath = "/var/www/vhosts/".$this->current_domain."/subdomains/data/httpdocs/";
	  $this->_get_client_account($this->dbi);
	  $this->_setup_language("login");
	  $this->_setup_service($_SESSION['exec_mode']);
	  if ($this->exec_mode=="extranet") $this->_get_extranet_config();
  	  $this->_check_session();
	  $this->_get_user($_SESSION['username']);
	  $this->_set_default_app();
	  $this->_setup_language("interface");
	}

	// intergridKMS getInstance function
	function &getInstance() {
			$kms=& appInterface::getInstance(0); // no hi ha mes anidacio
			return $kms;
	//	$kms = new appInterface(0); // cridem al constructor
	}

	// Starts KMS
	function Start($client_account,$user_account,$extranet,$dblinks) {
		$this->extranet=$extranet;
		if ($_GET['mod']!="") $mod=$_GET['mod']; else $mod="sys_apps";
		$_SESSION['return_mod']=""; //init
		if ($_GET['tab']!=0) { // extra tab
			//mother tab
			$this->tab[0]->mod[1] = & mod::getInstance(0,$mod,$client_account,$user_account,$dblinks);

			$current_tab_mod=$this->tab[0]->mod[1]->_get_mod_current_editor_tab($this->tab[0]->mod[1]);
			//save editorTabs of main module
			$_SESSION['editorTabs']=$this->tab[0]->mod[1]->editorTabs;
			if ($current_tab_mod!=$_GET['mod']) {
					$mod=$current_tab_mod;
					include_once "/usr/local/kms/lib/mod/{$current_tab_mod}.php";
			} else {
				$_SESSION['motherTabId']=$_GET['id'];
				$_SESSION['return_mod']=$_GET['mod'];
			}
		}
		if ($_GET['tabmod']=="") $_SESSION['motherTabId']=$_GET['id']; //save id
		if ($client_account=="") die('[KMS] Error: client_account not defined');
		if ($user_account==""&&($_SESSION['username']!="admin")) die('[KMS] Error: Undefined user_account on KMS Start');
		if ($_SESSION['exec_mode']!="api") $this->tab[0]->mod[0] = & mod::getInstance(0,$mod,$client_account,$user_account,$dblinks);
                if ($_SESSION['exec_mode']=="api"&&$_GET['mod']!="sys_apps") {
                        $this->tab[0]->mod[0] = & mod::getInstance(0,$mod,$client_account,$user_account,$dblinks);
                }

		if ($_GET['action']=="printDataBrowser") { //&&$_GET['action']!=""&&$_REQUEST['_action']!="") {
		// KMS API Ajax call
			 $this->_show_dom_head($client_account,$user_account,$extranet);
			 echo $this->tpl->fetch("interfaces/headers/print.php");
			 $this->tab[0]->mod[0]->page_rows = 90000; 
			 $this->tab[0]->mod[0]->dm->Main($this->tab[0]->mod[0]);
		} else if ($_REQUEST['_action']=="export") {
			$this->tab[0]->mod[0]->page_rows = 90000; 
                         $this->tab[0]->mod[0]->dm->Main($this->tab[0]->mod[0]);
		} else if ($_SESSION['exec_mode']=="api") {
			//api mode
		}  else {
		// Regular call : show  KMS interface
                $this->_show_headers($client_account,$user_account,$extranet);
//if ($_SERVER['REMOTE_ADDR']=='88.12.33.163') print_r($this->tab[0]->mod[0]);
		$this->tab[0]->mod[0]->dm->Main($this->tab[0]->mod[0]);
		$this->_foot();	
		}
		$this->dbi->disconnect();
	}

	function _check_session() {
		if ($_GET['password-lost']==1) { 
			 $this->_lost_password();
		} else if ($_POST['login']!=""&&$_POST['passwd']!="") {
		 	// we are logging in...
			if (!$this->_do_login()) $error=true;
	        } else if (!$_SESSION['user_logged']) {
	                   // go to login screen
			if ($_SESSION['exec_mode']!="api") {
			   $this->_login_screen();
	                   $footer_align="center";
	                   exit;
			} else { 	
				return false;
			}
		 } else if ($_GET['_']=="logout") {
				// bye, bye
				$this->_logout();
		 } else if ($_SESSION['user_logged']) {
				// do nothing, continue...	
				return;
		}
	}

	function _logout($silent) {
		$_SESSION['user_logged']=false;
		session_unset();
		session_destroy();
		if ($silent!=1) header ( 'Location: /');
	}

	function _get_user($username) {
		// maintain mysqli_connect here
		global $dblinks;
		$dblink = mysqli_connect($this->client_account['dbhost'],$this->client_account['dbuser'],$this->client_account['dbpasswd'],$this->client_account['dbname']);
               if (!$dblink) {     echo "[kms.class] _get_user error:".mysqli_error($dblink);    exit;}

		mysqli_query($dblink,"SET NAMES 'utf8'"); //mysqli_set_charset('utf8',$dblink);
                $result = mysqli_query($dblink,"SELECT * FROM kms_sys_users WHERE (username='".$username."' and status='active')");

                if (!$result) {     echo "[kms.class] _get_user error:".mysqli_error($result);    exit;}

                $this->user_account = mysqli_fetch_assoc($result);
	}


	function _do_login($login,$passwd) {
			global $setup,$dblinks;
			if ($login=="") $login= $_POST['login'];
			if ($passwd=="") $passwd= $_POST['passwd'];
                        // user authentication & authorization methods
                        $user=array();
			if ($this->client_account["uaa_mapping"]=="") {
                        // METHOD 1: User table kms_sys_users (metode recomenat, requereix taula sessio i configurar nombre usuaris i homefolder)
                                $this->_get_user($login);
                                if (((strtolower($login) == strtolower($this->user_account['username']))&&(($passwd==$this->decrypt($this->user_account['upassword']))||(md5($passwd)==$this->user_account['upassword']))&&($this->user_account['username']!=""))||(($login==$setup['super_admin_user'])&&($passwd==$setup['super_admin_pass'])))        {
                                if ($this->user_account['username']=="") $this->user_account['username']=$login;
                                $this->user_account['user_name']=$this->user_account['username'];
                                $this->user_account['client_name']=$this->client_account['client_name'];
                                if ($this->user_account['groups']=="root") $this->user_account['groups']="";
                                $this->_login_in($this->user_account);
                                }

				//try admin 
				if (((strtolower($login) == strtolower($this->client_account["username"]))&&($passwd==$this->client_account["password"]))||(($login==$setup['super_admin_user'])&&($passwd==$setup['super_admin_pass']))) {
                        // METHOD 1: Extranet Password (single user) 
                                $user['user_name']=$login;
                                $user['client_name']=$this->client_account['client_name'];
                                $user['id']=$user['user_id'];
                                //get all groups
                                $result = mysqli_query($this->dblinks['client'],"SELECT name FROM kms_sys_groups"); if (!$result) { die("_check_session function (get groups) error 1:".mysqli_error($dblink)); }
                                $this->user_account=array();
                                $this->user_account['user_name']=$login;
                                $this->user_account['user_groups']=1;//$row[0];
                                $this->user_account['groups']=1;
                                $this->user_account['id']=$user['user_id'];
                                $this->user_account['client_name']=$this->client_account['client_name'];
                                $this->_login_in($this->user_account);
				}

                                if ($_SESSION['exec_mode']!="api") $this->_login_screen("login_failed"); else return false;
                                exit;
			} else if (((strtolower($login) == strtolower($this->client_account["username"]))&&($passwd==$this->client_account["password"]))||(($login==$setup['super_admin_user'])&&($passwd==$setup['super_admin_pass']))) {
                        // METHOD 1: Extranet Password (single user) 
                                $user['user_name']=$login;
                                $user['client_name']=$this->client_account['client_name'];
                                $user['id']=$user['user_id'];
                                //get all groups
                                $result = mysqli_query($this->dblinks['client'],"SELECT name FROM kms_sys_groups"); if (!$result) { die("_check_session function (get groups) error 2:".mysqli_error($dblink)); }
                                $this->user_account=array();
                                $this->user_account['user_name']=$login;
                                $this->user_account['user_groups']=1;//$row[0];
                                $this->user_account['groups']=1;
                                $this->user_account['id']=$user['user_id'];
                                $this->user_account['client_name']=$this->client_account['client_name'];
                                $this->_login_in($this->user_account);

                        } else {

                        // METHOD 3: Other user table mapped
                                $uaa_mapping = explode(";", $this->client_account["uaa_mapping"]);
                                //0localhost;1dbuser;2dbpass;3dbname;4dbtable;5userfield;6userpasswfield;7usergroupsfield;8tablegroups;9fieldgroupname
                                $dblink = mysqli_connect($uaa_mapping[0],$uaa_mapping[1],$uaa_mapping[2],$uaa_mapping[3]);
				mysqli_query($dblink,"SET NAMES 'utf8'"); //mysqli_set_charset('utf8',$dblink);
                                $result = mysqli_query($dblink,"SELECT ".$uaa_mapping[5].",".$uaa_mapping[6].",".$uaa_mapping[7]." FROM ".$uaa_mapping[4]." WHERE ".$uaa_mapping[5]."='".$login."'");
                                if (!$result) {     echo "login error:".mysqli_error();    exit;}
                                $this->user_account = mysqli_fetch_array($dblink,$result);
                                if ((($login == $this->user_account[0])&&($passwd==$this->user_account[1]))||(($login==$setup['super_admin_user'])&&($passwd==$setup['super_admin_pass'])))
                                {
                                        session_start();
                                        $_SESSION['user_logged'] = true;
                                        $_SESSION['lang'] = $this->client_account["lang"];
                                        // root user is the super user
                                        if ($this->user_account[2]=="root") $this->user_account[2]="";
                                        $_SESSION['user_groups'] = $this->user_account[2];
                                        //echo "GRUPS:".$this->user_account[2];exit;
                                        header( 'Location: /');
                                        echo "</body></html>";
                                        exit;
                                }
                        }
			return false;
	}

        function _login_in($user) {
                session_start();
                $_SESSION['user_logged'] = true;
                $_SESSION['user_name']=$user['user_name'];
		$_SESSION['username']=$user['user_name'];
                $_SESSION['user_id']=$user['id'];
                $_SESSION['client_name']=$user['client_name'];
                $_SESSION['user_groups'] = $user['groups'];
                $_SESSION['user_realname'] = $user['realname'];
                $_SESSION['max_users'] = $user['max_users'];
                $_SESSION['homefolder'] = $user['homefolder'];
                $_SESSION['user_folder'] = $user['dr_folder'];
                $_SESSION['user_lang'] = $user['language'];
                $this->_log_session('login');
                if ($_SESSION['exec_mode']!="api") {
			 header( 'Location: /');
                	echo "</body></html>";
			exit;
		}
//              exit;
        }

	function _lost_password() {
                
		$dblink= mysqli_connect($this->client_account['dbhost'],$this->client_account['dbuser'],$this->client_account['dbpasswd'],$this->client_account['dbname']);
                mysqli_query($dblink,"SET NAMES 'utf8'"); //mysqli_set_charset('utf8',$dblink);
                if ($_POST['email']=="") {
                $result = mysqli_query($dblink,"SELECT * FROM kms_sys_extranet WHERE id=1"); //username='admin' and status='active')");
                if (!$result) {     echo "forget error:".mysqli_error();    exit;}
                $extranet= mysqli_fetch_array($dblink,$result);
                $recover=true;
                $admin_usern=$extranet['admin_username'];
                $admin_email=$extranet['admin_email'];
                $admin_passw=$extranet['admin_password'];
		
		//isp_extranets
		$select ="select client_id,username,password from kms_isp_extranets where status='online' and subdomain='".$this->current_subdomain."' and domain='".$this->current_domain."'";
		$result = mysqli_query($this->dblinks['master'],$select);
		$extranet=mysqli_fetch_assoc($dblink,$result);
		//client
		$select ="select email from kms_ent_clients where id=".$extranet['client_id'];
		$result = mysqli_query($this->dblinks['master'],$select);
                $client=mysqli_fetch_assoc($result);
		$admin_usern=$extranet['username'];
                $admin_email=$client['email'];
                $admin_passw=$extranet['password'];

                } else {
                $result = mysqli_query($this->dblinks['master'],"SELECT * FROM kms_sys_users WHERE (email='".$_POST['email']."' and status='active')");
                if (!$result) {     echo "forget error:".mysqli_error();    exit;}
                $this->user_account = mysqli_fetch_array($result);
                if ($this->user_account['upassword']!="") $recover=true;
                $admin_usern=$this->user_account['username'];
                $admin_email=$this->user_account['email'];
                $admin_passw=$this->user_account['upassword'];
                }
                if ($recover) {
                $subject = _KMS_LOGIN_FORGET_SUBJECT;
                $body = str_replace("EXTRANET",$_SERVER['SERVER_NAME'],utf8_decode(_KMS_LOGIN_FORGET_BODY))."<br><br>"._KMS_GL_USERNAME.": ".$admin_usern."<br>"._KMS_GL_PASSWORD.": ".$admin_passw."<br><br>".$_SERVER['SERVER_NAME'];
                $email = new Email("suport@intergrid.cat", $admin_email, $subject, $body, 1);
                $goodemail = $email->send();
                if ($goodemail) {echo "<h3 style='text-align:center;font-size:13px;font-weight:normal;height:20px;background-color:#dedced;color:#333;padding-top:3px'>"._KMS_LOGIN_FORGET_SENT."</h3>";$this->_login_screen();} else die("Cannot send your password. An error has occured. Please contact your administrator.");
                exit;
                } else {
                echo _KMS_LOGIN_FORGET_INCORRECT;
                }
	}

	function _log_session($action) {

		//last login ip         
                $query="select ip_address from kms_sys_sessions where username='".$_SESSION['user_name']."' order by datetime desc limit 1";
                $result = mysqli_query($this->dblinks['client'],$query);
                $last=mysqli_fetch_array($result);

		// adds user session into kms_sys_sessions table
                $query = "INSERT INTO kms_sys_sessions (`type`,action,username,datetime,ip_address) VALUES ('{$action}','{$_SERVER['QUERY_STRING']}','".$_SESSION['user_name']."','".date('Y-m-d H:m:s')."','".$_SERVER['REMOTE_ADDR']."')";
                $result = mysqli_query($this->dblinks['client'],$query);
                if (!$result) {  die ("LOGIN ERROR: UNABLE TO INSERT SESSION IN kms_sys_sessions.".$query); }

                if ($last['ip_address']!=$_SERVER['REMOTE_ADDR']) {
                $body="user <b>".$_SESSION['user_name']."</b> has logged from ".$_SERVER['REMOTE_ADDR']." which is different than last login IP address ".$last['ip_address']."\n";
                $from=$to="alertes@intergrid.cat";
                if ($last['ipaddress']!=$_SERVER['REMOTE_ADDR'])  $this->emailNotify("Intergrid intranet : possible break-in attempt",$body,$from,$to);
                }



	}


	function _group_permissions($group,$user_groups_str) {
		if ($user_groups_str=="") $user_groups_str=$_SESSION['user_groups']; 
		$user_groups = explode (",", $user_groups_str);	
		return (in_array($group,$user_groups));
	} 

        function _head($mod,$title,$content_type) {
               if (!isset($mod->tpl)) $this->tpl = new template();
               $mod->tpl->set('title',$title);
               $mod->tpl->set('content_type',$content_type);
               $mod->tpl->set('msgs',$_SESSION[$mod->table]["msgs"]);
//             if ($_SESSION['xshowMenu']!="") $mod->showMenu=$_SESSION['xshowMenu'];
 //              $mod->tpl->set('showMenu', $mod->showMenu);
               $_SESSION[$mod->table]["msgs"] = array();
               $title="";
//                echo $mod->tpl->fetch("interfaces/headers/".$mod->extranet['header_style'].".php");
//             echo $this->tpl->fetch("head.php");
        }

        function _foot($mod) {
            $this->tpl->set("debug",$this->dbi->debug);
            $this->tpl->set("version",$this->version);
            $this->tpl->set("footer_align", "right");
           // echo $this->mod->extranet['header_style']."/common_footer.php";
            echo $this->tpl->fetch($this->extranet['theme']."/common_footer.php",$this);
        }

        // draws a pretty error page
        function _error($head,$msg,$type) {
                $this->_head($this,$head,null);
                $this->tpl->set('msg',$msg);
                //echo $msg;
                echo $this->tpl->fetch('error.php');
                $this->_foot($this);
		echo $this->tpl->fetch("interfaces/headers/".$this->extranet['header_style'].".php");
//                echo $this->tpl->fetch("head.php");
		if ($type=="fatal") die();
		if ($type=="logout") { $this->_logout(1);die(); }
		$_SESSION['msg_pause']=true;
        }

        function _redirect($url, $msg="", $delay=1) {
            if (headers_sent()) {
                $delay = ($this->dbi->debug ? 3 : $delay);
                echo "<meta http-equiv=\"refresh\" content=\"{$delay};URL={$url}\">";
            if (!empty($msg)) echo "<div id=\"kms_msg\">{$msg}</div><script>$('#kms_msg').slideToggle()</script>"; 
                exit();
            } else {
                header("location: {$url}");
                exit();
            }
        }

        // return the parameter for GET/POST/SESSION and set if not defined
        function _get_param($var,$val) { 
                if ($_POST[$var]) {
                        $_SESSION[$this->table][$var] = $_POST[$var];
                        return $_POST[$var];
                } elseif ($_GET[$var]) {
                        $_SESSION[$this->table][$var] = $_GET[$var];
                        return $_GET[$var];
                } elseif ($_SESSION[$this->table][$var]) {
                        return $_SESSION[$this->table][$var];
                } else {
                        return $val;
                }
        }

	// reset SESSION params
        function _reset_param($var) {
                $this->$var=$_SESSION[$this->table][$var]="";
        }


        function _get_app() {
		if ($_SESSION['username']=="admin"||$_SESSION['username']=="root")  $cond="`group` like '%'";
                else $cond="`group`=".str_replace(","," OR `group`=",$_SESSION['user_groups']);
                $select = "SELECT * from kms_sys_apps where status='active' and keyname='".$_GET['app']."' and ($cond) limit 1";
                $result=mysqli_query($this->dblinks['client'],$select);
                $app = mysqli_fetch_array($result);
                return $app;
        }

	function _explode($str) {
		return explode(",", $str);
	}

        function _get_mods($app) {
                $mods = $this->_explode($app['modules']);
                return $mods;
        }

	function _get_ext_mods($app) {
		$mods = $this->_explode($app['ext_modules']);
                return $mods;
        }

        function _get_mod_path($mod) {
                // get current mod path (model object definition)
                if (file_exists("/usr/local/kms/lib/mod/".$mod.".php")) {
                        // default configuration
                        return "/usr/local/kms/lib/mod/".$mod.".php";
                } else if (file_exists($this->kms_datapath.$mod.".php")) {
                        // client mod
                        return $this->kms_datapath.$mod.".php";
                } else {
                        //fer funcio d'error...
                        include PATH_TPL.$this->extranet['theme']."/common_header.php";
                        echo $this->tpl->fetch("interfaces/headers/".$this->extranet['header_style'].".php");
                        echo "<div style='background-color:#f88;width:100%;border:1px solid #f00;border-left:0px;border-right:0px;vertical-align:middle;padding:20px;font-size:13px'>Module '".$mod."' not found. It must exist either in mod directory, in client data folder or both.</div>";
                        return false;
                }
        }

	function _lock_screen() {
	// lock screen
	}

	public function _get_domain() {
		//$current_domain = substr($_SERVER['SERVER_NAME'],strpos($_SERVER['SERVER_NAME'], '.')+1,strlen($_SERVER['SERVER_NAME']));
		if (isset($_SERVER['SERVER_NAME']))  $server = $_SERVER['SERVER_NAME']; 
				         	else $server = $_SERVER['HTTP_HOST'];
		$first = strpos($server, '.'); 
		$last = strrpos($server, '.');
		if ($first!=$last) {
	        $this->current_subdomain = substr($server,0,$first);
 	        $this->current_domain = substr($server,$first+1,strlen($server));
		} else {
	        $this->current_domain = substr($_SERVER['SERVER_NAME'],0,strlen($server));
		}
	}

        public function _set_domain($domain) {
                $this->current_subdomain = "extranet";
                $this->current_domain = $domain;
        }

	function _get_extranet_config() {
		if (!$this->dblinks['client']) { 
	//		echo "set dblink 2 "; 
			$this->dblinks['client']=$this->dbi->db_connect('client',$this->dbi); 
		}
		$select="select * from kms_sys_extranet limit 1";
		$result=mysqli_query($this->dblinks['client'],$select);
		if (!$result) die ("[KMS Kernel Class] Unable to connect to database. Check extranet setup : ".mysqli_error());
		$this->extranet=mysqli_fetch_array($result);
	        if ($this->extranet['bg_image']=="") $this->extranet['bg_image']="default";
	        if ($this->extranet['text_color']=="") $this->extranet['text_color']="333333";
	}

	function _set_default_app() {
		if ($this->user_account['autorun_app']!=""&&$_GET['app']=="") $_GET['app']=$this->user_account['autorun_app'];
                if ($this->extranet['autorun_app']!=""&&$_GET['app']==""&&$_SESSION['username']!="root") $_GET['app']=$this->extranet['autorun_app'];
	}

        function _get_client_account($dbi) {

                if (!$dbi->is_set) die('[kms.class] _get_client_account() > dbhost not defined');
                if (!$this->dblinks['master']) {
			//set link to kms master database
                        $this->dblinks['master']=$dbi->db_connect('master',$dbi,"JADF7320cSJdcj3750492x42dj244");
                }
                if (!$this->dblinks['master']) die('[KMS.class] _get_client_account > No valid kms database connection!');
                if ($this->current_subdomain=="www") $this->current_subdomain="extranet";
                $select="SELECT * FROM kms_isp_extranets WHERE status='online' and domain='".$this->current_domain."' and subdomain='".$this->current_subdomain."'";

		$result = mysqli_query($this->dblinks['master'],$select);
                if (!$result) {
                        if (isset($fplog)) report($fplog,mysqli_error());
                        die ("[KMS.class] KMS client account not found. Check your configuration for the current domain name:<br>".$select."<br>host:".$dbi->ddbb['master']['dbhost']);
                }
		$this->client_account = mysqli_fetch_array($result);
		if (!$this->client_account)  die ("[KMS.class] _get_Client_account: unable to get client account:<br>".$select."<br>host:".$dbi->ddbb['master']['dbhost']);

                $this->client_account['domain']=str_replace("beta.","",$this->client_account['domain']);
                if (count($this->client_account['domain'])==0)  {
                        $kms_fail=true;
                        include "/usr/local/kms/tpl/default.php";exit;
                }
                // set client database configuration
                $dbi->ddbb['client']=array();
                $dbi->ddbb['client']['dbhost']=$this->client_account['dbhost'];
                $dbi->ddbb['client']['dbuser']=$this->client_account['dbuser'];
                $dbi->ddbb['client']['dbpass']=$this->client_account['dbpasswd'];
                $dbi->ddbb['client']['dbname']=$this->client_account['dbname'];
                $dbi->ddbb['client']['dbport']=$this->client_account['dbport'];


	}

	function _setup_language($zone) {

		if ($zone!="login") $_SESSION['lang']="";

	        // If language is forced by interface
	        if (isset($_GET['lang'])) $_SESSION['lang']=$_GET['lang'];
		// If language is not set
	        if ($_SESSION['lang']=="") { 
			// Sets as default user language, and if not defined extranet language
			if ($_SESSION['user_lang']!="") $_SESSION['lang']=$_SESSION['user_lang']; else $_SESSION['lang']=$this->client_account['default_lang'];
		}
	        $case=true;
		if ($_SESSION['lang']=="ct") $_SESSION['lang']="ca";
	        include_once( '/usr/local/kms/lang/'.$_SESSION['lang'].'.php');
	}

	function _setup_service($force)  {
		if ($force=="api") {
			 $this->exec_mode="api";
		} else if (($this->current_subdomain=="extranet")||($this->current_subdomain=="intranet")||($this->current_subdomain=="control")) {
		        $this->exec_mode="extranet";
		        $this->title=ucfirst($this->current_subdomain);
		} else {
		        $this->exec_mode="website";
		}
		$_SESSION['exec_mode']=$this->exec_mode;
	}


	function _debug() {
		// debuging
		if ($_GET['debug']==1||DEBUG_MODE==1||$this->debug) {
			ini_set('display_errors',1);
			error_reporting(E_ALL&~E_NOTICE&~E_WARNING&~E_STRICT);
		} else {
			ini_set('display_errors',0);
			error_reporting(E_ALL&~E_NOTICE&~E_WARNING&~E_STRICT&~E_DEPRECATED);
		}

	}

   function ssh_exec($host,$command,$key) {


        // security check
        if ($key==self::$authkey) {
                  $conn = ssh2_connect($host, 22, array('hostkey'=>'ssh-rsa'));
                  if (!ssh2_auth_password($conn, 'root', $this->decrypt($this->enpwd))) $this->_error("","[kms.class] ssh_exec: Login failed trying to connect to '$host' host","fatal");
//                  $conn = ssh2_connect($host, 22, array('hostkey'=>'ssh-rsa'));
//               if (!ssh2_auth_pubkey_file($conn, 'root', '/root/.ssh/id_rsa.pub', '/root/.ssh/id_rsa','secret')) $this->_error("","[kms.class] ssh_exec: Login failed trying to connect to '$host' host using public key","fatal");
                if (!($stream = ssh2_exec($conn, $command )) ) {
                        $this->_error("","[kms.class] ssh_exec: fail: unable to execute command\n");
                }  else {
                        // collect returning data from command
                        stream_set_blocking( $stream, true );

                        // Read the command output
                        $output = stream_get_contents($stream);
                        //$output = ""; while ($buf = fread($stream,4096)) $output .= $buf;

                        // Wait for the command to complete
                        $stderr = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
                        stream_set_blocking($stderr, true);

                        // Use stream_select to wait for the process to finish
                        $read = array($stream, $stderr);
                        $write = null;
                        $except = null;

                        if (stream_select($read, $write, $except, -1) === 1) {
                                // The process has finished; you can now process the output
                        } else {
                                // Handle the case where the process did not finish as expected
                         //       $this->_error("","[kms.class] ssh_exec: fail: command did not complete as expected\n");
                        }

                        // Close the streams and the connection
                        fclose($stream);
                        fclose($stderr);
                        //ssh2_disconnect($conn);

                        return $output;
                }
        }
        $this->_error("","[ssh_exec] : Unauthorized access. Invalid authkey.","fatal");
        return false;

   }

	function encrypt($string) {
	
	        $iv = mcrypt_create_iv(
	            mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
	            MCRYPT_DEV_URANDOM
	        );
	
	        $encrypted = base64_encode(
	            $iv .
	            mcrypt_encrypt(
	                MCRYPT_RIJNDAEL_128,
	                        hash('sha256', $this->enkey, true),
	                $string,
	                MCRYPT_MODE_CBC,
	                $iv
	            )
	        );
	
	        return $encrypted;
	}
	
	function decrypt($encrypted) {
	        $data = base64_decode($encrypted);
	        $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));
	
	        $decrypted = rtrim(
	            mcrypt_decrypt(
	                MCRYPT_RIJNDAEL_128,
	                hash('sha256', $this->enkey, true),
	                substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
	                MCRYPT_MODE_CBC,
	                $iv
		            ),
        	    "\0"
	        );
	
	        return $decrypted;
	}



   function emailNotify($subject,$body,$from,$to) {
		if ($from=="") $from="kms@intergrid.cat";
		if ($to=="") $to="sistemes@intergrid.cat";
		$email = new Email($from,$to,$subject,$body,1);
		$goodemail = $email->send();
		if (!$goodemail) $this->_error("","failed sending email notification of subject '$subject' to admin.");
  }

  function trace($msg) {
		//ob_start();//ob_end_flush();
		echo $msg."<br>";
		if(ob_start("ob_gzhandler")) {
			flush();
    			ob_flush();
		}
                //log
                $fp=fopen("/var/log/kms/kms.log","a");
                fwrite($fp,$msg);
                fclose($fp);
	}


}  // end intergridKMS class
?>
