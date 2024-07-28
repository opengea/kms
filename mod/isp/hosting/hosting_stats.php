<?
include_once "/usr/local/kms/lib/include/functions.php";
?>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
<?
$select="select * from kms_isp_hostings where id=".$_GET['id'];
$res=mysqli_query($select);
$hosting=mysqli_fetch_array($res);

?>
<h2><?=_KMS_ISP_HOSTINGS_STATS_USAGEFOR?> <?=$hosting['type']?> <?=$hosting['description']?></h2>
<?
$select="select * from kms_isp_hostings_log where hosting_id=".$hosting['id'];
$res=mysqli_query($select);
$stats="";
while ($log=mysqli_fetch_array($res)) {
	$stats.="<tr><td>".date('M Y',strtotime($log['date']))."<td>".bytes($log['used_space'])."</td><td>".bytes($log['used_transfer'])."</td><td>".$log['used_vhosts']."</td><td>".$log['used_mailboxes']."</td></tr>";
}

if ($stats=="") die("<strong>There are no stats for this domain.</strong>");
?>

<? // -Estat actual per serveis----------------------------------------------------------------------------- ?>

 <?
        function bytesToGb($bytes) {
        return round(($bytes/1024/1024/1024)*100)/100;
        }

        $sqlCurrentStatus = "
        SELECT
                used_space_httpdocs,
                used_space_mailboxes,
                used_space_databases,
                used_space_extranet,
                used_space_subdomains,
                used_space_ftps,
                used_space_logs,
                used_space_backups
        FROM
                kms_isp_hostings_vhosts
        WHERE
                hosting_id=".$_GET['id'].";
        ";
        $qryCurrentStatus = mysqli_query($sqlCurrentStatus) or die (mysqli_error());
        $currentStatus = mysqli_fetch_array($qryCurrentStatus);
?>


<div class="graph" style="float:left">
<div class="graph_title">
<h3>
<?=utf8_encode(html_entity_decode(_KMS_ISP_HOSTINGS_USED_SPACE))?> <?=_KMS_ISP_MISC_CURRENT_STATUS?>
</h3>
</div>
<div class="graph_header">
	<div class="graph_legend">Hosting</div>
	<div class="graph_data"><?=bytesToGB($currentStatus['used_space_httpdocs'])?> GB</div>
</div>
<div class="graph_header">
        <div class="graph_legend">Email</div>
        <div class="graph_data"><?=bytesToGB($currentStatus['used_space_email'])?> GB</div>
</div>
<div class="graph_header">
        <div class="graph_legend">Databases</div>
        <div class="graph_data"><?=bytesToGB($currentStatus['used_space_databases'])?> GB</div>
</div>
<div class="graph_header">
        <div class="graph_legend">Extranet</div>
        <div class="graph_data"><?=bytesToGB($currentStatus['used_space_extranet'])?> GB</div>
</div>
<div class="graph_header">
        <div class="graph_legend">Subdomains</div>
        <div class="graph_data"><?=bytesToGB($currentStatus['used_space_subdomains'])?> GB</div>
</div>
<div class="graph_header">
        <div class="graph_legend">FTP</div>
        <div class="graph_data"><?=bytesToGB($currentStatus['used_space_ftp'])?> GB</div>
</div>
<div class="graph_header">
        <div class="graph_legend">Logs</div>
        <div class="graph_data"><?=bytesToGB($currentStatus['used_space_logs'])?> GB</div>
</div>
<div class="graph_header">
        <div class="graph_legend">Backups</div>
        <div class="graph_data"><?=bytesToGB($currentStatus['used_space_backups'])?> GB</div>
