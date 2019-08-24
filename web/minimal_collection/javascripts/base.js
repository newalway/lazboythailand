$(function () {

    $('body').scrollspy({
        target: '#menu-navbar-collapse',
        offset: 150
    })

    if ($('.scrollTop').length) {
        var scrollTrigger = 100, // px
            backToTop = function () {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('.scrollTop').addClass('show');
                } else {
                    $('.scrollTop').removeClass('show');
                }
            };
        backToTop();
        $(window).on('scroll', function () {
            backToTop();
        });
        $('.scrollTop').on('click', function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: 0
            }, 700);
        });
    }

    $("a[href^='#'].link-click").click(function(e) {
    	e.preventDefault();
        // console.log($(this));
    	var position = $($(this).attr("href")).offset().top;

    	$("body, html").animate({
    		scrollTop: position - 75
    	}, 800 );
    });

    $('#menu-affix').affix({
        offset: {top: $('.img-cover').height()}
    });

    $('.owl-carousel').owlCarousel({
        items: 1,
        margin: 0,
        responsiveClass: true,
        smartSpeed: 2000,
        loop:true,
        autoplay:true,
        autoplayTimeout:5000,
        autoplayHoverPause:true,
        dots: ($(".owl-carousel .item").length > 1) ? true: false,
    });

    // var owl1 = $('#owl1');
    // owl1.owlCarousel({
    //     items: 1,
    //     margin: 0,
    //     responsiveClass: true,
    //     smartSpeed: 2000,
    //     loop:true,
    //     autoplay:true,
    //     autoplayTimeout:5000,
    //     autoplayHoverPause:true,
    //     dots: ($("#owl1 .item").length > 1) ? true: false,
    // });
    // owl1.on('changed.owl.carousel', function(event) {
    //     var current = event.item.index;
    //     var txt = $(event.target).find(".owl-item").eq(current).find("img").attr('data-title');
    //     // console.log(txt);
    //     $('#owlTxT1').html(txt);
    // })

    // var owl3 = $('#owl3');
    // owl3.owlCarousel({
    //     items: 1,
    //     margin: 0,
    //     responsiveClass: true,
    //     smartSpeed: 2000,
    //     loop:true,
    //     autoplay:true,
    //     autoplayTimeout:5000,
    //     autoplayHoverPause:true,
    //     dots: ($("#owl3 .item").length > 1) ? true: false,
    // });
    // owl3.on('changed.owl.carousel', function(event) {
    //     var current = event.item.index;
    //     var txt = $(event.target).find(".owl-item").eq(current).find("img").attr('data-title');
    //     // console.log(txt);
    //     $('#owlTxT3').html(txt);
    // })

});
