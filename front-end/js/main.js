$(document).on('ready', function() {
    $(".mainSlider").slick({
      lazyLoad: 'ondemand',
      infinite: true,
      dots: true,
      prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
      nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>"
    });
    $('.itemPhotoSlider').slick({
      dots: false,
      vertical: true,
      slidesToShow: 4,
      slidesToScroll: 4,
      verticalSwiping: true,
      arrows:true,
      prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-up'></i></button>",
      nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-down'></i></button>",
      responsive: [
      {
          breakpoint: 576,
          settings: {
              slidesToShow: 4,
              vertical: false,
              prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
              nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>",
          }
        },
        {
          breakpoint: 470,
          settings: {
              slidesToShow: 3,
              vertical: false,
              prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
              nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>",
          }
        },
        {
          breakpoint: 355,
          settings: {
              slidesToShow: 2,
              vertical: false,
              prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
              nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>",
          }
        },
        ] 
    });
    $(".noveltiesSlider").slick({
      dots: true,
      infinite: true,
      slidesToShow: 4,
      slidesToScroll: 2,
       prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
      nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>",
      responsive: [
    {
            breakpoint: 1200,
            settings: {
                slidesToShow: 3
            }
        },
        {
            breakpoint: 991,
            settings: {
                slidesToShow: 2
            }
        },
         {
            breakpoint: 768,
            settings: {
                slidesToShow: 1
            }
        },
        ] 
    });
    $(".aboutUs_rewards_slider").slick({
      dots: true,
      infinite: true,
      slidesToShow: 5,
      slidesToScroll: 2,
      arrows:true,
      prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
      nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>",
      responsive: [
    {
            breakpoint: 1200,
            settings: {
                slidesToShow: 4
            }
        },
        {
            breakpoint: 835,
            settings: {
                slidesToShow: 3
            }
        },
         {
            breakpoint: 550,
            settings: {
                slidesToShow: 1
            }
        },
        ] 
    });
    $(".aboutUs_ourCompany_slider").slick({
      dots: true,
      infinite: true,
      slidesToShow: 4,
      slidesToScroll: 2,
      arrows:true,
      prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
      nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>",
      responsive: [
    {
            breakpoint: 1200,
            settings: {
                slidesToShow: 3
            }
        },
        {
            breakpoint: 835,
            settings: {
                slidesToShow: 2
            }
        },
         {
            breakpoint: 550,
            settings: {
                slidesToShow: 1
            }
        },
        ] 
    });

$('.slideInit').on('click', function(){
    $(".fabricQuality_slider").slick({
        dots: true,
        infinite: true,
        arrows:true,
        slidesToShow: 2,
        slidesToScroll: 2,
        prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
        nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>",
         responsive: [
      {
          breakpoint: 1200,
          settings: {
              slidesToShow: 1
          }
        },
        {
          breakpoint: 768,
          settings: {
              slidesToShow: 2
          }
        },
         {
          breakpoint: 550,
          settings: {
              slidesToShow: 1
          }
        },
        ] 
      });
})
//                                         // RAITING
  $('.star.rating').click(function(){
    console.log( $(this).parent().data('stars') + ", " + $(this).data('rating'));
    $(this).parent().attr('data-stars', $(this).data('rating'));
  });


  function set_img(){
     $('.itemImgCover').on('click', function() {  
      var data = $(this).find('img').attr('src');
      $('.itemPhoto_img').attr('src', 'img/'+data.substring(data.indexOf('/')));
    }); 
  }
  set_img();

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


//                                                    //SEARCH DIRECTION PAGE
// $("select").each(function() {
//   var $this = $(this),
//     numberOfOptions = $(this).children("option").length;

//   $this.addClass("select-hidden");
//   $this.wrap('<div class="select"></div>');
//   $this.after('<div class="select-styled"></div>');

//   var $styledSelect = $this.next("div.select-styled");
//   $styledSelect.text(
//     $this
//       .children("option")
//       .eq(0)
//       .text()
//   );

//   var $list = $("<select/>", {
//     class: "select-options"
//   }).insertAfter($styledSelect);

//   for (var i = 0; i < numberOfOptions; i++) {
//     $("<option />", {
//       text: $this
//         .children("option")
//         .eq(i)
//         .text(),
//       rel: $this
//         .children("option")
//         .eq(i)
//         .val()
//     }).appendTo($list);
//   }

//   var $listItems = $list.children("select");

//   $styledSelect.click(function(e) {
//     e.stopPropagation();
//     $("div.select-styled.active")
//       .not(this)
//       .each(function() {
//         $(this)
//           .removeClass("active")
//           .next("select.select-options")
//           .hide();
//       });
//     $(this)
//       .toggleClass("active")
//       .next("select.select-options")
//       .toggle();
//   });

//   $listItems.click(function(e) {
//     e.stopPropagation();
//     $styledSelect.text($(this).text()).removeClass("active");
//     $this.val($(this).attr("rel"));
//     $list.hide();
//   });

//   $(document).click(function() {
//     $styledSelect.removeClass("active");
//     $list.hide();
//   });
// });
$(document).ready(function() {
 $('select').niceSelect();
});




                                                    // DELIVERY



  
$(function() {
    var quantity = $(".quantity");
      quantity.prepend('<div class="inc button">-</div>');
      quantity.append('<div class="dec button">+</div>');

    $(".quantity .button").on("click", function() {

        var $button = $(this);
        var oldValue = $button.parent().find("input").val();

        if ($button.text() == "+") {
            var newVal = parseFloat(oldValue) + 1;
        } else {

            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }

        $button.parent().find("input").val(newVal);

    });
});



$(function() {
          
      $('.sizesList').click(function() {
          $('.sizesList').addClass('active');
          $('.sizesList').removeClass('active');
          $(this).addClass('active');             
      });

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



   $('.noveltiesItem').mouseenter(function(){
        $(this).find('.noveltiesSlider__caption').animate({bottom: "-35px"});
    });
     $('.noveltiesItem, .noveltiesSlider__caption').mouseleave(function(){
        $(this).find('.noveltiesSlider__caption').animate({bottom: "-230px"});
    });


  $('.morePhotos i.fas.fa-sort-down').on('click', function(){
        if ($('html, body').find('.aboutUs_slider').height() > '320px') 
          $('.aboutUs_slider').css({ height: '320px'});
        else 
        {
          $('.aboutUs_slider').css({height: 'auto'});
        }
    });


    $('.productItem').mouseenter(function(){
        $(this).find('.productItem__caption').animate({bottom: "125px"});
    });
     $('.productItem, .productItem__caption').mouseleave(function(){
        $(this).find('.productItem__caption').animate({bottom: "-140px"});
    });


     $('.filtration_icon').on('click',function(){
    if($('html,body').find('.filtration').css("left") =="-450px")
        $('.filtration').animate({left: "5px"}, 700 , "linear", function() {});
    else
         $('.filtration').animate({left: "-450px"}, 700 , "linear", function() {});
     $("body").click(function(e) {
          if($(e.target).closest(".filtration_icon").length==0) $(".filtration").css("left","-450px");
        $('.filtration').mouseleave(function() {
            $(this).css('left','-450px');
        });
      });
    });


    $('.personal_c_mobile .fas').on('click',function(){
    if($('html,body').find('.cabinet_block').css("left") =="-200px")
        $('.cabinet_block').animate({left: "50px"}, 700 , "linear", function() {});
    else
         $('.cabinet_block').animate({left: "-200px"}, 700 , "linear", function() {});
     $("body").click(function(e) {
          if($(e.target).closest(".personal_c_mobile .fas").length==0) $(".cabinet_block").css("left","-200px");
        $('.cabinet_block').mouseleave(function() {
            $(this).css('left','-200px');
        });
      });
    });



//                                                    //MORE CONTENT



  $('.more_info').on('click',function(){
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
  });
  $('#overlay').on('click', function(event){
    if( $(event.target).is('#modal_close, .fa, #gratitude') || $(event.target).is('#overlay') ) {
      event.preventDefault();
      $(this).removeClass('is-visible');
    }
  });


// //                                                    //MODAL FABRIC
  $('.fabricTypes_general').on('click', function(event){
    event.preventDefault();
    $('#overlay4').addClass('is-visible');
  });

    $('#overlay4, #modal_close_fabric').on('click', function(event){
    if( $(event.target).is('#modal_close_fabric, .fa') || $(event.target).is('#overlay4') ) {
      event.preventDefault();
      $(this).removeClass('is-visible');
    }
  });


  $(document).keyup(function(event){
      if(event.which=='27'){
        $('#overlay, #overlay2, #overlay3, #overlay4').removeClass('is-visible');
      }
    });



  $('.look2, .look').on('click', function(event){
    event.preventDefault();
    $('#overlay3').addClass('is-visible');
    $('.modal_closeLook').css('display', 'block');
    $('.closeLookSlider').slick({
      dots: false,
      vertical: true,
      slidesToShow: 3,
      slidesToScroll: 3,
      verticalSwiping: true,
      arrows:true,
      prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-up'></i></button>",
      nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-down'></i></button>",
      responsive: [
      {
          breakpoint: 576,
          settings: {
              slidesToShow: 3,
              vertical: false,
              prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
              nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>",
          }
        },
        {
          breakpoint: 425,
          settings: {
              slidesToShow: 2,
              vertical: false,
              prevArrow:"<button type='button' class='slick-prev'><i class='fas fa-chevron-left'></i></button>",
              nextArrow:"<button type='button' class='slick-next'><i class='fas fa-chevron-right'></i></button>",
          }
        },
        ] 
    });
  });
  
 
  $('#overlay3, #modal_close_closeLook').on('click', function(event){
    if( $(event.target).is('#modal_close, .fa, #gratitude') || $(event.target).is('#overlay3') ) {
      event.preventDefault();
      $(this).removeClass('is-visible');
    }
  });


// //                                                    //CONTACT FORM 2

  $('#gratitude, #subscribe_button').on('click', function(event){
    event.preventDefault();
    $('#overlay2').addClass('is-visible');
  });
  
 
  $('#overlay2').on('click', function(event){
    if( $(event.target).is('#gratitude_close, .fa') || $(event.target).is('#overlay2') ) {
      event.preventDefault();
      $(this).removeClass('is-visible');
    }
  });

    $('.write_block').on('click', function(event){
    if( $(event.target).is('#gratitude_close, .fa') || $(event.target).is('#overlay3') ) {
      event.preventDefault();
      $(this).removeClass('is-visible');
    }
  });


});


    
                                                // MASK NUMBER

$(function() {
    $.mask.definitions['~'] = "[+-]";
    $("input[type='tel']").mask("+38 (999) 999-9999");
});


//                                                     /*MOBILE-NAV*/

  $('.mobile').on('click', function(){ 
    if($(this).find('.mobile-header-nav').is(':visible')) 
        $(this).find('.mobile-header-nav').css('display','none'); 
    else 
      $(this).find('.mobile-header-nav').css('display','block');  
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
      $("#sorting span").text($sorting);
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
      $showOnPage = $(this).text();
      $("#showOnPage span").text($showOnPage);
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

var initMap = function() {
    var uluru = {lat: 50.45995280098533, lng: 30.509765989148264};
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
            zoom: 12,
            center: uluru,
            scrollwheel:  false,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: style
        }
      var image = {
          url: "img/marker.png", 
          size: new google.maps.Size(60, 60),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(17, 34),
          scaledSize: new google.maps.Size(60, 60) 
      };
      var map3 = new google.maps.Map(document.getElementById('map'), myOptions);
        var marker = new google.maps.Marker({
          position: uluru,
          icon:image,
          map: map3
        });
        marker.addListener('click', function() {
          map3.setZoom(17);
          map3.setCenter(marker.getPosition());
        });
}
 initMap()
  

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
      },
      suffix: function(input){
        return parseInt($(input).val()) == parseInt($(input).attr('max')) ? this.config.maxSymbol : '';
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
  $('#SizesOptions input:radio').on('click', function(){
    if($(this).is(':checked'))
       $(this).parent().find('.filtration_form_label').css('background-color', 'rgb(139, 195, 74)');
    else
     $(this).parent().find('.filtration_form_label').css('background-color', 'rgb(255, 255, 255)');
  })

  $('#filtration_button').on('click', function(){
     $('#SizesOptions .filtration_form_label').css('background-color', 'rgb(255, 255, 255)');
  })

});



                                       // PAGINATION BOTTOM
let pages = 25;

document.getElementById('pagination').innerHTML = createPagination(pages, 1);

function createPagination(pages, page) {
  let str = '<ul>';
  let active;
  let pageCutLow = page - 1;
  let pageCutHigh = page + 1;
  if (page > 1) {
    str += '<li class="page-item previous no"><a onclick="createPagination(pages, '+(page-1)+')"><i class="fas fa-chevron-left"></i></a></li>';
  }

  if (pages < 6) {
    for (let p = 1; p <= pages; p++) {
      active = page == p ? "active" : "no";
      str += '<li class="'+active+'"><a onclick="createPagination(pages, '+p+')">'+ p +'</a></li>';
    }
  }
  else {
    if (page > 2) {
      str += '<li class="no page-item"><a onclick="createPagination(pages, 1)">1</a></li>';
      if (page > 3) {
          str += '<li class="out-of-range"><a onclick="createPagination(pages,'+(page-2)+')">...</a></li>';
      }
    }

    if (page === 1) {
      pageCutHigh += 2;
    } else if (page === 2) {
      pageCutHigh += 1;
    }

    if (page === pages) {
      pageCutLow -= 2;
    } else if (page === pages-1) {
      pageCutLow -= 1;
    }

    for (let p = pageCutLow; p <= pageCutHigh; p++) {
      if (p === 0) {
        p += 1;
      }
      if (p > pages) {
        continue
      }
      active = page == p ? "active" : "no";
      str += '<li class="page-item '+active+'"><a onclick="createPagination(pages, '+p+')">'+ p +'</a></li>';
    }

    if (page < pages-1) {
      if (page < pages-2) {
        str += '<li class="out-of-range"><a onclick="createPagination(pages,'+(page+2)+')">...</a></li>';
      }
      str += '<li class="page-item no"><a onclick="createPagination(pages, pages)">'+pages+'</a></li>';
    }
  }

  if (page < pages) {
    str += '<li class="page-item next no"><a onclick="createPagination(pages, '+(page+1)+')"><i class="fas fa-chevron-right"></i></a></li>';
  }
  str += '</ul>';

  document.getElementById('pagination').innerHTML=str;
  return str;
}



                                                      // PAGINATION TOP


var pr = document.querySelector( '.paginate.left' );
var pl = document.querySelector( '.paginate.right' );

pr.onclick = slide.bind( this, -1 );
pl.onclick = slide.bind( this, 1 );

var index = 0, total = 20;

function slide(offset) {
  index = Math.min( Math.max( index + offset, 0 ), total - 1 );

  document.querySelector( '.counter' ).innerHTML = ( index + 1 ) + ' из ' + total;

  pr.setAttribute( 'data-state', index === 0 ? 'disabled' : '' );
  pl.setAttribute( 'data-state', index === total - 1 ? 'disabled' : '' );
}

slide(0);




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
document.getElementById("defaultOpen").click();



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
document.getElementById("defaultOpen2").click();



                                                    // INNER PAGE TABS -3
function openBlock3(blockAdress,elmnt3) {
    var i, tabcontent3, tablinks3;
    tabcontent3 = document.getElementsByClassName("representativesAdress_c");
    for (i = 0; i < tabcontent3.length; i++) {
        tabcontent3[i].style.display = "none";
    }
    tabcontent4 = document.getElementsByClassName("representativesAdress_c2");
    for (i = 0; i < tabcontent4.length; i++) {
        tabcontent4[i].style.display = "none";
    }
    tablinks3 = document.getElementsByClassName("representativesCityOtion_list");
    for (i = 0; i < tablinks3.length; i++) {
        tablinks3[i].style.backgroundColor = "";
    }
    document.getElementById(blockAdress).style.display = "block";

}
document.getElementById("defaultOpen").click();