</div>
<div style="clear:both"></div>

    <script type="text/javascript">
      function drawVisualization_CurrentStatus() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
		['Tipo', 'Espacio Usado'],
	        ['Web - <?=bytesToGB($currentStatus['used_space_httpdocs'])?> Gb',  <?=bytesToGB($currentStatus['used_space_httpdocs'])?>],
        	['Email - <?=bytesToGB($currentStatus['used_space_mailboxes'])?> Gb',      <?=bytesToGB($currentStatus['used_space_mailboxes'])?>],
		['Databases - <?=bytesToGB($currentStatus['used_space_databases'])?> Gb',      <?=bytesToGB($currentStatus['used_space_databases'])?>],
		['Extranet - <?=bytesToGB($currentStatus['used_space_extranet'])?> Gb',      <?=bytesToGB($currentStatus['used_space_extranet'])?>],
		['Subdomains - <?=bytesToGB($currentStatus['used_space_subdomains'])?> Gb',      <?=bytesToGB($currentStatus['used_space_subdomains'])?>],
		['Usuarios Web - <?=bytesToGB($currentStatus['used_space_ftps'])?> Gb',    <?=bytesToGB($currentStatus['used_space_ftps'])?>],
		['LOGS - <?=bytesToGB($currentStatus['used_space_logs'])?> Gb',             <?=bytesToGB($currentStatus['used_space_logs'])?>],
		['Backups - <?=bytesToGB($currentStatus['used_space_backups'])?> Gb',             <?=bytesToGB($currentStatus['used_space_backups'])?>]
        ]);

        // Create and draw the visualization.
        var ac = new google.visualization.PieChart(document.getElementById('visualization_CurrentStatus'));
        ac.draw(data, {
          width: 700,
          height: 400,
	  sliceVisibilityThreshold:0,
	  colors: ['MediumSlateBlue', 'orange', 'red', 'lightgreen', 'magenta', 'blue', 'yellow', 'purple']
        });
      }

     google.setOnLoadCallback(drawVisualization_CurrentStatus);
    </script>
    <div class="statsCont" id="visualization_CurrentStatus"></div>
</div>


<? // -ESPAI TOTAL PER HOSTING----------------------------------------------------------------------------- ?>
<div class="graph" style="float:left">
<div class="graph_title">
<h3>
<?=utf8_encode(html_entity_decode(_KMS_ISP_HOSTINGS_USED_SPACE))?> <?=_KMS_ISP_MISC_BY_HOSTING?>
</h3>
</div>
    <script type="text/javascript">
      function drawVisualization_Totalspace() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
<?
   //VHOSTS
   $row_data=array();
   $sel="select * from kms_isp_hostings_log where hosting_id='".$_GET['id']."' order by id asc";
   $res=mysqli_query($sel);
   while ($log=mysqli_fetch_array($res)) {
//		if (!is_array($row_data[$log['creation_date']])) $row_data[$log['creation_date']]=array();
//		$row_data[$log['date']]['used_space']=$log['used_space'];
		$row_data[$log['date']]=$log['used_space'];
   }
   $row_vhosts=substr($row_vhosts,0,strlen($row_vhosts)-2);
   echo "['".utf8_encode(html_entity_decode(_KMS_GL_DAY))."',\t'".$hosting['type'].' '.$hosting['description']."'],\t";
   $out="";
   foreach ($row_data as $data=>$val) {
	if ($data!="") $out.="\n['".$data."',\t";
	$val=round(($val/1024/1024/1024)*100)/100; //GB
	$out.=$val."],\t";
   }
   echo substr($out,0,strlen($out)-1)."\n]);";
?>

        // Create and draw the visualization.
        var ac = new google.visualization.AreaChart(document.getElementById('visualization_Totalspace'));
        ac.draw(data, {
          isStacked: false,
          width: 700,
          height: 400,
          vAxis: {title: "GB"},
          hAxis: {title: "<?=utf8_encode(html_entity_decode(_KMS_GL_DAY))?>"}
        });
      }
      
      google.setOnLoadCallback(drawVisualization_Totalspace);
    </script>
    <div class="statsCont" id="visualization_Totalspace"></div>
</div>
<? // -ESPAI X DOMINI----------------------------------------------------------------------------- ?>
<div class="graph" style="float:left">
<div class="graph_title">
<h3>
<?=utf8_encode(html_entity_decode(_KMS_ISP_HOSTINGS_VR_SPACE_USAGE))?> <?=_KMS_ISP_MISC_BY_DOMAIN?>
</h3>
</div>    
<script type="text/javascript">
      function drawVisualization_space() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
