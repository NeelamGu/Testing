<script src="{{ url('front/js/jquery.js') }}"></script>
<script src="{{ url('front/js/bootstrap.min.js') }}"></script>
<script src="{{ url('front/js/js-collection.js') }}"></script>
<script src="{{ url('front/js/flipclock.js') }}"></script>
<script src="{{ url('front/js/jquery-ui.min.js') }}"></script>
<script src="{{ url('front/js/owl.carousel.min.js') }}"></script>
<script src="{{ url('front/js/script.js') }}"></script>
<script src="{{ url('front/js/jquery.fancybox.min.js') }}"></script>
<script src="{{ url('front/js/custom.js') }}"></script>
<script src="{{ url('front/js/jquery.fancybox.min.js') }}"></script>

<!-- Confirm deletion -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Appointment Form Validation-->
<script type="text/javascript">
   $("#appointment_form").validate({
   
       submitHandler: function (form) {
   
           var form_btn = $(form).find('button[type="submit"]');
   
           var form_result_div = '#form-result';
   
           $(form_result_div).remove();
   
           form_btn.before('<div id="form-result" class="alert alert-success" role="alert" style="display: none;"></div>');
   
           var form_btn_old_msg = form_btn.html();
   
           form_btn.html(form_btn.data("loading-text"));
   
           $(form).ajaxSubmit({
   
               target: form_result_div,
   
               success: function (data) {
   
                   form_btn.html(form_btn_old_msg);
   
                   $(form).find('.form-control').val('');
   
                   $(form_result_div).fadeIn('slow');
   
                   setTimeout(function () { $(form_result_div).fadeOut('slow') }, 6000);
               }
           });
       }
   });   
</script>
<script>
     var input = document.querySelector("#phone");
    window.intlTelInput(input, {
        separateDialCode: true,
        customPlaceholder: function (
            selectedCountryPlaceholder,
            selectedCountryData
        ) {
            return "e.g. " + selectedCountryPlaceholder;
        },
    });
  
    var iti = window.intlTelInputGlobals.getInstance(input);

    input.addEventListener('#phone', function() { 
      var countryName = iti.getSelectedCountryData().name;
      document.getElementById('country').value = countryName;
    });
</script>
<script>
   $(document).ready(function () {
     $("#shipform").hide();
       $('#shipadd').click(function () {
           $('#shipform').slideToggle(500);
       });
   });
   
   $(".checkbox-close").click(function(){
   $("#shipform").hide();
   });
   
   var searchToggle = $(".search-toggle");
   var searchWrap = $(".header-search-wrap");
   
   searchToggle.on("click", function () {
   if (!$(this).hasClass("active")) {
       $(this).addClass("active");
       searchWrap.addClass("active");
   } else {
       $(this).removeClass("active");
       searchWrap.removeClass("active");
   }
   });
   
   $("#search").click(function () {
   $(".search-form").animate({ right: 0 }, 50);
   $(".search-popup").show();
   $(".user-dropdown").hide();
   $(".search-bg").click(function () {
       $(".search-popup").hide();
       /*$('.search-form').animate({right: '-100%'}, 50);*/
   });
   });
   $(".close-icon").click(function () {
   $(".search-popup").hide();
   });

   $('#bologna-list a').on('click', function (e) {
    e.preventDefault()
    $(this).tab('show')
    })

/*
   $(".see-more").click(function () {
   $(".six-images").hide();
   });*/



</script>
<script>
   /* $(function() {
  // Owl Carousel
  var owl = $(".video-slider");
  owl.owlCarousel({
    items: 1,
    margin: 10,
    loop: true,
    nav: false,
  });
});*/

    var owl = $('.video-slider');
owl.owlCarousel({
    items:1, 
  // items change number for slider display on desktop  
  
    loop:false,
    margin:10,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
      infinite:true,
});


  var owl = $('.sponsored-slider');
owl.owlCarousel({
    items:3, 
    nav:true,
    
  // items change number for slider display on desktop  
  
    loop:false,


    margin:10,
    arrows: true,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
     nav: true,
    navText: [
        '<i class="fa fa-angle-left" aria-hidden="true"></i>',
        '<i class="fa fa-angle-right" aria-hidden="true"></i>'
    ],

      responsive: {
      0: {
        items: 1
      },
      767: {
        items: 2
      },
      1170: {
        items: 3
      }
    }
      
               
});





  var owl = $('.popular-suppliers');
owl.owlCarousel({
    items:3, 
    nav:true,
  // items change number for slider display on desktop  
    loop:false,
    margin:10,
    arrows: true,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
     nav: true,
    navText: [
        '<i class="fa fa-angle-left" aria-hidden="true"></i>',
        '<i class="fa fa-angle-right" aria-hidden="true"></i>'
    ],

      responsive: {
      0: {
        items: 1
      },
      768: {
        items: 1
      },
      1170: {
        items: 3
      }
    }
      
               
});


  var owl = $('.latest-suppliers');
owl.owlCarousel({
    items:3, 
    nav:true,
  // items change number for slider display on desktop  
    loop:false,
    margin:10,
    arrows: true,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
     nav: true,
    navText: [
        '<i class="fa fa-angle-left" aria-hidden="true"></i>',
        '<i class="fa fa-angle-right" aria-hidden="true"></i>'
    ],

      responsive: {
      0: {
        items: 1
      },
      768: {
        items: 1
      },
      1170: {
        items: 3
      }
    }
      
               
});

 var owl = $('.about-collection');    
