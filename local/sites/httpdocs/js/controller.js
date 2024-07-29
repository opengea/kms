function openNav() {
  document.getElementById("mySidebar").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}


//fade effect
var myElement = $('.effect_fade');

$(window).on('scroll', function() {
    var st = $(this).scrollTop();
    myElement.css({
        'opacity' : 1 - st/600
    });
});


window.addEventListener("scroll", function (event) {
    var scroll = this.scrollY;
    //console.log(scroll)
    var switch_point=340;
    var limit_point=1500;

    if (scroll>switch_point) {
		// Show header invert 
		console.log('show'+scroll);
//		$('header.normal').hide();
		//$('header.invert #menu_desktop ul').show();
		$('header.invert').css("transform","translateY(0%)");
		
     } else  {
		// hide header invert
		console.log('hide'+scroll);
//		$('header.normal').show();
//		$('header.invert #menu_desktop ul li ul').hide();
		$('header.invert').css("transform","translateY(-100%)");
//		var timeout = setTimeout(function(){ $('header.invert').hide(); },3000);
		}
});

document.onclick = function () {
$('ul.submenu').hide(); //css('opacity',0);
}
$('#searchbox').onclick = function () {
	this.hide();
}
var timeout;

$(document).ready( function() { 

	$('#current_lang').mouseover(function() {
		$('#avail_languages').show();
	});
	 $('#avail_languages').mouseover(function() { 
		clearTimeout(timeout);
	});
	$('#avail_languages').mouseout(function() {
              timeout = setTimeout(function() { $('#avail_languages').hide(); }, 500);
        });

	$('#current_lang').mouseout(function() {
              timeout = setTimeout(function() { $('#avail_languages').hide(); }, 500);
        });

});

function subscribeNews(name,email,check,lang,thanks) {
if (!check) return false;
thanks=thanks.replace("`","'");

                    $.ajax({
                        url: "/lib/subscribeNews.php",
                        type: "POST",
                        data: 'name='+name+'&email='+email+'&l='+lang,
                        cache: false,
                        global: true,
                        dataType: "html",
                        success: function(msg){ 
                            $('#subscribe').html("<center><p><br><br>"+thanks+"<br><br><br></p></center><a href='#close-modal' rel='modal:close' class='close-modal'>Close</a>");
			    console.log(msg);
                         },
                        error: function (xhr, ajaxOptions, thrownError){
                            alert(xhr.status);
                        }
                    });
}


function subscribeNews2(name,surname,email,check,lang,thanks) {
if (!check) return false;
thanks=thanks.replace("`","'");

                    $.ajax({
                        url: "/lib/subscribeNews.php",
                        type: "POST",
                        data: 'name='+name+'&surname='+surname+'&email='+email+'&l='+lang,
                        cache: false,
                        global: true,
                        dataType: "html",
                        success: function(msg){
                            $('#subscribe').html("<center><p><br><br>"+thanks+"<br><br><br></p></center>");
                            console.log(msg);
                         },
                        error: function (xhr, ajaxOptions, thrownError){
                            alert(xhr.status);
                        }
                    });
}
