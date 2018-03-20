 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="dist/js/jquery-ui.min.js"></script>
    <!-- <script src="dist/js/bootstrap.min.js"></script> -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!-- <script src="dist/js/ie10-viewport-bug-workaround.js"></script>
	<script src="dist/js/masonry.pkgd.min.js"></script>
    <script src="dist/js/front.js"></script>
    <script type="text/javascript" src="calendar/js/jquery-1.6.1.min.js" > </script>
    <script type="text/javascript" src="calendar/js/jquery.ui.core.js" > </script>
    <script type="text/javascript" src="calendar/js/jquery.ui.datepicker.js" ></script>
    <script type="text/javascript" src="calendar/js/calendar.js" ></script> -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript">
	$('#carouselFade').carousel();
	</script>
    <!-- Preloader -->
<script type="text/javascript">
    //<![CDATA[
        $(window).on('load', function() { // makes sure the whole site is loaded 
            $('#status').fadeOut(); // will first fade out the loading animation 
            $('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website. 
            $('body').delay(350).css({'overflow':'visible'});
        })
    //]]>
</script>
    
	<script type="text/javascript" src="dist/js/script.js"></script>
    
    <a href="#0" class="cd-top"><img src="images/top.png" /></a>
    <script src="dist/js/main.js"></script> <!-- Gem jQuery -->
    

  	<!-- write script to toggle class on scroll -->
    <script>
    $(window).scroll(function() {
        if ($(this).scrollTop() > 1){  
            $('header').addClass("sticky");
        }
        else{
            $('header').removeClass("sticky");
        }
    });
    </script>
   
    <!--smooth scroll-->

	<script>
    // Smooth scroll for in page links - http://wibblystuff.blogspot.in/2014/04/in-page-smooth-scroll-using-css3.html
    // Improvements from - http://codepen.io/kayhadrin/pen/KbalA
    
    $(function() {
        var $window = $(window), $document = $(document),
            transitionSupported = typeof document.body.style.transitionProperty === "string", // detect CSS transition support
            scrollTime = 1; // scroll time in seconds
    
        $(document).on("click", "a[href*=#]:not([href=#])", function(e) {
            var target, avail, scroll, deltaScroll;
        
            if (location.pathname.replace(/^\//, "") == this.pathname.replace(/^\//, "") && location.hostname == this.hostname) {
                target = $(this.hash);
                target = target.length ? target : $("[id=" + this.hash.slice(1) + "]");
    
                if (target.length) {
                    avail = $document.height() - $window.height();
    
                    if (avail > 0) {
                        scroll = target.offset().top;
              
                        if (scroll > avail) {
                            scroll = avail;
                        }
                    } else {
                        scroll = 0;
                    }
    
                    deltaScroll = $window.scrollTop() - scroll;
    
                    // if we don't have to scroll because we're already at the right scrolling level,
                    if (!deltaScroll) {
                        return; // do nothing
                    }
    
                    e.preventDefault();
                    
                    if (transitionSupported) {
                        $("html").css({
                            "margin-top": deltaScroll + "px",
                            "transition": scrollTime + "s ease-in-out"
                        }).data("transitioning", scroll);
                    } else {
                        $("html, body").stop(true, true) // stop potential other jQuery animation (assuming we're the only one doing it)
                        .animate({
                            scrollTop: scroll + "px"
                        }, scrollTime * 1000);
                        
                        return;
                    }
                }
            }
        });
    
        if (transitionSupported) {
            $("html").on("transitionend webkitTransitionEnd msTransitionEnd oTransitionEnd", function(e) {
                var $this = $(this),
                    scroll = $this.data("transitioning");
                
                if (e.target === e.currentTarget && scroll) {
                    $this.removeAttr("style").removeData("transitioning");
                    
                    $("html, body").scrollTop(scroll);
                }
            });
        }
    });
    </script>

	<!-- Plugin JavaScript -->
    <script src="dist/js/jquery.easing.min.js"></script>
    <script src="dist/js/index.js"></script>
	
	<script type="text/javascript" src="dist/js/jquery.flexisel.js"></script>
<script type="text/javascript">

$(window).load(function() {
    $("#flexiselDemo1").flexisel();
    $("#flexiselDemo2").flexisel({
        enableResponsiveBreakpoints: true,
        responsiveBreakpoints: { 
            portrait: { 
                changePoint:480,
                visibleItems: 1
            }, 
            landscape: { 
                changePoint:640,
                visibleItems: 1
            },
            tablet: { 
                changePoint:768,
                visibleItems: 1
            }
        }
    });

    $("#flexiselDemo3").flexisel({
        visibleItems: 3,
        animationSpeed: 1000,
        autoPlay: false,
        autoPlaySpeed: 3000,            
        pauseOnHover: true,
        enableResponsiveBreakpoints: true,
        responsiveBreakpoints: { 
            portrait: { 
                changePoint:480,
                visibleItems: 1
            }, 
            landscape: { 
                changePoint:640,
                visibleItems: 2
            },
            tablet: { 
                changePoint:768,
                visibleItems: 3
            }
        }
    });

    $("#flexiselDemo4").flexisel({
        clone:false
    });
    
});
</script>


<script>
jQuery(document).ready(function ($) {
    $('.fancybox').fancybox({
        helpers: {
            media: {}
        }
    });
});
</script>

<!--fancybox scripts -->
    <script src="dist/js/jquery.fancybox.pack.js"></script>
	<script src="dist/js/helpers/jquery.fancybox-buttons.js"></script>
    <script src="dist/js/helpers/jquery.fancybox-media.js"></script>
    <script src="dist/js/helpers/jquery.fancybox-thumbs.js"></script>
    <script src="dist/js/jquery.mousewheel.min.js"></script>
    <script src="dist/js/jquery.lightbox.js"></script>
<script>
 // Initiate Lightbox
 // Button Text language is Turkish Kapat = Close, ?nceki = Previous, Sonraki = Next
 $(function() {
   $('.thumbnail-1 a').lightbox({
     closeButtonText: 'Kapat',
     previousButtonText: '?nceki',
     nextButtonText: 'Sonraki'
   }); 
 });
</script>
	

    