<?
   //VHOSTS
   $select = "select * from kms_isp_hostings_vhosts where hosting_id=".$_GET['id']." and hosting_id!=''";
   $res=mysqli_query($select);
   $row_data=array();
   $i=0;
   $row_vhosts="";
   while ($vhost=mysqli_fetch_array($res)) {
	$host_block=false;
     $sel="select * from kms_isp_hostings_vhosts_log where domain='".$vhost['name']."' order by id asc";
        $res2=mysqli_query($sel);
	$break=true;
        while ($log=mysqli_fetch_array($res2)) {
		if ($i==0) $break=false;
		if (!$break) {
		if (!$host_block) { $row_vhosts.="'".$vhost['name']."',\t"; $host_block=true; }
			
//                $space_used=$log['used_space_httpdocs']+$log['used_space_mailboxes']+$log['used_space_extranet']+$log['used_space_databases']+$log['used_space_subdomains']+$log['used_space_ftps']+$log['used_space_backups']+$log['used_space_logs'];
		$space_used=$log['used_space_httpdocs']+$log['used_space_mailboxes']+$log['used_space_extranet']+$log['used_space_databases']+$log['used_space_subdomains']+$log['used_space_ftps']+$log['used_space_logs'];
                if (!is_array($row_data[$log['creation_date']])) $row_data[$log['creation_date']]=array();
                $row_data[$log['date']][$i]=$space_used;
		}
	}
	
        $i++;
   }
   
   $row_vhosts=substr($row_vhosts,0,strlen($row_vhosts)-2);
   echo "['".utf8_encode(html_entity_decode(_KMS_GL_DAY))."',\t".$row_vhosts."],\t";
   $out="";
   foreach ($row_data as $data=>$val) {
        if ($data!="") $out.="\n['".$data."',\t";
//      echo "['".$val."',]";
        $show="";
        foreach ($val as $col) {
                $col=round(($col/1024/1024/1024)*100)/100;
		if ($col=="") $col="0";
                $show=$show.$col.",\t";
        }
        $x=substr($show,0,strlen($show)-2)."],";
        if ($x!="],") $out=$out.$x;
   }
   echo substr($out,0,strlen($out)-1)."\n]);";
?>

        // Create and draw the visualization.
        var ac = new google.visualization.AreaChart(document.getElementById('visualization_space'));
        ac.draw(data, {
          isStacked: false,
          width: 700,
          height: 400,
          vAxis: {title: "GB"},
          hAxis: {title: "<?=utf8_encode(html_entity_decode(_KMS_GL_DAY))?>"}
        });
      }
      
      google.setOnLoadCallback(drawVisualization_space);
    </script>
    <div class="statsCont" id="visualization_space"></div>
</div>
<? // -ESPAI X RECURSOS----------------------------------------------------------------------------- ?>
<div class="graph" style="float:left">
<div class="graph_title">
<h3>
<?=utf8_encode(html_entity_decode(_KMS_ISP_HOSTINGS_VR_SPACE_USAGE))?> <?=_KMS_ISP_MISC_BY_RESOURCES?>
</h3>
</div>

    <script type="text/javascript">
      function drawVisualization_space() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
<?
   //VHOSTS
   $select = "select * from kms_isp_hostings_vhosts where hosting_id=".$_GET['id'];
   $res=mysqli_query($select);
   $row_data=array();
   $i=0;
   $row_vhosts="";
   while ($vhost=mysqli_fetch_array($res)) {
        $row_vhosts.="'".$vhost['name']."',\t";
        $sel="select * from kms_isp_hostings_vhosts_log where domain='".$vhost['name']."' order by id asc";
        $res2=mysqli_query($sel);
	$break=true;
        while ($log=mysqli_fetch_array($res2)) {
		if ($i==0) $break=false;
                if (!$break) {
                if (!is_array($row_data[$log['creation_date']])) $row_data[$log['creation_date']]=array();
                $row_data[$log['date']]['web']=$log['used_space_httpdocs']+$log['used_space_subdomains']+$log['used_space_logs'];
		$row_data[$log['date']]['ftps']=$log['used_space_ftps'];
		$row_data[$log['date']]['databases']=$log['used_space_databases'];
		$row_data[$log['date']]['mailboxes']=$log['used_space_mailboxes'];
		$row_data[$log['date']]['extranet']=$log['used_space_extranet'];
		$row_data[$log['date']]['backups']=$log['used_space_backups'];
		}
        }
        $i++;
   }
   $row_vhosts=substr($row_vhosts,0,strlen($row_vhosts)-2);
   $tmp= "['"._KMS_GL_RESOURCE."',\t'"._KMS_TY_WEB_SITES."',\t'"._KMS_TY_ISP_FTPS."',\t'"._KMS_SERVICES_DB."',\t'"._KMS_TY_ISP_MAILBOXES."',\t'"._KMS_SERVICES_EXTRANET."',\t'"._KMS_ISP_HOSTING_FEATURE_BACKUPS."'],\t";
  echo utf8_encode(html_entity_decode($tmp));
   $out="";
   foreach ($row_data as $data=>$val) {
        if ($data!="") $out.="\n['".$data."',\t";
//      echo "['".$val."',]";
        $show="";
        foreach ($val as $col) {
                $col=round(($col/1024/1024/1024)*100)/100;
		if ($col=="") $col="0";
                $show=$show.$col.",\t";
        }
        $x=substr($show,0,strlen($show)-2)."],";
        if ($x!="],") $out=$out.$x;
   }
   echo substr($out,0,strlen($out)-1)."\n]);";
