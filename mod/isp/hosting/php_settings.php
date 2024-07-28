<?php
include "defaults.php";
$vhost=$this->dbi->get_record("select * from kms_isp_hostings_vhosts where id=".$_GET['xid'],$dblink_cp);
$server=$this->dbi->get_record("select * from kms_isp_servers where id=".$vhost['webserver_id'],$dblink_cp);

echo "<div style='background-color:#bbc2df;padding:10px;margin:-20px'><img src='https://control.intergridnetwork.net/kms/css/aqua/img/big/php.png'><br></div><br><br><br>";

// get real PHP version
$path="/var/www/vhosts/".$vhost['name']."/conf/";
$file_part="php-*";
$file=$file_part.".conf";
$results = array();
$list = glob($file);

$cmd="ls $file";
$cmd="find {$path} -name \"{$file}\" ! -name \"{$file_part}-*.conf\"";

$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." \"{$cmd}\"";
$output = $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
if (isset($output)) {
                $conf=substr($output,strpos($output,"php-")+4);
                $conf=trim(str_replace(".conf","",$conf));
		if ($conf!=$vhost['php_version']) {
		$query="update kms_isp_hostings_vhosts set php_version='".$conf."' where id=".$_GET['xid'];
	//	echo $query;
		$this->trace("Different php_version detected on virtual host ".$vhost['name'].", updating database");
		mysql_query($query);
		}		
}

