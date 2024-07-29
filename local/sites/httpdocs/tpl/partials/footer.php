<div id="searchbox<?=$mobile?>">
        <form id="form_search" action="<?=$url_base_lang?>/search" method="post" role="search" _lpchecked="1">
                <input type="text" value="" name="searchword" placeholder="<?=$searchword?>" autocomplete="off">
		<span id="exec_search" onclick="$('#form_search').submit()"><i class="fa fa-search"></i></span>

        </form>
        <div id="close_searchbox" onclick="$('div#searchbox').hide();">x</div>
</div>

<div class="footer">
<div class="row content pagewidth col-12 col-sm-12 col-md-10 col-lg-10" style="margin:auto;text-align:center">


<? $logo="202005110811396353-big-logo.png";
//   $logo="202005110822308167-big-logo-black.png";?>
<div style="width:100%;padding:20px 0px;clear:left;margin:auto"><img style="margin:auto;width:150px;opacity:0.2" src="<?=$url_base?>/files/pictures/albums/1/<?=$logo?>"></div>


<div style="width:100%;padding:0px;color:#ccc;clear:left;margin:30px auto 0px auto;letter-spacing:1px">&copy; <?=date('Y')?> &nbsp;GERARD&nbsp; MARTÍ<br><br></div>


<div class="social_buttons_footer" style="margin:auto">
                        <ul style="margin:0px !important;padding: 0px !important">
                        <li><a title="Youtube" href="<?=$ll['_YOUTUBE_LINK']?>" target="_blank"><i class="fab fa-youtube"></i></a></li>
                        <li><a title="Instagram" href="<?=$ll['_INSTA_LINK']?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
                        <li style="margin:0px !important"><a title="Facebook" href="<?=$ll['_FB_LINK']?>" target="_blank"><i class="fab fa-facebook"></i></a></li>
                        </ul>
                </div>

</div>
</div>

</body>
</html>
