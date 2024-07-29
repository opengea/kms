<? include "menu.php";?>
<div class="container-fluid page-footer">
<div class="row content footer">

    <div class="pull-left">
        <div class="pull-left ft-item"><a href="http://www.intersindical-csc.cat/" target="_blank"><img src="/images/logo_csc.gif" height="70"></a></div>
	<div class="pull-left ft-item"><a href="https://assemblea.eu/?q=node/914" target="_blank"><img src="/images/assemblea-sap.png" height="70"></a></div>
    </div>

</div>
</div>
<script>
$(document).ready(function(){
	$('#nav-icon').click(function(){
		$(this).toggleClass('open');
		
		if ($("#menu").hasClass("close")) {
   			$('#menu').removeClass( "close" ).addClass( "open" );
		}else{
			$('#menu').removeClass( "open" ).addClass( "close" );
			}
	});
});
</script>
 <!-- Global site tag (gtag.js) - Google Analytics -->
 <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109161628-1"></script>
 <script>
   window.dataLayer = window.dataLayer || [];
   function gtag(){dataLayer.push(arguments);}
   gtag('js', new Date());
   gtag('config', 'UA-109161628-1');
 </script>
</body>
</html>
