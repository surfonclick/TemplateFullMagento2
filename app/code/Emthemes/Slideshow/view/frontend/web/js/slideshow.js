/*! 
 * Slideshow – Responsive Touch Swipe Slider
 * Copyright © 2015 All Rights Reserved. 
 *
 * @author Stephen Nguyen
 * @version 1.0.0
 * @date Dec 2015
 */
(function (factory) {
    if (typeof define === "function" && define.amd) {
        define([
            "jquery",
			"easingmin",
            "Emthemes_Slideshow/js/masterslider.min"
        ], factory);
    } else {
        factory(jQuery);
    }
}(function ($) {
	"new lib";
	$.widget('custom.EmthemesSlideshow', {
		options: {
			idlideshow: 'masterslider',
			width: 0,
			height: 0,
			view: 'fade',
			loop: false,
			autoplay: false,
			layout: 'boxed',
			space: 5,
			rtl: 0
			
		},		
		_create: function(){
			 this._buildSlideShow(this.options);
		},
		_buildSlideShow: function(config){
			var slider = new MasterSlider();
			if ($("body").hasClass("em-rtl")) {
				config.rtl = 1;
			}else{
				config.rtl = 0;
			}
			if((config.width!=0)&&(config.height!=0))
			{

				 slider.control('arrows');
				 slider.control('bullets');  				 
				 slider.setup(config.idlideshow, {
				 width:config.width,   // slider standard width
				 height:config.height,   // slider standard height
				 view:config.view,
				 loop:config.loop,
				 autoplay: config.autoplay,
				 layout: config.layout,
				 space: config.space,
				 rtl: config.rtl
				});				
			}
			else
			{
				// alert("ko co width va height");
				 slider.control('arrows' ,{insertTo:'#'+config.idlideshow});	
				slider.control('bullets');  				 
				 slider.setup(config.idlideshow, {
				 width:1024,   // slider standard width
				 height:500,
				 view:config.view,
				 loop:config.loop,
				 autoplay: config.autoplay,
				 layout: config.layout,
				 space: config.space,
				 fullscreenMargin:57,				 
				 autoHeight: true,
				 autoWidth: true,
				 rtl: config.rtl
				});					 
			}
		}
	});	
	
	return $.custom.EmthemesSlideshow;
}));