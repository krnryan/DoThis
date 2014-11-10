$(function() {
	//Scrolling feature (requires jQuery Easing plugin)
    $('.page-scroll a').bind('click', function(event) {
        var $link = $(this);
        $('html, body').stop().animate({
            scrollTop: $($link.attr('href')).offset().top
        }, 1000, 'easeInOutExpo');
        //This prevents event to take the browser to a new URL
        event.preventDefault();
    });
    
    //Top button disappears when the window is scrolled to the top
    $(window).scroll(function() {
        if ($(this).scrollTop() > 1) {
            $('#to_top').fadeIn(500);
        } else {        
            $('#to_top').fadeOut(500);
        }
    });
    
    //Highlights current nav list
    $('body').scrollspy({
	    target: '.navbar-fixed-top'
	});
	
	//Auto-collapsing feature after clicking list
	$('.navbar-collapse ul li a').click(function() {
	    $('.navbar-toggle:visible').click();
	});
	
	(function() {
	  var delay = false;
	
	  $(document).on('mousewheel DOMMouseScroll', function(event) {
	    event.preventDefault();
	    if(delay) return;
	
	    delay = true;
	    setTimeout(function(){delay = false},200)
	
	    var wd = event.originalEvent.wheelDelta || -event.originalEvent.detail;
	
	    var a= document.getElementsByClassName('scrollpoint');
	    if(wd < 0) {
	      for(var i = 0 ; i < a.length ; i++) {
	        var t = a[i].getClientRects()[0].top;
	        if(t >= 40) break;
	      }
	    }
	    else {
	      for(var i = a.length-1 ; i >= 0 ; i--) {
	        var t = a[i].getClientRects()[0].top;
	        if(t < -20) break;
	      }
	    }
	    $('html,body').animate({
	      scrollTop: a[i].offsetTop
	    });
	  });
	})();

});