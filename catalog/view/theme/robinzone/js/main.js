$(function() {
    // $(".mainSlider").slick({
    //   lazyLoad: 'ondemand',
    //   infinite: true,
    //   dots: true,
    //   prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
    //   nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>"
    // });
    $('.itemPhotoSlider').slick({
        dots: false,
        vertical: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        verticalSwiping: true,
        arrows:true,
        centerMode: true,
        focusOnSelect: true,
        asNavFor:'.itemPhotoSl',
        prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-up'></i></button>",
        nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-down'></i></button>",
        responsive: [
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    vertical: false,
                    prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
                    nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>",
                }
            },
            {
                breakpoint: 470,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    vertical: false,
                    prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
                    nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>",
                }
            },
            {
                breakpoint: 355,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    vertical: false,
                    prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
                    nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>",
                }
            },
        ]
    });
    $('.itemPhotoSl').slick({
        dots: false,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        fade: true,
        asNavFor:'.itemPhotoSlider'
    });
    $('.noveltiesSlider').slick({
        dots: true,
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        // autoplay:true,
        // speed:300,
        prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
        nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>",
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,

                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            },
        ]
    });

    $('.articleSlider').slick({
        // dots: true,
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        // autoplay:true,
        // speed:300,
        prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
        nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>",
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,

                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            },
        ]
    });

    //                                         // RAITING
    $('.star.rating').click(function(){
        console.log( $(this).parent().data('stars') + ", " + $(this).data('rating'));
        $(this).parent().attr('data-stars', $(this).data('rating'));
    });

    //
    // function set_img(){
    //     $('.itemImgCover').on('click', function() {
    //         // var data = $(this).find('img').attr('src');
    //         var data = $(this).find('img').data('full_image');
    //         $('.itemPhoto_img').attr('src', data.substring(data.indexOf('/')));
    //         $('.itemPhoto a').attr('href', data.substring(data.indexOf('/')));
    //         $(document).ready(function() {
    //             if ($(window).width() > 700) {
    //                 $('.itemPhoto .itemPhoto_img').magnify({
    //                     speed: 200,
    //                     src: $('.itemPhoto a').attr('href')
    //                 });
    //             }
    //         });
    //         $(window).resize(function() {
    //             if ($(window).width() > 700) {
    //                 $('.itemPhoto .itemPhoto_img').magnify({
    //                     speed: 200,
    //                     src: $('.itemPhoto a').attr('href')
    //                 });
    //             }
    //         });
    //     });
    // }
    // set_img();


    //                                         // newsSlide

    $('.newsSlide').on('init', function(event, slick){
        $(this).append('<div class="slider-count"><p><span id="current">1</span> / <span id="total">'+slick.slideCount+'</span></p></div>');
    });
    $('.newsSlide').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        fade: true,
        prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
        nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>"
    });
    $('.newsSlide')
        .on('afterChange', function(event, slick, currentSlide, nextSlide){
            $('.slider-count #current').html(currentSlide+1);
        });


    //                                                    //BASKET

    $('.basket').click(function(){
        if($(this).find('.basket__details').is(':visible'))
            $(this).find('.basket__details').css('display','none');
        else
            $(this).find('.basket__details').css('display','block');
        $("body").click(function(e) {
            if($(e.target).closest(".basket").length==0) $(".basket__details").css("display","none");
            $('.basket__details').mouseleave(function() {
                $(this).css('display','none');
            });
        });
    });

    $('.fiveNews_list').mouseover(function() {
        $(this).find('.fiveNews_newsCount').css({'background': '#81bd46'}, 1000);
        $(this).find('.fiveNews_newsCount').css({'color': '#fff'}, 1000);
    });
    $('.fiveNews_list').mouseleave(function() {
        $(this).find('.fiveNews_newsCount').css({'background': 'transparent'}, 1000);
        $(this).find('.fiveNews_newsCount').css({'color': '#3c3a3a'}, 1000);
    });


    // $(function() {
    //     var quantity = $(".quantity");
    //     quantity.prepend('<div class="inc button">-</div>');
    //     quantity.append('<div class="dec button">+</div>');
    //
    //     $(".quantity .button").on("click", function() {
    //
    //         var $button = $(this);
    //         var oldValue = $button.parent().find("input").val();
    //
    //         if ($button.text() == "+") {
    //             var newVal = parseFloat(oldValue) + 1;
    //         } else {
    //
    //             if (oldValue > 0) {
    //                 var newVal = parseFloat(oldValue) - 1;
    //             } else {
    //                 newVal = 0;
    //             }
    //         }
    //
    //         $button.parent().find("input").val(newVal);
    //
    //     });
    // });


    $(function() {

        // $('.sizesList').click(function() {
        //     $('.sizesList').addClass('active');
        //     $('.sizesList').removeClass('active');
        //     $(this).addClass('active');
        // });

        $('.itemImgCover').click(function() {
            $('.itemImgCover').addClass('active');
            $('.itemImgCover').removeClass('active');
            $(this).addClass('active');
        });

        $('.payment_list').click(function() {
            $('.payment_list').addClass('active');
            $('.payment_list').removeClass('active');
            $(this).addClass('active');
        });

        $('.delivery_list').click(function() {
            $('.delivery_list').addClass('active');
            $('.delivery_list').removeClass('active');
            $(this).addClass('active');
        });

        $('.itemTabs_list').click(function() {
            $('.itemTabs_list').addClass('active');
            $('.itemTabs_list').removeClass('active');
            $(this).addClass('active');
        });

        $('.itemPhoto_terms_Mobile_list').click(function() {
            $('.itemPhoto_terms_Mobile_list').addClass('active');
            $('.itemPhoto_terms_Mobile_list').removeClass('active');
            $(this).addClass('active');
        });

        $('.cabinet_list').click(function() {
            $('.cabinet_list').addClass('active');
            $('.cabinet_list').removeClass('active');
            $(this).addClass('active');
        });
        $('.representativesCityOtion_list').click(function() {
            $('.representativesCityOtion_list').addClass('active');
            $('.representativesCityOtion_list').removeClass('active');
            $(this).addClass('active');
        });

        $('.return_step_list').click(function() {
            $('.return_step_list').addClass('active');
            $('.return_step_list').removeClass('active');
            $(this).addClass('active');
        });
        $('.return, .return_order_allStyle').click(function() {
            $('html,body').find('article').css("max-height") =="999px";
            $('.return').removeClass('active');
            $(this).addClass('active');
        });
    });

    // FOOTER



    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }


    //SLIDER HOVER



    $('.personal_c_mobile').on('click',function(){
        if($('html,body').find('.cabinet_block').css("left") =="-350px")
            $('.cabinet_block').animate({left: "-20px"}, 700 , "linear", function() {});
        else
            $('.cabinet_block').animate({left: "-350px"}, 700 , "linear", function() {});
        $("body").click(function(e) {
            if($(e.target).closest(".personal_c_mobile .fas").length==0) $(".cabinet_block").css("left","-350px");
            $('.cabinet_bloc').mouseleave(function() {
                $(this).css('left','-350px');
            });
        });
    });
    //
    // $('.noveltiesItem').mouseenter(function(){
    //     $(this).find('.noveltiesSlider__caption').animate({bottom: "-35px"});
    // });
    // $('.noveltiesItem, .noveltiesSlider__caption').mouseleave(function(){
    //     $(this).find('.noveltiesSlider__caption').animate({bottom: "-230px"});
    // });
    $('.morePhotos i.fas.fa-sort-down').on('click', function(){
        $('.morePhotos i.fas.fa-sort-down').css({display: 'none'});
        if ($('html, body').find('.aboutUs_slider').height() > '320px')
            $('.aboutUs_slider').css({ height: '320px'});
        else
        {
            $('.aboutUs_slider').css({height: 'auto'});
        }
    });

    // $(document).on('mouseenter', '.productItem', function(){
    //     $(this).find('.productItem__caption').animate({bottom: "130px"}); //125
    // });
    // $(document).on('mouseleave', '.productItem, .productItem__caption', function(){
    //     $(this).find('.productItem__caption').animate({bottom: "-140px"});
    // });


    $('.filtration_icon').on('click',function(){
        if($('html,body').find('.filtration').css("left") =="-450px")
            $('.filtration').animate({left: "5px"}, 700 , "linear", function() {});
        else
            $('.filtration').animate({left: "-450px"}, 700 , "linear", function() {});
        var $blockF = $('.filtration');
        var firstClick = true;
        $(document).bind('click.myEvent', function (e) {
            if (!firstClick && $(e.target).closest('.filtration').length == 0) {
                $blockF.css('left','-450px');
                $(document).unbind('click.myEvent');
            }
            firstClick = false;
        });
    });

    // $(".noveltiesSlider .look, .productItem .look, .productItem .look2").on('click', function(){
    //     if($('html,body').find('.modal_closeLook').css("display") =="none")
    //         $('html, body').find('.modal_closeLook').css('display', 'block');
    //     else
    //         $('html, body').find('.modal_closeLook').css('display', 'none');
    // });
    // $("#modal_close_closeLook").on('click', function(){
    //     $('html, body').find('.modal_closeLook').css('display', 'none');
    // });
    // $(".modal_closeLook").mouseleave( function(){
    //     $(this).css('display', 'none');
    // });
    $('.look2, .look').on('click', function(event){
        event.preventDefault();
        $('#overlay3').addClass('is-visible');
        $('.modal_closeLook').css('display', 'block');
        $('html,\n' + 'body').css('overflow-y', 'hidden');
    });


    $('#overlay3, #modal_close_closeLook').on('click', function(event){
        if( $(event.target).is('#modal_close, .fa, #gratitude') || $(event.target).is('#overlay3') ) {
            event.preventDefault();
            $(this).removeClass('is-visible');
            $('html,\n' + 'body').css('overflow-y', 'auto');
        }
    });

