<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="<?=$_GET['l']?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, user-scalable=no">
<meta HTTP-EQUIV="title" CONTENT="<?=$conf['meta_title']?>"/>
<meta NAME="organization" CONTENT="Generalitat de Catalunya"/>
<meta NAME="locality" CONTENT="Catalunya"/>
<meta NAME="description" CONTENT="<?=$conf['meta_description']?>">
<meta NAME="keywords" CONTENT="<?=$ll['meta_keywords']?>">
<meta NAME="robots" CONTENT="all"/>
<meta name="theme-color" content="<?=$conf['theme-color']?>"/>
<meta http-equiv="Cache-control" content="public">
<meta property="og:site_name" content="<?=$ll['meta_title']?>"/>
<meta property="og:title" content="<?=$conf['meta_title']?>"/>
<meta property="og:description" content="<?=$conf['meta_description']?>"/>
<meta property="og:image" content="<?=$meta_image?>"/>
<meta property="og:url" content="<?=$url_base?><?=$_SERVER['REQUEST_URI']?>"/>
<meta property="og:type" content="article"/>
<meta property="fb:app_id" content=""/>
<meta property="og:image:alt" content="<?=$meta_image_alt?>"/>
<? if ($meta_image_width!="") { ?>
<meta property="og:image:width" content="<?=$meta_image_width?>"/>
<meta property="og:image:height" content="<?=$meta_image_height?>"/>
<? }?>
<title><?=$conf['meta_title']?></title>
<link rel="shortcut icon" href="<?=$url_base?>files/web/sites/favicon/<?=$site['favicon']?>" >
<link rel="stylesheet" type="text/css" href="<?=$url_base?>/css/style.scss?k=<?=date('YmdHis')?>" />
<script type="text/javascript" src="<?=$url_base?>/js/jquery-1.8.2.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> 
<link rel="stylesheet" type="text/css" href="<?=$url_base?>/css/style.scss?k=<?=date('YmdHis')?>" />
<!--font awesome-->
<link href="/css/fontawesome/css/fontawesome.css" rel="stylesheet">
<link href="/css/fontawesome/css/brands.css" rel="stylesheet">
<link href="/css/fontawesome/css/solid.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="/lib/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="/lib/slick/slick-theme.css"/>
<script type="text/javascript" src="<?=$url_base?>/js/controller.js?k=<?=date('YmdHm')?>"></script>
<?include "tpl/partials/analytics_head.php";?>
</head>
<body class="<?=$_GET['s']?>">
<?include "tpl/partials/analytics_body.php";?>