owl.owlCarousel({
    items:3, 
    nav:true,
  // items change number for slider display on desktop  
    loop:true,
    margin:10,
    arrows: true,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
     nav: true,
    navText: [
        '<i class="fa fa-angle-left" aria-hidden="true"></i>',
        '<i class="fa fa-angle-right" aria-hidden="true"></i>'
    ],
      
        responsive: {
      0: {
        items: 1
      },
      768: {
        items: 1
      },
      1170: {
        items: 3
      }
    }
               
});


jQuery(document).ready(function($) {
"use strict";
//  TESTIMONIALS CAROUSEL HOOK
$('#customers-testimonials').owlCarousel({
    loop: true,
    items: 3,
    margin: 0,
    autoplay: true,
    dots:true,
    nav:true,
    autoplayTimeout: 8500,
    smartSpeed: 450,
  navText: ['<i class="fa fa-angle-left fa-5x"></i>','<i class="fa fa-angle-right fa-5x"></i>'],
  
    responsive: {
      0: {
        items: 1
      },
      768: {
        items: 1
      },
      1170: {
        items: 1
      }
    }
  });
});


$(document).ready(function () {
    $(".content").hide();
    $(".show_hide").on("click", function () {
        var txt = $(".content").is(':visible') ? 'Read More' : 'Read Less';
        $(".show_hide").text(txt);
        $(this).next('.content').slideToggle(200);
    });
});



    </script>

    <script>
      myID = document.getElementById("scroll-form");

var myScrollFunc = function () {
    var y = window.scrollY;
    if (y >= 1000) {
        myID.className = "bottomMenu show"
    } else {
        myID.className = "bottomMenu hide"
    }
};

window.addEventListener("scroll", myScrollFunc);
    </script>
    <script>
        $(".see-more").each(function() { 
    $(this).nextUntil(".see-less")
             .wrapAll("<div class='see-more-content'></div>");
});

$(".see-less").hide();
$(".see-more-content").slideUp(0);

$(".see-more").click(function() {
    var $more    = $(this),
      $content = $more.next(".see-more-content"),
      $less    = $content.next(".see-less");
  
  $content.slideToggle();
  $more.hide();
  $less.show();

});

$(".see-less").click(function() {
    var $less    = $(this),
      $content = $less.prev(".see-more-content"),
      $more    = $content.prev(".see-more");
  
  $content.slideToggle();
  $less.hide();
  $more.show();
});
    </script>
<!-- Appointment Form Ends -->
<?php if(isset($_GET['login'])&&$_GET['login']==1){ ?>
   <script>
      $(document).ready(function(){
         $("#loginModal").modal('show');
      });
   </script>
<?php } ?>
<?php if(isset($_GET['enquiry'])&&$_GET['enquiry']==1){ ?>
   <script>
      $(document).ready(function(){
         $(".get-quote").show();
      });
   </script>
<?php } ?>
<style type="text/css">

#google_translate_element select{

 

 background-color:#E78002 !important;

 color:#ffffff;

 border: none;

 border-radius:3px;

 padding:6px 8px;

 }

 .goog-te-gadget img{
    width: 37px;
 }
 
</style>

<script>
    (function () {
    "use strict";

    var cookieAlert = document.querySelector(".cookie-alert");
    var acceptCookies = document.querySelector(".accept-cookies");

    cookieAlert.offsetHeight; // Force browser to trigger reflow (https://stackoverflow.com/a/39451131)

    if (!getCookie("acceptCookies")) {
        cookieAlert.classList.add("show");
    }

    acceptCookies.addEventListener("click", function () {
        setCookie("acceptCookies", true, 60);
        cookieAlert.classList.remove("show");
    });
})();

// Cookie functions stolen from w3schools
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
    </script>
<!-- <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script type="text/javascript">
    function googleTranslateElementInit() {
        setCookie('googtrans', '/en/no/', 1);
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL, includedLanguages: 'en,no'
        }, 'google_translate_element');
    }
    function setCookie(key, value, expiry) {
        var expires = new Date();
        expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
        document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
    }
</script> -->
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script type="text/javascript">
    function googleTranslateElementInit() {
        setCookie('googtrans', '/en/no/', 1);
        new google.translate.TranslateElement({
            pageLanguage: 'no',
            layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL, includedLanguages: 'en'
        }, 'google_translate_element');
    }
    function setCookie(key, value, expiry) {
        var expires = new Date();
        expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
        document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
    }
</script>
<script>
        $(document).ready(function() {
            function reorderDivs() {
                if ($(window).width() <= 768) {
                    if ($('.rm2').prev('.rm1').length !== 1) {
                        $('.rm2').insertBefore('.rm1');
                    }
                } else {
                    if ($('.rm1').prev('.rm2').length !== 1) {
                        $('.rm1').insertBefore('.rm2');
                    }
                }
            }

            // Initial check
            reorderDivs();

            // Recheck on window resize
            $(window).resize(function() {
                reorderDivs();
            });
        });
    </script>
@yield('javascript')