//                                                    //MORE CONTENT



    $(document).on('click', '.more_info', function(){
        var el = $(this);
        el.text() == el.data("text-swap")
            ? el.text(el.data("text-original"))
            : el.text(el.data("text-swap"));
        if($('html,body').find('.aboutUs__textBlock').css("height") =="175px")
            $('.aboutUs__textBlock').animate({height: "100%"}, 700 , "linear", function() {});
        else
            $('.aboutUs__textBlock').animate({height: "175px"}, 700 , "linear", function() {});
    });



    $('.top_marker').on('click',function(){
        if($('html,body').find('#map').css("height") =="250px")
            $('#map').animate({height: "450px"}, 700 , "linear", function() {});
        else
            $('#map').animate({height: "250px"}, 700 , "linear", function() {});
    });


    $('.contacts__title').on('click',function(){
        if($('html,body').find('.contacts__block').css("height") =="0px")
            $('.contacts__block').animate({height: "400px"}, 700 , "linear", function() {});
        else
            $('.contacts__block').animate({height: "0px"}, 700 , "linear", function() {});
    });





// //                                                    //CONTACT FORM 1
    jQuery(document).ready(function($){

        $('#subscribe, .write_block').on('click', function(event){
            event.preventDefault();
            $('#overlay').addClass('is-visible');
            $('html,\n' + 'body').css('overflow-y', 'hidden');
        });


        $('#overlay').on('click', function(event){
            if( $(event.target).is('#modal_close, .fa, #gratitude') || $(event.target).is('#overlay') ) {
                event.preventDefault();
                $(this).removeClass('is-visible');
                $('html,\n' + 'body').css('overflow-y', 'auto');
            }
        });

        $(document).keyup(function(event){
            if(event.which=='27'){
                $('#overlay, #overlay2, #overlay3, #overlay4').removeClass('is-visible');
                $('html,\n' + 'body').css('overflow-y', 'auto');
            }
        });

        // //                                                    //MODAL FABRIC
        // $('.fabricTypes_general').on('click', function(event){
        //     event.preventDefault();
        //     $('#overlay4').addClass('is-visible');
        // });

        $('#overlay4, #modal_close_fabric').on('click', function(event){
            if( $(event.target).is('#modal_close_fabric, .fa') || $(event.target).is('#overlay4') ) {
                event.preventDefault();
                $(this).removeClass('is-visible');
                $('html,\n' + 'body').css('overflow-y', 'auto');
            }
        });


// //                                                    //CONTACT FORM 2

        $('#gratitude, #subscribe_button').on('click', function(event){
            event.preventDefault();
            $('#overlay2').addClass('is-visible');
            $('html,\n' + 'body').css('overflow-y', 'hidden');
        });


        $('#overlay2').on('click', function(event){
            if( $(event.target).is('#gratitude_close, .fa') || $(event.target).is('#overlay2') ) {
                event.preventDefault();
                $(this).removeClass('is-visible');
                $('.overlay2add').remove();
                $('html,\n' + 'body').css('overflow-y', 'auto');
            }
        });

        $('.write_block').on('click', function(event){
            if( $(event.target).is('#gratitude_close, .fa') || $(event.target).is('#overlay3') ) {
                event.preventDefault();
                $(this).removeClass('is-visible');
                $('html,\n' + 'body').css('overflow-y', 'auto');
            }
        });


    });


