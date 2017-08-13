/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'jquery',
    'underscore',
    'mageUtils',
    'uiClass',
    "Emthemes_MegaMenu/bootstrap/js/jquery.htmlClean",
], function ($, _, utils, Class) {
    'use strict';

    /**
     * Before save validate request.
     *
     * @param {Object} data
     * @param {String} url
     * @param {String} selectorPrefix
     * @param {String} messagesClass
     * @returns {*}
     */
    function beforeSave(data, url, selectorPrefix, messagesClass) {
        var save = $.Deferred();

        data = utils.serialize(data);

        data['form_key'] = window.FORM_KEY;

        if (!url || url === 'undefined') {
            return save.resolve();
        }

        $('body').trigger('processStart');

        $.ajax({
            url: url,
            data: data,

            /**
             * Success callback.
             * @param {Object} resp
             * @returns {Boolean}
             */
            success: function (resp) {
                if (!resp.error) {
                    save.resolve();

                    return true;
                }

                $('body').notification('clear');
                $.each(resp.messages || [resp.message] || [], function (key, message) {
                    $('body').notification('add', {
                        error: resp.error,
                        message: message,

                        /**
                         * Insert method.
                         *
                         * @param {String} msg
                         */
                        insertMethod: function (msg) {
                            var $wrapper = $('<div/>').addClass(messagesClass).html(msg);

                            $('.page-main-actions', selectorPrefix).after($wrapper);
                        }
                    });
                });
            },

            /**
             * Complete callback.
             */
            complete: function () {
                $('body').trigger('processStop');
            }
        });

        return save.promise();
    }

    return Class.extend({
        createMenu: function(obj){
            var nav = $('<nav>', {
                class: 'navigation',
                'data-action': 'navigation'
            });
            var ul = $('<ul>',{
                'data-mage-init': '{"menu":{"responsive":true, "expanded":true, "position":{"my":"left top","at":"left bottom"}}}'
            });
            obj.find('.nav-tabs > li > a').each(function(){
                var title = $(this).text();
                var contentId = $(this).attr('href');
                console.log($(contentId).html());
                //adad;
                if(contentId != '#'){
                    var width = $(this).attr('dwidth');
                    var link = $(this).attr('dlink');
                    var custom_class = $(this).attr('dcustom_class');
                    var html = '<li  class="level0 nav-1 first level-top submenu '+custom_class+'">';
                    html += '<a href="'+link+'" class="level-top ui-corner-all"><span>'+title+'</span></a>';
                    if($.trim($(contentId).html())!=="") {
                        console.log($(contentId).html());
                        html += '<ul class="dropmenu-template level0 submenu"><li class="dropmenu-content '+ width + '">';
                        html += $(contentId).html();
                        html += '</li></ul>';
                    }
                    ul.append(html);
                }
            });
            nav.append(ul);
            return ul.html();
        },

        downloadLayoutSrc: function(tab) {
            var e = "";
            var t = document.createElement('div');
            //t = $(t);
            //t.html(tab.innerHTML);
            t = $(tab);
            t.find(".preview, .configuration, .drag, .remove").remove();
            t.find(".lyrow").addClass("removeClean");
            t.find(".box-element").addClass("removeClean");
            t.find(".lyrow .lyrow .lyrow .lyrow .lyrow .removeClean").each(function() {
                $(this).parent().append($(this).children().html())
            });
            t.find(".lyrow .lyrow .lyrow .lyrow .removeClean").each(function() {
                $(this).parent().append($(this).children().html())
            });
            t.find(".lyrow .lyrow .lyrow .removeClean").each(function() {
                $(this).parent().append($(this).children().html())
            });
            t.find(".lyrow .lyrow .removeClean").each(function() {
                $(this).parent().append($(this).children().html())
            });
            t.find(".lyrow .removeClean").each(function() {
                $(this).parent().append($(this).children().html())
            });
            t.find(".removeClean").each(function() {
                $(this).parent().append($(this).children().html())
            });
            t.find(".removeClean").remove();
            t.find(".column").removeClass("ui-sortable");
            t.find(".row-fluid").removeClass("clearfix").children().removeClass("column");

            var formatSrc = $.htmlClean(this.createMenu(t), {
                format: true,
                allowedAttributes: [
                    ["id"],
                    ["class"],
                    ["data-toggle"],
                    ["data-target"],
                    ["data-parent"],
                    ["role"],
                    ["data-dismiss"],
                    ["aria-labelledby"],
                    ["aria-hidden"],
                    ["data-slide-to"],
                    ["data-slide"],
                    ["style"]
                ]
            });
            return formatSrc;
        },
        /**
         * Assembles data and submits it using 'utils.submit' method
         */
        save: function (data, options) {
            //====
            var params = [];
            var tabs = document.getElementById('tabs');
            data.content = tabs.innerHTML;
            data.frontend = this.downloadLayoutSrc(tabs);
            //====
        
            var url = this.urls.beforeSave,
                save = this._save.bind(this, data, options);

            beforeSave(data, url, this.selectorPrefix, this.messagesClass).then(save);

            return this;
        },

        /**
         * Save data.
         *
         * @param {Object} data
         * @param {Object} options
         * @returns {Object}
         * @private
         */
        _save: function (data, options) {
            var url = this.urls.save;

            options = options || {};

            if (!options.redirect) {
                url += 'back/edit';
            }

            if (options.ajaxSave) {
                utils.ajaxSubmit({
                    url: url,
                    data: data
                }, options);

                return this;
            }

            utils.submit({
                url: url,
                data: data
            }, options.attributes);

            return this;
        }
    });
});
