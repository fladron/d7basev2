var locale = {
  CLOSE: {
    ca: "Tanca",
    es: "Cerrar",
    en: "Close"
  },
  COOKIES_MESSAGE: {
    ca: "El nostre portal web utilitza cookies amb la finalitat de millorar l'experiència de l'usuari. Al fer servir els nostres serveis acceptes l'ús que fem de les 'cookies'.",
    es: "Nuestro sitio web utiliza cookies con el fin de mejorar la experiencia del usuario. Al utilizar nuestros servicios aceptas el uso que hacemos de las 'cookies'.",
    en: "Our web site uses cookies to improve the user experience. Using our services you agree to the use of the 'cookies'."
  },
  COOKIES_MORE_INFO: {
  	ca: "Més informació",
    es: "Más información",
    en: "More information"
  },
  COOKIES_ACCEPT: {
  	ca: "Accepta política de cookies",
    es: "Aceptar política de cookies",
    en: "Accept cookies policy"
  },
  COOKIES_ACCEPT_SHORT: {
    ca: "Accepta",
    es: "Aceptar",
    en: "Accept"
  }
}
var config = {
  LANGUAGE: 'ca',
  THEME_URL: '/sites/all/themes/obt2/',
  WINDOW_MEASURES: [],
  SCROLL_THRESHOLD: 10, //miliseconds
  RESIZE_THRESHOLD: 10 //miliseconds
};

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - https://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
(function ($, Drupal, window, document, undefined) {

	// ON READY
	$(window).ready(function(){
		// this always on top
		config.LANGUAGE = $('html').attr('lang');
	  setWindowMeasures();
	  //-------------------

		// For all links with rel external, open link in new tab
	  $('body').on('click', 'a[rel="external"]', function(e){
	  	e.preventDefault();
	    window.open($(this).attr('href'));
	  });

	  // cookies
	  if (getCookie('cookie_message') != 'accepted'){
	    $('body').prepend('<div class="cookies-message"><p>'+locale.COOKIES_MESSAGE[config.LANGUAGE]+' <button data-action="close" title="'+locale.CLOSE[config.LANGUAGE]+'">X</button></p></div>');
	    setCookie('cookie_message', 'accepted', 90);
	    var $cookies_message = $('.cookies-message');
	    $cookies_message.on('click', 'button[data-action="close"]', function(e){
	      e.preventDefault();
	      $cookies_message.fadeOut(300);
	    });
	  }

	  // super labels
    prepareSuperLabels();

    // overlay (fancybox)
	  //$('.voluntaris-gallery > ul > li a').attr('rel', 'gallery').fancybox();

	  // main menu
	  var $main_menu = $('#block-system-main-menu');
	  if ($main_menu.length){
	   	// responsive menu
		  $('#page').before('<div class="mobile-menu"><button data-action="open-mobile-menu">Menu</button></div>');
		  var $mobile_menu = $('.mobile-menu');
		  $mobile_menu.append($main_menu.find('> .content').html());
		  $('button[data-action="open-mobile-menu"]').click(function(e){
		    $mobile_menu.toggleClass('opened');
		  });
	  }

	  // Carousels
    /*$('article.node-building .media .slider-images > ul').owlCarousel({
      navigation: true,
      navigationText: false,
      pagination: false,
      slideSpeed: 300,
      paginationSpeed: 400,
      itemsCustom: [[0,1]]
    });*/

    // basic carroussel (no Owl)
		/*var carroussel = new BasicCarroussel(
			{
				selector: '.some-selector',
				auto_play: true,
				change_slide_time: 4000
			}
		);*/

    // tabs
	  /*var most_tabs = new GrouppedTabs(
			{
		    selector: '.some-selector',
		  	block_name: id-name-for-the-block'
		  }
		);*/
	});

	// ON LOAD
	$(window).load(function(){
		
	});

	// ON RESIZE
	//$(window).resize(debounce(onWindowResize, config.RESIZE_THRESHOLD)); // for all events that trigger continuosly, we debounce the functions called, for a better performance

	/*function onWindowResize(e) {
		
	}*/

	// This is done exclusively for the people who loves to see if the site is responsive :P
	/*function onWindowResize(e){
	  // this first
	  setWindowMeasures();
	  // and then the rest to respond to these measures:
	  
	}*/

	function setWindowMeasures(){
	  config.WINDOW_MEASURES = [window.innerWidth, window.innerHeight];
	}

	function prepareSuperLabels(){
    $('form').not('#search-block-form, .search-form').superLabels({
      labelLeft: 12,
      labelTop: 10
    });
  }

})(jQuery, Drupal, this, this.document);