//
// MASK NUMBER

    $(function() {
        $.mask.definitions['~'] = "[+-]";
        $("input[type='tel']").mask("+38 (999) 999-9999");
    });


//                                                     /*MOBILE-NAV*/

    $('.mobile .hamburger-menu').click(function(e) {
        var $message = $('.mobile-header-nav');

        if ($message.css('display') != 'block') {
            $message.show();

            var firstClick = true;
            $(document).bind('click.myEvent', function(e) {
                if (!firstClick && $(e.target).closest('#message').length == 0) {
                    $message.hide();
                    $(document).unbind('click.myEvent');
                }
                firstClick = false;
            });
        }

        e.preventDefault();
    });



    // SCROLL

    function up() {
        var top = Math.max(document.body.scrollTop,document.documentElement.scrollTop);
        if(top > 0) {
            window.scrollBy(0,-100);
            t = setTimeout('up()',20);
        }
        else clearTimeout(t);
        return false;
    }

});

// LANGUAGE

$(document).ready(function(){
    $("#lang-menu").hover(
        function(){
            $(this).addClass("cls-border-lang");
            $(this).children().eq(0).addClass("cls-borderbottom-lang");
            $("#lang-menu ul").stop().slideToggle(100);
        },
        function(){
            $(this).removeClass("cls-border-lang");
            $(this).children().eq(0).removeClass("cls-borderbottom-lang");
            $("#lang-menu ul").stop().slideToggle(100);
        }
    );
    $("#lang-menu ul li").on("click", function(){
        $lang = $(this).text();
        $("#lang-menu div").text($lang);
    });

});