?>

        // Create and draw the visualization.
        var ac = new google.visualization.AreaChart(document.getElementById('visualization_byresources'));
        ac.draw(data, {
          isStacked: false,
          width: 700,
          height: 400,
          vAxis: {title: "GB"},
          hAxis: {title: "<?=utf8_encode(html_entity_decode(_KMS_GL_DAY))?>"}
        });
      }
      
      google.setOnLoadCallback(drawVisualization_space);
    </script>
    <div class="statsCont" id="visualization_byresources"></div>
</div>
<? // --TRANSFER PER DOMINI---------------------------------------------------------------------------- ?>
<div class="graph" style="float:left">
<div class="graph_title">
<h3>
<?=_KMS_ISP_HOSTINGS_USED_TRANSFER?> <?=_KMS_ISP_MISC_BY_DOMAIN?>
</h3>
</div>
    <script type="text/javascript">
      function drawVisualization_transfer() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
<?
   //VHOSTS
   $select = "select * from kms_isp_hostings_vhosts where hosting_id=".$_GET['id'];
   $res=mysqli_query($select);
   $row_data=array();
   $i=0;
   $row_vhosts="";
   while ($vhost=mysqli_fetch_array($res)) {
	$host_block=false;
//        $row_vhosts.="'".$vhost['name']."',\t";
        $sel="select * from kms_isp_hostings_vhosts_log where domain='".$vhost['name']."' order by id asc";
        $res2=mysqli_query($sel);
        $break=true;
	while ($log=mysqli_fetch_array($res2)) {
		if ($i==0) $break=false;
                if (!$break) {
		if (!$host_block) { $row_vhosts.="'".$vhost['name']."',\t"; $host_block=true; }
                $transfer_used=$log['used_transfer_web']+$log['used_transfer_mailboxes']+$log['used_transfer_webmail'];
                if (!is_array($row_data[$log['creation_date']])) $row_data[$log['creation_date']]=array();
                $row_data[$log['date']][$i]=$transfer_used;
		}
        }
        $i++;
   }
   $row_vhosts=substr($row_vhosts,0,strlen($row_vhosts)-2);
          //['Month',   'Bolivia', 'Ecuador', 'Madagascar', 'Papua New Guinea', 'Rwanda'],
   echo "['".utf8_encode(html_entity_decode(_KMS_GL_DAY))."',\t".$row_vhosts."],\t";
   $out="";
   foreach ($row_data as $data=>$val) {
        if ($data!="") $out.="\n['".$data."',\t";
//      echo "['".$val."',]";
        $show="";
        foreach ($val as $col) {
                if ($col=="") $col=0; else $col=round(($col/1024/1024)*100)/100; // MB
                $show=$show.$col.",\t";
        }
        $x=substr($show,0,strlen($show)-2)."],";
        if ($x!="],") $out=$out.$x;
   }
   echo substr($out,0,strlen($out)-1)."\n]);";
?>

        // Create and draw the visualization.
        var ac = new google.visualization.AreaChart(document.getElementById('visualization_transfer'));
        ac.draw(data, {
          isStacked: false,
          width: 700,
          height: 400,
          vAxis: {title: "GB"},
          hAxis: {title: "<?=utf8_encode(html_entity_decode(_KMS_GL_DAY))?>"}
        });
      }
      
      google.setOnLoadCallback(drawVisualization_transfer);
    </script>
    <div class="statsCont" id="visualization_transfer"></div>

</div>
<? // ------------------------------------------------------------------------------ ?>

