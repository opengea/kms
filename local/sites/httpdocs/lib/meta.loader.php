<?
// read contents
if ($_GET['s']=="") $_GET['s']=$conf['default_page'];

// *************** load web page and metadata ***************
        $sel="select * from kms_sites_pages where permalink='".$_GET['s']."'";
        $res=mysqli_query($dblink,$sel);
if ($res) { 
		$page=mysqli_fetch_assoc($res);
		$page_title=$page['title'];
		if (substr($page_title,0,1)=="_") $page_title=$ll[$page_title];
	        $conf['meta_title']=$ll['meta_title']." - ".$page_title;


} else {

	// *************** load article ***************

		if ($_GET['a']!="") { 
		$query="select * from kms_docs_articles where title like \"".str_replace("-","%",$_GET['a'])."%\" and (status='published' or status='notavail')";

		} else { 
                $query="select * from kms_docs_articles where title like \"".str_replace("-","%",$_GET['p'])."%\" and (status='published' or status='notavail')";
		}
        if ($debug&&$_SERVER['REMOTE_ADDR']==TARTARUS_IP) {
//		$query="select * from kms_docs_articles where title like \"".str_replace("-","%",$_GET['p'])."%\"";	
	}
                $resa=mysqli_query($dblink,$query);
                $article=mysqli_fetch_assoc($resa);

	//check if there are children articles

		if ($article['parent']!="") {	//es un article fill
			$query="select * from kms_docs_articles where parent=".$article['parent']." order by sort_order asc";
                        $res_children=mysqli_query($dblink,$query);

                        $query="select * from kms_docs_articles where id=".$article['parent']." order by sort_order asc";
                        $res_parent=mysqli_query($dblink,$query);
			$parent=mysqli_fetch_assoc($res_parent);
			$_GET['p']=urlize($parent['title']);
 
		} else {
			//potser es el pare
			$query="select * from kms_docs_articles where parent=".$article['id']." order by sort_order asc";
			$res_children=mysqli_query($dblink,$query);
		}

		if ($_GET['a']!="") { // must load a children!
			$query="select * from kms_docs_articles where title like \"".str_replace("-","%",$_GET['a'])."%\"";
			$resa=mysqli_query($dblink,$query);
	                $article=mysqli_fetch_assoc($resa);	
		}


                $conf['meta_title']=$ll['meta_title']." - ".$article['title'];
                $conf['meta_description']=$article['subtitle'];
                $add=strip_tags($article['short_body_'.$_GET['l']]);
                if ($conf['meta_description']!=""&&$add!="") $conf['meta_description'].=" - ";
                $conf['meta_description'].=$article['short_body_'.$_GET['l']];
                $add=strip_tags(substr($article['body_'.$_GET['l']],0,150))."...";
                if (($conf['meta_description']==""||$conf['meta_description']==" - ")&&($add!="..."))  $conf['meta_description'].=$add;
                $conf['meta_description']=strip_tags(str_replace("\r","",str_replace("\n","",$conf['meta_description'])));
                $meta_image=$url_base."/files/pictures/docs_articles/picture/".$article['picture'];
                $meta_image_alt=$article['picture_footer_'.$_GET['l']];
                $meta_image_width="1200";
                $meta_image_height="800";
}

?>