// SORTING

function selectSortType(value) {
    $("#sorting span").text(value);
}
function selectCountProductOnPage(value) {
    $(".showOnPage_select").text(value);
}

$(document).ready(function(){
    $("#sorting").hover(
        function(){
            $(this).addClass("cls-border-lang");
            $(this).children().eq(0).addClass("cls-borderbottom-lang");
            $("#sorting ul").stop().slideToggle(100);
        },
        function(){
            $(this).removeClass("cls-border-lang");
            $(this).children().eq(0).removeClass("cls-borderbottom-lang");
            $("#sorting ul").stop().slideToggle(100);
        }
    );
    $("#sorting ul li input:radio").on("click", function(){
        $sorting = $(this).attr('value');
        $text = $(this).data('text');
        $("#sorting span").text($text);
        location.assign($sorting);
        // $(this).find('input').prop('checked', true);
    });



    $("#showOnPage").hover(
        function(){
            $(this).addClass("cls-border-lang");
            $(this).children().eq(0).addClass("cls-borderbottom-lang");
            $("#showOnPage ul").stop().slideToggle(100);
        },
        function(){
            $(this).removeClass("cls-border-lang");
            $(this).children().eq(0).removeClass("cls-borderbottom-lang");
            $("#showOnPage ul").stop().slideToggle(100);
        }
    );
    $("#showOnPage ul li").on("click", function(){
        var limit_val = $(this).data('value');
        $showOnPage = $(this).text();
        $("#showOnPage span").text($showOnPage);
        location.assign(limit_val);
    });


});


// SEARCH

$("#inpt_search").on('focus', function () {
    $(this).parent('label').addClass('active');
});

$("#inpt_search").on('blur', function () {
    if($(this).val().length == 0)
        $(this).parent('label').removeClass('active');
});



// MAP

