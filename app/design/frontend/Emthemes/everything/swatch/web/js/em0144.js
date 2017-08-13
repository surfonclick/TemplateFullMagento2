/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'jquery',
    'mage/smart-keyboard-handler',
    'mage/mage',
    'mage/ie-class-fixer',
    'mage/translate',
    'fullPage',
    'domReady!'
], function ($, keyboardHandler) {
    'use strict';

      /* sticky menu */
      if(EM.SETTING.STICKY_MENU == 1 && isMobile == 'false')
      {
             var $_e = $('.header.content');
              if ($_e.length) {            
                      var sticky_navigation = function() {
                          var wWindow = $(window).width();
                          var scroll_top = $(window).scrollTop();
                          var navpos = $('#header-position').offset().top;
                          if (wWindow > 767) {
                              if (scroll_top > navpos) {
                                  if (!$_e.hasClass('navbar-fixed-top')) {
                                      $_e.addClass('navbar-fixed-top');
                                  }
                              } else {
                                  if ($_e.hasClass('navbar-fixed-top')) { 
                                      $_e.removeClass('navbar-fixed-top');
                                    if($('.mobile-search-icon').hasClass('active'))
                                      $('.mobile-search-icon').click();

                                  }
                              }
                          } else {
                              if ($_e.hasClass('navbar-fixed-top')) {   
                                  $_e.removeClass('navbar-fixed-top');
                              }
                                  if($('.mobile-search-icon').hasClass('active'))
                                      $('.mobile-search-icon').click();

                          }
                      };
                      $(window).scroll(function() {
                          sticky_navigation();
                      });
                      sticky_navigation();
                            
              }
      }      

      /* ajaxcart */
      $('div.block-minicart').bind('contentUpdated',function(event){
                
            event.preventDefault();
            $('a.showcart').click();            
            $(this).parent().show();            
          /*  setTimeout(function(){
			if($('body').hasClass('cms-index-index')){
				if($('.page.messages div.messages').length){
					var $message = $('.page.messages div.messages').children().first();
					$('.page.messages div.messages').hide();
						$message.alert({
							wrapperClass: 'modals-wrapper popup-page-messages',			
							closeText: ""
		          			});
				}			
			}
            },1000);*/
            setTimeout(function() {                              
                  $('#btn-minicart-close').click();
                  $('div.minicart-wrapper').removeClass('show-cart');
                  $('div.block-minicart').parent().hide();
                  return;
            }, 5000); 
      });  
	
	/* retina images */
       if (window.devicePixelRatio > 1 ||
             (window.matchMedia && window.matchMedia("(-webkit-min-device-pixel-ratio: 1.5),(-moz-min-device-pixel-ratio: 1.5),(min-device-pixel-ratio: 1.5)").matches)) 
       {
	        var images = $('img.retina-img');
              var len = images.length;
              if(len){
                    /* loop through the images and make them hi-res */
		        for(var i = 0; i < len; i++) {    
			      /* create new image name */
			      var imageType = images[i].src.substr(-4);
			      var imageName = images[i].src.substr(0, images[i].src.length - 4);
			      imageName += "@2x" + imageType;

			      /* rename image */
			      images[i].src = imageName;
		        }
              }
       };
       if($('body').hasClass('cms-index-index')){
           var $_fullpage = $('#em_fullpage');
		$_fullpage.fullpage({
                navigation: true,	
                navigationPosition: 'right',
                slideSelector: '#em_fullpage .section',
                responsiveWidth: 1200, 
                 css3: true,
		  scrollingSpeed: 500,
		  autoScrolling: true,
		  fitToSection: true,
		  fitToSectionDelay: 1000,
		  easing: 'easeInOutCubic',
		  easingcss3: 'ease',
			});
		var message = $('.page.messages').detach();
		$('.em-header-top').prepend(message);
			
       }
});

