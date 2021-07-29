$(document).ready(function () {

  function loadNewContent(attr, i) {       
    $.ajax({
        type:'POST',
        url: klypAjax.ajaxUrl,
        dataType : 'json',
        data: {
          action: 'klyp_get_comp_data',
          attr: attr,
          //nonce : nonce,
        },    
        success:function(data) {
          console.log(data);
        }
    });
  
  }

  $(window).scroll(function() {
      //check if your div is visible to user
      // CODE ONLY CHECKS VISIBILITY FROM TOP OF THE PAGE
      var count = $('#comp-count').val();

      for (var i = 0; i < count; i++) {
        if ($(window).scrollTop() + $(window).height() >= $('.component-container-' + i).offset().top) {
          if ($('.component-container-' + i).data('component')) {
            //not in ajax.success due to multiple sroll events
            // $('.component-container-' + i).attr('component', true);
            var attr = $('.component-container-' + i).data('component');
            //ajax goes here
            //in theory, this code still may be called several times
            loadNewContent(attr, i);
          }
        }
      }
  });

  //timeline hover on date
  $('.hb-timeline__item-date h4').hover(
    function () {
      $(this).parents('.hb-timeline__item-row').addClass('hb-timeline__item-row--hover');
    },
    function () {
      $(this).parents('.hb-timeline__item-row').removeClass('hb-timeline__item-row--hover');
    }
  );

  // Banner Slider JS
  $('.hb-slider__slide').owlCarousel({
    loop: true,
    margin: 0,
    dots: true,
    nav: false,
    items: 1
  });

  // Youtube Popup JS
  $('.hb-general__youtube-popup-video').magnificPopup({
    type: 'iframe',
    mainClass: 'mfp-fade',
    removalDelay: 160,
    preloader: false,
    fixedContentPos: false
  });

  // Add select2 to Dropdown
  $('.hb-map-select-store').select2({
    dropdownParent: '.hb-map__dropdown',
    width: '100%',
    minimumResultsForSearch: Infinity
  });

  //Gallery Popup JS
  $('.hb-gallery-popup__gallery-image-icon').magnificPopup({
    gallery: {
      enabled: true,
      duration: 300,
      tCounter: '%curr% of %total% images',
      easing: 'ease-in-out'
    },
    image: {
      titleSrc: function (item) {
        var markup = '';
        if (item.el[0].hasAttribute('data-title')) {
          markup += '<h3>' + item.el.attr('data-title') + '</h3>';
        }
        if (item.el[0].hasAttribute('data-caption')) {
          markup += '<p>' + item.el.attr('data-caption') + '</p>';
        }
        return markup
      }
    },
    callbacks: {
      buildControls: function () {
        // re-appends controls inside the main container
        this.contentContainer.append(this.arrowLeft.add(this.arrowRight));
      }
    },
    zoom: {
      enabled: true,
      duration: 300,
      easing: 'ease-in-out'
    },
    removalDelay: 300,
    mainClass: 'mfp-with-zoom hb-gallery-popup__main',
    type: 'image'
  });

  //Slider Arrows js
  let preArrow = $('.hb-slider-nav .hb-slider-nav__pre');
  let nextArrow = $('.hb-slider-nav .hb-slider-nav__next');
  preArrow.on('click', function () {
    $(this).closest('.hb-slider__slide').children('.owl-nav').children('.owl-prev').trigger('click');
  });
  nextArrow.on('click', function () {
    $(this).closest('.hb-slider__slide').children('.owl-nav').children('.owl-next').trigger('click');
  });

  //Search Widget js
  let searchBtn = $('.search-form .hb-form-search-icon');
  searchBtn.on('click', function () {
    $('.search-form').submit();
  });

  //Counter js
  $('.hb-counter__number').one('inview', function (event, isInView) {
    if (isInView) {
      // element is now visible in the viewport
      $(this).prop('Counter',0).animate({
        Counter: $(this).text()
      }, {
        duration: 4000,
        easing: 'swing',
        step: function (now) {
          $(this).text(Math.ceil(now));
        }
      });
      $(this).off('inview');
    }
  });

  //js to wrap blockquote and table
  $('.hb-general__txt-img-content blockquote').wrap('<div class="hb-general__blockquote-container position-relative"></div>');
  $('.hb-general__txt-img-content table').wrap('<div class="hb-general__table-responsive table-responsive-md"></div>');
});

// Modernizr.on('webp', function (result) {
//   if (result) {
//     $('body').addClass('hb-webp');
//   } else {
//     $('body').addClass('hb-no-webp');
//   }
// });