function initMap() {
    var uluru = {lat: 49.4284773, lng: 26.9822041};
    var style = [
        {
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#f5f5f5"
                }
            ]
        },
        {
            "elementType": "labels.icon",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#616161"
                }
            ]
        },
        {
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "color": "#f5f5f5"
                }
            ]
        },
        {
            "featureType": "administrative.land_parcel",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#bdbdbd"
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#eeeeee"
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#757575"
                }
            ]
        },
        {
            "featureType": "poi.park",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#e5e5e5"
                }
            ]
        },
        {
            "featureType": "poi.park",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#9e9e9e"
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#ffffff"
                }
            ]
        },
        {
            "featureType": "road.arterial",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#757575"
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#dadada"
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#616161"
                }
            ]
        },
        {
            "featureType": "road.local",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#9e9e9e"
                }
            ]
        },
        {
            "featureType": "transit.line",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#e5e5e5"
                }
            ]
        },
        {
            "featureType": "transit.station",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#eeeeee"
                }
            ]
        },
        {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#c9c9c9"
                }
            ]
        },
        {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#9e9e9e"
                }
            ]
        }
    ];
    var myOptions = {
        zoom: 14.75,
        center: uluru,
        scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: style
    };

    var map = new google.maps.Map(document.getElementById('map'), myOptions);
       var image = {
            url: "catalog/view/theme/robinzone/img/marker.png",
            size: new google.maps.Size(80, 80),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(80, 80)
        };
        var marker = new google.maps.Marker({
            position: uluru,
            icon: image,
            title: 'Наше расположение',
            map: map,
            animation: google.maps.Animation.DROP
        });
        marker.addListener('click', function() {
          map.setZoom(18);
          map.setCenter(marker.getPosition());
        });
    }
    function toggleBounce() {
        if (marker.getAnimation() !== null) {
          marker.setAnimation(null);
        } else {
          marker.setAnimation(google.maps.Animation.BOUNCE);
        }
    }



// PRICE PANGE

