/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'jquery',
    'mage/translate',
	'Magento_Ui/js/modal/alert',
	'Emthemes_FlyingEffectCart/js/flyingeffect',
    'jquery/ui'
], function($, $t, alert) {
    "use strict";
	console.log('catalog-add-to-cart.js is loaded!!');
    $.widget('mage.catalogAddToCart', {

        options: {
            processStart: null,
            processStop: null,
            bindSubmit: true,
            emminicartSelector: '[data-block="emminicart"]',
			minicartSelector: '[data-block="minicart"]',
            messagesSelector: '[data-placeholder="messages"]',
            productStatusSelector: '.stock.available',
            addToCartButtonSelector: '.action.tocart',
            addToCartButtonDisabledClass: 'disabled',
            addToCartButtonTextWhileAdding: $t('Adding...'),
            addToCartButtonTextAdded: $t('Added'),
            addToCartButtonTextDefault: $t('Add to Cart'),
			flyingStatus: $flyingcartValue.flyingstatus,
			effect: $flyingcartValue.effect,
			effectTime: $flyingcartValue.effecttime,
			flyingOr: $flyingcartValue.flyingor
        },

        _create: function() {
            if (this.options.bindSubmit) {
                this._bindSubmit();
            }
        },

        _bindSubmit: function() {
            var self = this;
            this.element.on('submit', function(e) {
                e.preventDefault();
                self.submitForm($(this));
            });
        },

        isLoaderEnabled: function() {
            return this.options.processStart && this.options.processStop;
        },

        submitForm: function(form) {
            var self = this;
            if (form.has('input[type="file"]').length && form.find('input[type="file"]').val() !== '') {
                self.element.off('submit');
                form.submit();
            } else {
                self.ajaxSubmit(form);
            }
        },

        ajaxSubmit: function(form) {
            var self = this;
			$(self.options.emminicartSelector).trigger('contentLoading');
            $(self.options.minicartSelector).trigger('contentLoading');
            self.disableAddToCartButton(form);

            $.ajax({
                url: form.attr('action'),
                data: form.serialize(),
                type: 'post',
                dataType: 'json',
                beforeSend: function() {
                    if (self.isLoaderEnabled()) {
                        $('body').trigger(self.options.processStart);
                    }
                },
                success: function(res) {
                    if (self.isLoaderEnabled()) {
                        $('body').trigger(self.options.processStop);
                    }

                    if (res.backUrl) {
                        window.location = res.backUrl;
                        return;
                    }
                    if (res.messages) {
                        $(self.options.messagesSelector).html(res.messages);
                    }
                    if (res.minicart) {
						$(self.options.emminicartSelector).replaceWith(res.minicart);
                        $(self.options.emminicartSelector).trigger('contentUpdated');
                        $(self.options.minicartSelector).replaceWith(res.minicart);
                        $(self.options.minicartSelector).trigger('contentUpdated');
                    }
                    if (res.product && res.product.statusText) {
                        $(self.options.productStatusSelector)
                            .removeClass('available')
                            .addClass('unavailable')
                            .find('span')
                            .html(res.product.statusText);
                    }
					if(($( window ).width()<768)&&($('.flyingcart-minicart-wrapper').is('.flyingcart-hidden-xs'))){
						self.enableAddToCartButton(form);
					}else{
						if(self.options.flyingStatus==1){
							var itemImg = $(form).parents(".product-item").first().find('img').eq(0);
							if(itemImg.length==0) itemImg = $(form).parents(".main, .quickshop-modal").first().find('.fotorama__stage').find('img').eq(0);
							self.flyToElement(itemImg,self.options);
						}
						self.enableAddToCartButton(form);
					}
                },
            });
        },

			disableAddToCartButton: function(form) {
            var addToCartButton = $(form).find(this.options.addToCartButtonSelector);
            addToCartButton.addClass(this.options.addToCartButtonDisabledClass);
            addToCartButton.attr('title', this.options.addToCartButtonTextWhileAdding);
            addToCartButton.find('span').text(this.options.addToCartButtonTextWhileAdding);
        },

        enableAddToCartButton: function(form) {
            var self = this,
            addToCartButton = $(form).find(this.options.addToCartButtonSelector);

            addToCartButton.find('span').text(this.options.addToCartButtonTextAdded);
            addToCartButton.attr('title', this.options.addToCartButtonTextAdded);

            setTimeout(function() {
                addToCartButton.removeClass(self.options.addToCartButtonDisabledClass);
                addToCartButton.find('span').text(self.options.addToCartButtonTextDefault);
                addToCartButton.attr('title', self.options.addToCartButtonTextDefault);
            }, 1000);
        },
		flyToElement: function(flyer,conf) {
			var divider = 3;
			var flyerClone = $('<img class="fly-img" />'); //$(flyer).clone();
			flyerClone.appendTo('body');
			var src = flyer.attr('src');
			flyerClone.attr('src',src);
			var oldTop = flyer.offset().top;
			var oldLeft = flyer.offset().left;		
			$(flyerClone).css({position: 'absolute', opacity: 1,top: oldTop,left: oldLeft, 'z-index': 9999});
			var $cart = $('#cart-target');
			var newLeft = $cart.offset().left;
			var newTop = $cart.offset().top;
			if(conf.effect==1)
			//fade
			$(flyerClone).animate({
            opacity: 0.5,
            width: $(flyer).width()/divider,
            height: $(flyer).height()/divider
			});
			if(conf.effect==2)
			//shake
			$(flyerClone).effect("shake");
			//normal
			$(flyerClone).animate({
				opacity: 0.4,
				top: newTop,
				left: newLeft,
				width: $(flyer).width()/divider,
				height: $(flyer).height()/divider
			}, conf.effectTime,
			function () {
						$(flyerClone).fadeOut('fast', function () {
							$(flyerClone).remove();
						});
			});	
			if($(conf.flyingOr).is('.flyingcart-hidden')){
				window.setTimeout(function(){
					$(conf.flyingOr).removeClass('flyingcart-hidden');
					$(conf.flyingOr).addClass('flyingcart-show');
				}, conf.effectTime-500);		
			};
		}
    });
    return $.mage.catalogAddToCart;
});