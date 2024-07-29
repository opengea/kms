<!--[if IE]>
<!DOCTYPE html>
<![endif]-->
<html id="kms_<?=$_GET['_']?>">
<head>
<? /*<meta http-equiv="Content-Type" content="text/html; charset=<?=$conf['charset']?>" /> */?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$this->client_account['subdomain']?>.<?=$this->client_account['domain']?></title>
<meta name="robots" content="noindex">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="/kms/lib/jQuery/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="/kms/lib/bootstrap/3.3.7/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/kms/tpl/extranet/style.css?k=<?=date('YmdH')?>" />
<? if (file_exists('/var/www/vhosts/'.$this->client_account['domain'].'/subdomains/data/httpdocs/css/extranet.css')) { ?>
<link rel="stylesheet" type="text/css" href="//data.<?=$this->client_account['domain']?>/css/extranet.css"/>
<?}?>
<? /*<script language="javascript" type="text/javascript" src="/kms/lib/jQuery/jquery-min.js"></script>*/?>
<script language="javascript" type="text/javascript" src="/kms/lib/jQuery/jquery-3.2.1.min.js"></script>
<script language="javascript" type="text/javascript" src="/kms/lib/bootstrap/3.3.7/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript" src="/kms/lib/jQuery/plugins/menu/menu.js"></script>
<? if ($_GET['action']=='mupload') { ?><link rel="stylesheet" href="/kms/lib/mupload/jquery.fileupload-ui.css"><? }?>
<script language="javascript" type="text/javascript" src="/kms/lib/jQuery/plugins/tablednd/tablednd.js"></script>
<script language="javascript" type="text/javascript" src="/kms/lib/controller.js?k=<?=date('YmdHis')?>"></script>
<? if ($_GET['_']=='e'||$_GET['_']=='i') { ?>
<script language="javascript" type="text/javascript" src="/kms/lib/jQuery/jquery-ui-1.12.1/jquery-ui.min.js"></script>

<? if (file_exists('/var/www/vhosts/'.$this->client_account['domain'].'/subdomains/data/httpdocs/js/extranet.js')) { ?>
<script language="javascript" type="text/javascript" src="//data.<?=$this->client_account['domain']?>/js/extranet.js"/></script>
<?}?>

<? require "/usr/share/kms/lib/tinymce/rte.php";  ?>
<? require "/usr/share/kms/lib/ckeditor/ckeditor.php";  ?>
<link rel="stylesheet" type="text/css" href="/kms/lib/components/calendar/calendar.css" />
<link rel="stylesheet" type="text/css" href="/kms/lib/js/jval/jVal.css" />
<link rel="stylesheet" type="text/css" href="/kms/lib/jQuery/plugins/tagsinput/jquery.tagsinput.css" />
<script language="javascript" type="text/javascript" src="/kms/lib/jQuery/plugins/tagsinput/jquery.tagsinput.js"></script>
<script language="javascript" type="text/javascript" src="/kms/lib/js/jval/jVal.js"></script>
<script language="javascript" type="text/javascript" src="/kms/lib/formManager.js"></script>
<script language="JavaScript" type="text/javascript" src="/kms/lib/components/calendar/calendar.js"></script>
<script language="JavaScript" type="text/javascript" src="/kms/lib/components/calendar/lang/<?=$client_account['default_lang']?>.js"></script>
<script language="JavaScript" type="text/javascript" src="/kms/lib/components/calendar/calendar-setup.js"></script>
<script language="JavaScript" type="text/javascript" src="/kms/lib/ckeditor/ckeditor.js"></script>
<script language="JavaScript" type="text/javascript" src="/kms/lib/rte/richtext.js"></script>

<?/*    <link rel="stylesheet" href="/kms/lib/bootstrap/3.3.7/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>   
    <script src="/kms/lib/components/treeview/bower_components/jquery/dist/jquery.js"></script>


<?/*<link rel="stylesheet" type="text/css" href="/kms/lib/app/photogallery/css/shadowbox.css" /> 
<script type="text/javascript" src="/kms/lib/app/photogallery/js/yui-utilities.js"></script> 
<script type="text/javascript" src="/kms/lib/app/photogallery/js/shadowbox-yui.js"></script> 
<script type="text/javascript" src="/kms/lib/app/photogallery/js/shadowbox.js"></script> */?>
<script language="JavaScript" type="text/javascript">initRTE("/kms/lib/rte/images/", "/kms/lib/rte/", "");</script>
<? } ?>
<script language="javascript" type="text/javascript" src="/kms/lib/more.js"></script>
<?$header_includes=$this->tab[0]->mod[0]->components['status']->dm->header_includes;if ($header_includes!="") echo $header_includes;?>
<? // <script language="JavaScript" type="text/javascript" src="/lib/<?session_start();echo $_SESSION["myJsf"]"></script> ?>
<style type="text/css">
.dataBrowser_content {
         padding:15px;
        background: url('/kms/css/aqua/img/backgrounds/<?=$extranet['bg_image']?>.jpg');
}
.kms_icon {
	color:#<?=$extranet['text_color']?>;
}
.kms_icon div {
	margin-left:-10px;
	width:90px;
}
</style>
</head>
<body class="kms_<?=$_GET['_']?>" marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" onresize="refreshUI()">