(function($) {

        "use strict";

        var DEBUG = false,
            PLUGIN_IDENTIFIER = "RangeSlider";

        var RangeSlider = function( element, options ) {
            this.element = element;
            this.options = options || {};
            this.defaults = {
                output: {
                    prefix: '',
                    suffix: '',
                    format: function(output){
                        return output;
                    }
                },
                change: function(event, obj){}
            };

            this.metadata = $(this.element).data('options');
        };

        RangeSlider.prototype = {

            init: function() {
                if(DEBUG && console) console.log('RangeSlider init');
                this.config = $.extend( true, {}, this.defaults, this.options, this.metadata );

                var self = this;
                this.trackFull = $('<div class="track track--full"></div>').appendTo(self.element);
                this.trackIncluded = $('<div class="track track--included"></div>').appendTo(self.element);
                this.inputs = [];

                $('input[type="range"]', this.element).each(function(index, value) {
                    var rangeInput = this;

                    rangeInput.output = $('<output>').appendTo(self.element);
                    rangeInput.output.zindex = parseInt($(rangeInput.output).css('z-index')) || 1;
                    rangeInput.thumb = $('<div class="slider-thumb">').prependTo(self.element);
                    rangeInput.initialValue = $(this).val();

                    rangeInput.update = function() {
                        if(DEBUG && console) console.log('RangeSlider rangeInput.update');
                        var range = $(this).attr('max') - $(this).attr('min'),
                            offset = $(this).val() - $(this).attr('min'),
                            pos = offset / range * 100 + '%',
                            transPos = offset / range * -100 + '%',
                            prefix = typeof self.config.output.prefix == 'function' ? self.config.output.prefix.call(self, rangeInput) : self.config.output.prefix,
                            format = self.config.output.format($(rangeInput).val()),
                            suffix = typeof self.config.output.suffix == 'function' ? self.config.output.suffix.call(self, rangeInput) : self.config.output.suffix;

                        $(rangeInput.output).html(prefix + '' + format + '' + suffix);
                        $(rangeInput.output).css('left', pos);
                        $(rangeInput.output).css('transform', 'translate('+transPos+',0)');

                        $(rangeInput.thumb).css('left', pos);
                        $(rangeInput.thumb).css('transform', 'translate('+transPos+',0)');

                        self.adjustTrack();
                    };


                    rangeInput.sendOutputToFront = function() {
                        $(this.output).css('z-index', rangeInput.output.zindex + 1);
                    };


                    rangeInput.sendOutputToBack = function() {
                        $(this.output).css('z-index', rangeInput.output.zindex);
                    };


                    $(rangeInput.thumb).on('mousedown', function(event){

                        self.sendAllOutputToBack();

                        rangeInput.sendOutputToFront();

                        $(this).data('tracking', true);
                        $(document).one('mouseup', function() {

                            $(rangeInput.thumb).data('tracking', false);

                            self.change(event);
                        });
                    });

                    $('body').on('mousemove', function(event){

                        if($(rangeInput.thumb).data('tracking')) {
                            var rangeOffset = $(rangeInput).offset(),
                                relX = event.pageX - rangeOffset.left,
                                rangeWidth = $(rangeInput).width();

                            if(relX <= rangeWidth) {
                                var val = relX/rangeWidth;
                                $(rangeInput).val(val * $(rangeInput).attr('max'));
                                rangeInput.update();
                            }
                        }
                    });


                    $(this).on('mousedown input change touchstart', function(event) {
                        if(DEBUG && console) console.log('RangeSlider rangeInput, mousedown input touchstart');
                        self.sendAllOutputToBack();

                        rangeInput.sendOutputToFront();
                        rangeInput.update();
                    });

                    $(this).on('mouseup touchend', function(event){
                        if(DEBUG && console) console.log('RangeSlider rangeInput, change');
                        self.change(event);
                    });

                    self.inputs.push(this);
                });

                this.reset();

                return this;
            },

            sendAllOutputToBack: function() {
                $.map(this.inputs, function(input, index) {
                    input.sendOutputToBack();
                });
            },

            change: function(event) {
                if(DEBUG && console) console.log('RangeSlider change', event);
                // Get the values of each input
                var values = $.map(this.inputs, function(input, index) {
                    return {
                        value: parseInt($(input).val()),
                        min: parseInt($(input).attr('min')),
                        max: parseInt($(input).attr('max'))
                    };
                });

                values.sort(function(a, b) {
                    return a.value - b.value;
                });

                this.config.change.call(this, event, values);
            },

            reset: function() {
                if(DEBUG && console) console.log('RangeSlider reset');
                $.map(this.inputs, function(input, index) {
                    $(input).val(input.initialValue);
                    input.update();
                });
            },

            adjustTrack: function() {
                if(DEBUG && console) console.log('RangeSlider adjustTrack');
                var valueMin = Infinity,
                    rangeMin = Infinity,
                    valueMax = 0,
                    rangeMax = 0;

                $.map(this.inputs, function(input, index) {
                    var val = parseInt($(input).val()),
                        min = parseInt($(input).attr('min')),
                        max = parseInt($(input).attr('max'));

                    valueMin = (val < valueMin) ? val : valueMin;
                    valueMax = (val > valueMax) ? val : valueMax;
                    rangeMin = (min < rangeMin) ? min : rangeMin;
                    rangeMax = (max > rangeMax) ? max : rangeMax;
                });

                if(this.inputs.length > 1) {
                    this.trackIncluded.css('width', (valueMax - valueMin) / (rangeMax - rangeMin) * 100 + '%');
                    this.trackIncluded.css('left', (valueMin - rangeMin) / (rangeMax - rangeMin) * 100 + '%');
                } else {
                    this.trackIncluded.css('width', valueMax / (rangeMax - rangeMin) * 100 + '%');
                    this.trackIncluded.css('left', '0%');
                }
            }
        };

        RangeSlider.defaults = RangeSlider.prototype.defaults;

        $.fn.RangeSlider = function(options) {
            if(DEBUG && console) console.log('$.fn.RangeSlider', options);
            return this.each(function() {
                var instance = $(this).data(PLUGIN_IDENTIFIER);
                if(!instance) {
                    instance = new RangeSlider(this, options).init();
                    $(this).data(PLUGIN_IDENTIFIER,instance);
                }
            });
        };

    }
)(jQuery);


