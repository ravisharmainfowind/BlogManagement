$(function(){

 
    // $(window).load(function() {
	// 	// Animate loader off screen
	// 	$('body').toggleClass("loading");;
    // });
    
    $('.navToggle > a').on('click',function(){
        $(this).toggleClass('togglemenu');
       $('.navCustom').toggleClass('openmenu');
    });

    $('.templateFrame').each(function(){
        $(this).click(function(){
            $(this).addClass('active').siblings('.templateFrame').removeClass('active');
        });
    });
});

$('.owl-carousel.main-slider').owlCarousel({
    loop:true,
    autoplay:true,
    margin:10,
    nav:false,
    dots:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
});
$('.owl-carousel.slider-1').owlCarousel({
    loop:true,
    autoplay:true,
    margin:10,
    nav:true,
    dots:false,
    navText : ["<span class='spider-icon nextarrow'></span>","<span class='spider-icon nextarrow'></span>"],
    responsive:{
        0:{
            items:2.5
        },
        600:{
            items:2.5
        },
        1000:{
            items:5
        }
    }
});
$('.owl-carousel.slider-2').owlCarousel({
    loop:true,
    autoplay:true,
    margin:10,
    nav:true,
    dots:false,
    navText : ["<span class='spider-icon nextarrow'></span>","<span class='spider-icon nextarrow'></span>"],
    responsive:{
        0:{
            items:2.5
        },
        600:{
            items:2.5
        },
        1000:{
            items:5
        }
    }
});
$('.owl-carousel.slider-3').owlCarousel({
    loop:true,
    autoplay:true,
    margin:10,
    nav:true,
    dots:false,
    navText : ["<span class='spider-icon nextarrow'></span>","<span class='spider-icon nextarrow'></span>"],
    responsive:{
        0:{
            items:2.5
        },
        600:{
            items:2.5
        },
        1000:{
            items:5
        }
    }
});
$('.owl-carousel.slider-4').owlCarousel({
    loop:true,
    autoplay:true,
    margin:10,
    nav:true,
    dots:false,
    navText : ["<span class='spider-icon nextarrow'></span>","<span class='spider-icon nextarrow'></span>"],
    responsive:{
        0:{
            items:2.5
        },
        600:{
            items:2.5
        },
        1000:{
            items:5
        }
    }
});
$('.owl-carousel.slider-5').owlCarousel({
    loop:true,
    autoplay:true,
    margin:10,
    nav:true,
    dots:false,
    navText : ["<span class='spider-icon nextarrow'></span>","<span class='spider-icon nextarrow'></span>"],
    responsive:{
        0:{
            items:2.5
        },
        600:{
            items:2.5
        },
        1000:{
            items:5
        }
    }
});
$('.owl-carousel.slider-6').owlCarousel({
    loop:true,
    autoplay:true,
    margin:10,
    nav:true,
    dots:false,
    navText : ["<span class='spider-icon nextarrow'></span>","<span class='spider-icon nextarrow'></span>"],
    responsive:{
        0:{
            items:2.5
        },
        600:{
            items:2.5
        },
        1000:{
            items:5
        }
    }
});
$('.owl-carousel.testimonial').owlCarousel({
    loop:true,
    autoplay:true,
    margin:50,
    nav:true, 
    dots:true,
    navText : ["<span class='spider-icon arrow-left-icon'></span>","<span class='spider-icon arrow-right-icon'></span>"],
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:3
        }
    }
});








