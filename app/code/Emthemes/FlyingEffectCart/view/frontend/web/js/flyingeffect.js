(function (factory) {
    if (typeof define === "function" && define.amd) {
        define([
            "jquery",
            "jquery/ui"
        ], factory);
    } else {
        factory(jQuery);
    }
}(function ($) {
    "use strict";
    console.log('flyingeffect.js is loaded!!');
        $.widget('flyingeffect.js', {
			options: {
				speed: 100,
				origin: '.origin'
			},
            _create: function() {
				var self = this;
				self._toggleflying(self.options);
            },
			_toggleflying: function(config){
				window.clickPhoto = function(e){
						if($(e).parent().hasClass('flyingcart-show-tooltip')){
							$(e).parent().removeClass('flyingcart-show-tooltip');
						}else{
							$('.product-item').removeClass('flyingcart-show-tooltip');
							$(e).parent().addClass('flyingcart-show-tooltip');
						}	
				};
				$('body, html').click(function(e){
					if($(e.target).parents('.flyingcart-show-tooltip').length == 0){
						$('.product-item').removeClass('flyingcart-show-tooltip');
					}
				});
				$(config.origin).click( function(e){
					if(!$(e.target).hasClass('flyingcart-close-dialog')){
						if($(config.origin).is('.flyingcart-hidden')){
							$(config.origin).removeClass('flyingcart-hidden');
							$(config.origin).addClass('flyingcart-show');
							$('.flyingcart-co').removeClass('flyingcart-close');
							$('.flyingcart-co').addClass('flyingcart-open');
						}
					}
					if($(e.target).hasClass('flyingcart-close-dialog')){
						if($(config.origin).is('.flyingcart-show')){
							$(config.origin).removeClass('flyingcart-show');
							$(config.origin).addClass('flyingcart-hidden');
							$('.flyingcart-co').removeClass('flyingcart-open');
							$('.flyingcart-co').addClass('flyingcart-close');
						}
					}
					if($(e.target).hasClass('flyingcart-toggle')){
							if($('.flyingcart-toggle').is('.flyingcart-detail-show')){
								$('.flyingcart-toggle').removeClass('flyingcart-detail-show');
								$('.flyingcart-details').css('display','block');
								
							}else{
								
								$('.flyingcart-toggle').addClass('flyingcart-detail-show');
								$('.flyingcart-details').css('display','none');
							}
					}
                });
			}
        });
    return $.flyingeffect.js;
}));