jQuery(document).ready(function ($) {

    $('.slider').slick({
        dots: true,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 4000, // speed is in milliseconds
        speed: 300,
        arrows: false,

    });

});