if ($_POST['php_version']!="") {
	$this->trace("Updating php version from ".$vhost['php_version']." to ".$_POST['php_version']." on virtual host ".$vhost['name']);

	//comproba si existeix fitxer php
	$file="/var/www/vhosts/".$vhost['name']."/conf/php-".$vhost['php_version'].".conf";
	$cmd="if test -f \"".$file."\"; then\necho \"OK\"\nelse\necho \"KO\"\nfi";
	$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." \"{$cmd}\"";
	$output = $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
	if ($output=="KO") die ('ERROR: '.$file.' does not exist on '.$server['hostname']);
	if ($_POST['php_version']!=$vhost['php_version']) {
	//rename
	$new_file="/var/www/vhosts/".$vhost['name']."/conf/php-".$_POST['php_version'].".conf";
	$cmd="mv {$file} {$new_file}";
	$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." \"{$cmd}\"";
	$output = $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
	$file=$new_file;
	}
	//readfile
 	$cmd="cat $file";
        $command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." \"{$cmd}\"";
	$contents = $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");

	$last_character_position=0;
	$config_lines = explode("\n", $contents);
	foreach ($config_lines as $line) {
		 $last_character_position += strlen($line);
	    if (strpos(" ".$line, 'php_admin_value[open_basedir]')) {
		$last_character_position +=10;
	        break;
	    }
	}
	$contents_safe = substr($contents,0,$last_character_position);

	//update params
	$params=$contents_safe."\n";
     	foreach ($PHP_ADMIN_VALUES as $PHP_VALUE_OPTION) {
        $params.="php_admin_value[".$PHP_VALUE_OPTION['name']."] = ".$_POST[$PHP_VALUE_OPTION['name']]."\n";
        }
	
	//overwrite
	$cmd="echo '".str_replace("$","\\$",$params)."' > ".$file;//.".test";
        $command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." \"{$cmd}\"";
        $contents = $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
	//reload

if ($_POST['php_version']!=$vhost['php_version']) {
	$cmd="service php-".$vhost['php_version']."-fpm reload";
	$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." \"{$cmd}\"";
	$output = $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
//	$this->trace($cmd);
}
	sleep(6);

	$cmd="service php-".$_POST['php_version']."-fpm reload";
	$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." \"{$cmd}\"";
	$output = $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
//	$this->trace($cmd);

	sleep(2);
	
        $cmd="service php-".$_POST['php_version']."-fpm status";
        $command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." \"{$cmd}\"";
        $output = $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
	$output_error = $output;
       // $this->trace($cmd." --> ".$output);

	if (strpos($output,"active (running)")) { 
	$query="update kms_isp_hostings_vhosts set php_version='".$_POST['php_version']."' where id=".$_GET['xid'];
	mysql_query($query);
	$this->trace("PHP version update was successful on host ".$vhost['name']);
	$error=false;

	} else {
	$output_error = $output;

	$error=true;
	$this->trace("PHP version update failed on host ".$vhost['name']." restoring previous version");
	// restore file and services
	$new_file="/var/www/vhosts/".$vhost['name']."/conf/php-".$_POST['php_version'].".conf";
	$cmd="mv {$new_file} {$file}";
	$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." \"{$cmd}\"";
	$output = $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");

	$cmd="service php-".$vhost['php_version']."-fpm reload";
	$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." \"{$cmd}\"";
	$output = $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");

        sleep(4);

	$cmd="service php-".$_POST['php_version']."-fpm reload";
	$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." \"{$cmd}\"";
	$output = $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");

	//error
	$body="No s'ha pogut actualitzar la versió de PHP de la <b>".$vhost['php_version']."</b> a la <b>".$_POST['php_version']."</b> en el domini <b>".$vhost['name']."</b>.<br><br>Detalls de l'error:<br>".$output_error."<br>";
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= "To: <alertes@intergrid.cat>" . "\r\n";
        $headers .= 'From: Intergrid Control Panel <cp@intergridnetwork.net>' . "\r\n";
        mail($to, $subject, $body, $headers, "-f cp@intergridnetwork.net");

}

	if ($error) echo "Sorry we are unable to update the PHP version to ".$_POST['php_version']." for host ".$vhost['name']." please contact your service provider."; else { echo "<script>document.location='https://control.intergridnetwork.net/?app=".$_GET['app']."&mod=isp_hostings_vhosts&from=isp_hostings_vhosts&_=f&action=php&xid=".$_GET['xid']."';</script>"; }

} else {

	// get php available services 
	$cmd="systemctl list-units --type=service --state=active | grep -E 'php-[0-99].' | sort -nr";
	$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." \"{$cmd}\"";
	$output = $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
	$output = explode("\n",$output);
	$ver=array();
	foreach ($output as $line) {
		$clean_line=str_replace("php-","",$line);
		$clean_line=substr($clean_line,0,strpos($clean_line,"-fpm.service"));// loaded active running","",$clean_line);
		if ($clean_line!="") array_push($ver,$clean_line);	
	}

	$url="https://control.intergridnetwork.net/?app=".$_GET['app']."&mod=isp_hostings_vhosts&from=isp_hostings_vhosts&_=f&action=php&xid=".$_GET['xid'];
?>
<br>
<?
	if ($_GET['info']=="1")  { ?>
<a href="https://control.intergridnetwork.net/?app=cp&mod=isp_hostings_vhosts&from=isp_hostings_vhosts&_=f&action=php&xid=<?=$_GET['xid']?>">< <?=_KMS_GL_BACK_BUT?></a>
<?
	$filename_uuid = "phpinfo_".uniqid().".php";

#$cmd="mkdir /var/www/vhosts/".$vhost['name']."/httpdocs/tmp/; echo '<?php echo phpinfo();\n ' > /var/www/vhosts/".$vhost['name']."/httpdocs/tmp/phpinfo.php";
#$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." \"{$cmd}\"";
#$output = $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");

	$cmd="echo '<?php echo phpinfo();\n ' > /var/www/vhosts/".$vhost['name']."/httpdocs/".$filename_uuid;
	$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." \"{$cmd}\"";
	$output = $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");

	$url = "http://www.{$vhost['name']}".DIRECTORY_SEPARATOR.$filename_uuid;
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_NOBODY, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_TIMEOUT,10);

	$html_output = curl_exec($ch);

	if($filename_uuid){
	        $cmd="rm /var/www/vhosts/".$vhost['name']."/httpdocs/".$filename_uuid;
     		$command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." \"{$cmd}\"";
      	 	$output = $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");
        }

	$html_output = preg_replace("/^.*?\<body\>/is", "", $html_output);
	$html_output = preg_replace("/<\/body\>.*?$/is", "", $html_output);


	$style='
<style type="text/css">
#application_contents {background-image:none !important; background-color: white !important;}
#phpinfo pre {margin: 0; font-family: monospace;}
#phpinfo a:link {color: #009; text-decoration: none; background-color: #fff;}
#phpinfo a:hover {text-decoration: underline;}
#phpinfo table {border-collapse: collapse; border: 0; width: 934px; box-shadow: 1px 2px 3px #ccc;}
#phpinfo .center {text-align: center;}
#phpinfo .center table {margin: 1em auto; text-align: left;}
#phpinfo .center th {text-align: center !important;}
#phpinfo td, th {border: 1px solid #666; font-size: 75%; vertical-align: baseline; padding: 4px 5px;}
#phpinfo th {position: sticky; top: 0; background: inherit;}
#phpinfo h1 {font-size: 150%;}
#phpinfo h2 {font-size: 125%;}
#phpinfo .p {text-align: left;}
#phpinfo .e {background-color: #ccf; width: 300px; font-weight: bold;}
#phpinfo .h {background-color: #99c; font-weight: bold;}
#phpinfo .v {background-color: #ddd; max-width: 300px; overflow-x: auto; word-wrap: break-word;}
#phpinfo .v i {color: #999;}
#phpinfo img {float: right; border: 0;}
#phpinfo hr {width: 934px; background-color: #ccc; border: 0; height: 1px;}
</style>';

	$html='<div id="phpinfo">'.$html_output.'</div>';
	printf('%s%s',$style,$html);

} else {

?>
<div class="flex">
<? /* =_PHP_VER_CURRENT?>: <b><?=$vhost['php_version'];?></b> <a href='<?=$url?>&info=1'>(Detalls phpinfo)</a><br><br>
*/

//if ($_SERVER['REMOTE_ADDR']=='81.0.57.125') print_r($server);

?>
<label for="phpver"><?=_KMS_ISP_DOMAINS_NAME?>: <b><?=$vhost['name'];?></b><br><br>

<?
$ip_address = gethostbyname($vhost['name']);
if ($ip_address!=$server['ip']) {
?>
<div class="notify notifywarn">
        <h5>El alojamiento contratado está inoperativo</h5>
        <div class="notifytext">
            <p style="margin:0;">Al tener asignados unos DNS personalizados, todos los servicios del plan de alojamiento asociado a este dominio (incluido el contenido web) están inactivos.<br>Si quieres que el plan de alojamiento esté activo, tienes que asociar nuestros DNS a tu dominio.</p>
        </div>
    </div>
<? } else { 
?>
<a href="<?=$url?>&info=1" style="text-decoration:underline">Consultar todos los parámetros de PHP</a>
<br><br><? } ?>
<?//=_PHP_WARNING?></label>

<form action="<?=$url?>" method="POST" id="phpver">
	<div class="flex flex-row">
<? /*	<select name="phpver" id="phpver" form="phpver">
	<? foreach ($ver as $v) { ?>
		  <option value="<?=$v?>" <?if ($vhost['php_version']==$v) echo " selected";?>>PHP <?=$v?><?if ($vhost['php_version']==$v) echo " (configuració actual)";?></option>
	<? } ?>
	</select> 
	<input class="customButton highlight big" type="submit">
*/?>
	<?
//	if (in_array($_SERVER['REMOTE_ADDR'],['81.0.57.125'])) { ?>
	
<? /*	<div style="background-color:orangered;margin: 1rem 0; padding: 0.5rem">BETA: sols a IP 81.0.57.125</div> */?>
	<div class="form-group" style="display:flex; align-items:center;padding-bottom: 1.5rem ">
                <label for="php_version" style='min-width: 275px; padding-right: 1rem;'><?=_PHP_VERSION?></label>
                <select name="php_version" id="php_version" style='min-width:150px;text-align:right; margin-right:1rem;'>
		 <? foreach ($ver as $v) { ?>
                  <option value="<?=$v?>" <?if ($vhost['php_version']==$v) echo " selected";?>><?=$v?></option>
	        <? } ?>
                </select>
                <div class="help_tooltip" style='display:flex-start'><?=_PHP_VERSION_HELP_TOOLTIP?>
		</div>
        </div>

	<!-- PHP Options loop -->
<?
//read file custom values
        //readfile
        $cmd="cat $file";
        $command = "ssh -i /root/.ssh/id_rsa root@".$server['hostname']." \"{$cmd}\"";
        $contents = $this->ssh_exec("localhost",$command,"JADF7320cSJdcj3750492x42dj244");

        $last_character_position=0;
        $config_lines = explode("\n", $contents);
        $current=array();
	foreach ($config_lines as $line) {
            if (strpos(" ".$line, 'php_admin_value')) {
		$var=substr($line,16,strpos($line,"]")-16);
		$value=substr($line,strpos($line,"= ")+2);
		$current[$var]=$value;
            }
        }
?>

        <? foreach ($PHP_ADMIN_VALUES as $PHP_VALUE_OPTION) {

        echo "<div class=\"form-group\" style=\"display:flex; align-items:center; padding-bottom: 1.5rem\">";
        echo "<label for='".$PHP_VALUE_OPTION['name']."' style='min-width: 275px; padding-right: 1rem;'>".$PHP_VALUE_OPTION['label']."</label>";
        echo "<select name='".$PHP_VALUE_OPTION['name']."' id='".$PHP_VALUE_OPTION['name']."' style='min-width:150px;text-align:right; margin-right:1rem;'>";
        foreach ($PHP_VALUE_OPTION['values'] as $OPTION) {
        echo "<option value='".$OPTION['value']."' style='' ";

	if ($current[$PHP_VALUE_OPTION['name']]) {
//		echo "compara ".$OPTION['value']." amb ".$current[$PHP_VALUE_OPTION['name']]."<br>";
		if ($OPTION['value']==$current[$PHP_VALUE_OPTION['name']]) echo " selected";
	} else {
		if ($OPTION['value']==$PHP_VALUE_OPTION['default']) echo " selected";
	}
	echo ">".$OPTION['txt']."</option>";
        }
        echo "</select>";
        echo "<div class='help_tooltip'>".$PHP_VALUE_OPTION['help_tooltip']."</div>";
        echo '</div>';
        }?>

        <!-- PHP Options loop end -->

	<input class="customButton highlight big" type="submit">

	<?//} ?>
        </div>
</form>

<? }} ?>
<br>
<br>
<a href="https://control.intergridnetwork.net/?app=cp&from=isp_hostings_vhosts&mod=isp_hostings_vhosts_adv&id=<?=$_GET['xid']?>&xid=<?=$_GET['xid']?>">< <?=_KMS_GL_BACK_BUT?></a>
</div>
