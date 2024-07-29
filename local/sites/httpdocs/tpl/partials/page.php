<?
if ($_GET['s']=="") $_GET['s']="home";

if ($page['id']&&$page['type']=="webpage") {
	// Kms page

	if (file_exists("tpl/pages/".$_GET['s'].".php")) include "tpl/pages/".$_GET['s'].".php";
	else { 

?>
<div class="main container-fluid" style="margin-top:431px">
<div class="page container col-12 col-sm-12 col-md-10 col-lg-6 col-xl-8"><?
	if ($page['show_title']) echo "<h1>".$ll[$page['title']]."</h1>";
        if (substr($page['body'],0,1)=="_") echo add_widgets($ll[$page['body']]); else echo $page['body'];


	}

} else {

?>
<div class="container-fluid">
<div class="page container col-12 col-sm-12 col-md-10 col-lg-6 col-xl-8">
<?
if (file_exists("tpl/pages/".$_GET['s'].".php")) {      
	// file page

        include "tpl/pages/".$_GET['s'].".php"; 

} else {
	//article or home

	 if ($_GET['p']!="") {
		if ($article['id']=="") echo "Article ".$_GET['p']." not found."; else include "tpl/partials/article_template.php";
	} else {
		if ($monografic['id']=="") echo "page ".$_GET['s']." not found"; else { include "tpl/pages/home.php"; }
	}

}

}
?>
</div>
</div>
