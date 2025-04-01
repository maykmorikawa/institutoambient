var $window = $(window);

$(document).ready(function() {

    // scroll to top
    $window.on('scroll', function() {
        if ($(this).scrollTop() > 500) {
            $(".scroll-to-top").fadeIn(400);

        } else {
            $(".scroll-to-top").fadeOut(400);
        }
    });

    $(".scroll-to-top").on('click', function(event) {
        event.preventDefault();
        $("html, body").animate({
            scrollTop: 0
        }, 600);
    });

    // redirect
    $(".animate-redirect a[href^='#']").click(function(e) {
        e.preventDefault();

        var position = $($(this).attr("href")).offset().top;

        $("body, html").animate({
            scrollTop: position
        }, 1000);
    });

    // demos-category carousel
    $(".demos-carousel").owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        smartSpeed: 1200,
        autoplayTimeout: 2800,
        nav: false,
        dots: true,
        navText: ['<span class="fas fa-chevron-left"></span>', '<span class="fas fa-chevron-right"></span>'],
        responsive: {
            0: {
                items: 1,
                margin: 0,
                dots: false
            },
            481: {
                items: 2,
                margin: 5,
            },
            500: {
                items: 2,
                margin: 20,
            },
            992: {
                items: 3,
                margin: 30,
            },
            1200: {
                items: 4,
                margin: 30,
            }
        }
    });

    $('.current-year').text(new Date().getFullYear());

});