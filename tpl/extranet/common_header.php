<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html  id="kms_<?=$_GET['_']?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<!--iso-8859-1"-->
<title><?=$this->client_account['subdomain']?>.<?=$this->client_account['domain']?></title>
<meta name="robots" content="noindex">
<? if ($ismenu) { ?>
<link rel="stylesheet" type="text/css" href="/kms/tpl/<?=$this->extranet['theme']?>/styles/<?=$this->extranet['style']?>/css/general.css" />
<link rel="stylesheet" type="text/css" href="/kms/tpl/<?=$this->extranet['theme']?>/styles/<?=$this->extranet['style']?>/css/custom.css" />
<link rel="stylesheet" type="text/css" href="/kms/tpl/<?=$this->extranet['theme']?>/styles/<?=$this->extranet['style']?>/css/layout.css" />
<link rel="stylesheet" type="text/css" href="/kms/tpl/<?=$this->extranet['theme']?>/styles/<?=$this->extranet['style']?>/css/desktop.css" />
<link rel="stylesheet" type="text/css" href="/kms/tpl/<?=$this->extranet['theme']?>/styles/<?=$this->extranet['style']?>/css/wizard.css" />
<link rel="stylesheet" type="text/css" href="/kms/tpl/<?=$this->extranet['theme']?>/styles/<?=$this->extranet['style']?>/css/misc.css" />
<? } else { ?>
<link rel="stylesheet" type="text/css" href="/kms/lib/jQuery/ui/smoothness/development-bundle/themes/smoothness/ui.all.css"/>
<link rel="stylesheet" type="text/css" href="/kms/tpl/<?=$this->extranet['theme']?>/styles/<?=$this->extranet['style']?>/css/style.css" />
   <!--[if lt IE 8]>
   <style type="text/css">
   li a {display:inline-block;}
   li a {display:block;}
   </style>
   <![endif]-->
<? } ?>
<script type="text/javascript" src="/kms/lib/jQuery/jquery-min.js"></script>
<script type="text/javascript" src="/kms/lib/jQuery/jquery-ui.min.js"></script>
<script type="text/javascript" src="/kms/lib/jQuery/ui/smoothness/development-bundle/ui/ui.core.js"></script>
<script type="text/javascript" src="/kms/lib/jQuery/ui/smoothness/development-bundle/ui/ui.datepicker.js"></script>
<script type="text/javascript" src="/kms/lib/jQuery/ui/smoothness/development-bundle/ui/i18n/ui.datepicker-<?=$client_account['default_lang']?>.js"></script>
<script type="text/javascript" src="/kms/lib/jQuery/plugins/accordion-menu/menu.js"></script>
<script type="text/javascript" src="/kms/lib/jQuery/jquery.scrollTo-min.js"></script>
<script type="text/javascript" src="/kms/lib/controller.js"></script>
<script type="text/javascript" src="/kms/lib/more.js"></script>
<? // tabview ?>
<link rel="stylesheet" href="/kms/lib/tabview/css/tab-view.css" type="text/css" media="screen">
<script type="text/javascript" src="/kms/lib/tabview/js/ajax.js"></script>
<script type="text/javascript" src="/kms/lib/tabview/js/tab-view.js"></script>
<? 
//---------editor------------
//if ($_GET['_']=='e') { ?>
<script type="text/javascript" src="/kms/lib/components/tinymce/tiny_mce_src.js"></script>
<script language="javascript" type="text/javascript" src="/kms/lib/jQuery/plugins/tablednd/tablednd.js"></script>

<?// include "/usr/share/kms/lib/components/tinymce/rte.php";  ?>

<link rel="stylesheet" type="text/css" href="/kms/lib/components/cal/calendar.css">
<script language="javascript" type="text/javascript" src="/kms/lib/formManager.js"></script>
<!--<script language="JavaScript" type="text/javascript" src="/kms/lib/components/cal/calendar.js"></script>
<script language="JavaScript" type="text/javascript" src="/kms/lib/components/cal/lang/<?=$client_account['default_lang']?>.js"></script>
<script language="JavaScript" type="text/javascript" src="/kms/lib/components/cal/calendar-setup.js"></script>-->
<!--<script language="JavaScript" type="text/javascript" src="/kms/lib/components/rte/richtext.js"></script>
<script language="JavaScript" type="text/javascript"> initRTE("/kms/lib/components/rte/images/", "/kms/lib/components/rte/", "");</script>-->
<?// } ?>
<script type="text/javascript" src="/kms/lib/components/jscolor/jscolor.js"></script>
<? // <script language="JavaScript" type="text/javascript" src="/lib/<?session_start();echo $_SESSION["myJsf"]"></script> ?>

</head>
<body class="kms_<?=$_GET['_']?>" marginwidth="10" marginheight="0" topmargin="0" leftmargin="10" onresize="refreshUI()">