var rangeSlider = $('#facet-price-range-slider');
if(rangeSlider.length > 0) {
    rangeSlider.RangeSlider({
        output: {
            format: function(output){
                return output.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            }
        }
    });
}

// FORM RADIO BUTTONS

$('input:radio').bind('click mousedown', (function() {
    var isChecked;

    return function(event) {
        if(event.type == 'click') {
            if(isChecked) {
                isChecked = this.checked = false;
            } else {
                isChecked = true;
            }
        } else {
            isChecked = this.checked;
        }
    }})());


// SIZES BUTTONS



$(document).ready(function() {
    $('#SizesOptions input:checkbox').on('click', function(){
        if($(this).is(':checked'))
            $(this).parent().find('.filtration_form_label').css('background-color', 'rgb(139, 195, 74)');
        else
            $(this).parent().find('.filtration_form_label').css('background-color', 'rgb(255, 255, 255)');
    });

    $('#SizesOptions input:checkbox').each(function(element){
        if($(this).is(':checked'))
            $(this).parent().find('.filtration_form_label').css('background-color', 'rgb(139, 195, 74)');
        else
            $(this).parent().find('.filtration_form_label').css('background-color', 'rgb(255, 255, 255)');
    });

    $('#filtration_button').on('click', function(){
        $('#SizesOptions .filtration_form_label').css('background-color', 'rgb(255, 255, 255)');
    });

});

// INNER PAGE TABS
function openBlock(blockName,elmnt) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("itemTabs_content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("itemTabs_list");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].style.backgroundColor = "";
    }
    document.getElementById(blockName).style.display = "block";

}
// document.getElementById("defaultOpen").click();



// INNER PAGE TABS -2
function openBlock2(blockName2,elmnt2) {
    var i, tabcontent2, tablinks2;
    tabcontent2 = document.getElementsByClassName("tb_c");
    for (i = 0; i < tabcontent2.length; i++) {
        tabcontent2[i].style.display = "none";
    }
    tablinks2 = document.getElementsByClassName("itemPhoto_terms_Mobile_list");
    for (i = 0; i < tablinks2.length; i++) {
        tablinks2[i].style.backgroundColor = "";
    }
    document.getElementById(blockName2).style.display = "block";

}
// document.getElementById("defaultOpen2").click();

// INNER PAGE TABS -3
function openBlock3(blockAdress, elmnt3) {
    var i, tabcontent3;
    tabcontent3 = document.getElementsByClassName("representativesAdress_c");
    for (i = 0; i < tabcontent3.length; i++) {
        tabcontent3[i].style.display = "none";
    }
    $('#' + blockAdress).css('display', 'block');
}

$(function () {
    $(document).on('click', '.representativesCityOtion_list', function (e) {
        e.preventDefault();
        let alias, city;
        alias = $(this).data('alias');
        city = $(this).data('city');
        openBlock3(alias);
    });
});
function setup() {
    var num = 8,
        ang = 360 / num,
        rad = num * 7,
        run = 2;
    var $preloader = $('.preloader'),
        $spinner   = $preloader.find('#hold');
    document.getElementById("hold").innerHTML = "";

    for (var i = 0; i < num; i++) {
        var button = document.createElement('div');
        button.className = "dot" + i + " dot";
        button.style.top = rad * Math.cos(ang * i * Math.PI / 180) - 10 + "px";
        button.style.left = rad * Math.sin(ang * i * Math.PI / 180) - 10 + "px";
        button.style.backgroundColor = "hsla(" + ang * i + ", 30%, 90%, 1)";

        button.style.webkitAnimation =
            "osc " + run + "s  infinite " + i / (num / 2) + "s, rainbow 5s infinite  " + i / (num / 2) + "s";
        button.style.animation =
            "osc " + run + "s  infinite " + i / (num / 2) + "s, rainbow 5s infinite  " + i / (num / 2) + "s";

        document.getElementById("hold").appendChild(button);
    }
}
setup();
//preloader
$(window).on('load', function () {

    var $preloader = $('.preloader'),
        $spinner   = $preloader.find('#hold');

    $preloader.fadeOut();


});
$('.scrollUp').on('click', function(){
    $('body').scrollTo('#selectorScroll', 700, {over: {top: -1, left: 0}});
});