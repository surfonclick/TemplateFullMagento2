/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'jquery',
    'ko',
    'Emthemes_FlyingEffectCart/js/sidebar'
], function (Component, customerData, $, ko, emsidebar) {
    'use strict';

    var sidebarInitialized = false;
    var addToCartCalls = 0;

    var minicart = $("[data-block='emminicart']");
	
	
    function initSidebar() {
		
        if (minicart.data('mageSidebar')) {
            minicart.emsidebar('update');
        }
		
        minicart.trigger('contentUpdated');
        if (sidebarInitialized) {
            return false;
        }
        sidebarInitialized = true;
		
        minicart.emsidebar({
            "targetElement": "#custom-minicart-content-wrapper",
            "url": {
                "checkout": window.checkout.checkoutUrl,
                "update": window.checkout.updateItemQtyUrl,
                "remove": window.checkout.removeItemUrl,
                "loginUrl": window.checkout.customerLoginUrl,
                "isRedirectRequired": window.checkout.isRedirectRequired
            },
            "button": {
				"checkout": ".checkout",
                "remove": "#custom-mini-cart a.action.delete",
                "close": "#btn-minicart-close"
            },
            "showcart": {
                "parent": "span.counter",
                "qty": "span.counter-number",
                "label": "span.counter-label"
            },
            "minicart": {
                "list": "#custom-mini-cart",
                "content": "#custom-minicart-content-wrapper",
                "qty": "div.items-total",
                "subtotal": "div.subtotal span.price"
            },
            "item": {
                "qty": ":input.cart-item-qty",
                "button": ":button.update-cart-item"
            },
            "confirmMessage": $.mage.__(
                'Are you sure you would like to remove this item from the shopping cart?'
            )
        });
		

    }

    return Component.extend({
        shoppingCartUrl: window.checkout.shoppingCartUrl,
        initialize: function () {
            var self = this;
            this._super();
            this.cart = customerData.get('cart');
			initSidebar();
            this.cart.subscribe(function () {
                addToCartCalls--;
                this.isLoading(addToCartCalls > 0);
                sidebarInitialized = false;
                initSidebar();
            }, this);
            $('[data-block="emminicart"]').on('contentLoading', function(event) {
                addToCartCalls++;
                self.isLoading(true);
            });
        },
        isLoading: ko.observable(false),
        initSidebar: initSidebar,
        closeSidebar: function() {
            var minicart = $('[data-block="emminicart"]');
            minicart.on('click', '[data-action="close"]', function(event) {
                event.stopPropagation();
                minicart.find('[data-role="dropdownDialog"]').dropdownDialog("close");
            });
            return true;
        },
        getItemRenderer: function (productType) {
            return this.itemRenderer[productType] || 'defaultRenderer';
        }
    });
});
