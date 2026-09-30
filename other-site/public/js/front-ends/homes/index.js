$( document ).ready(function() {

	$(".client-carousel").owlCarousel({
	    loop: !0,
	    margin: 20,
	    dots: !0,
	    nav: !1,
	    rtl: !1,
	    autoplayHoverPause: !1,
	    autoplay: !0,
	    singleItem: !0,
	    smartSpeed: 1200,
	    navText: ['<i class="fa fa-arrow-left"></i>', '<i class="fa fa-arrow-right"></i>'],
	    responsive: {
	        0: { items: 1, center: !1 },
	        480: { items: 1, center: !1 },
	        600: { items: 2, center: !1 },
	        768: { items: 3 },
	        992: { items: 4 },
	        1200: { items: 4 },
	        1366: { items: 4 },
	        1400: { items: 4 }
	    },
	});
	
});