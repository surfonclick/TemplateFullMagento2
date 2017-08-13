/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    "jquery",
    'Magento_Ui/js/form/element/abstract',
    "ko",
    "jquery/ui",
    //"Emthemes_MegaMenu/bootstrap/js/jquery-2.0.0.min.js",
    "Emthemes_MegaMenu/bootstrap/js/bootstrap",
    "Emthemes_MegaMenu/bootstrap/js/jquery.ui.touch-punch.min",
    "Emthemes_MegaMenu/bootstrap/js/jquery.htmlClean",
    "Emthemes_MegaMenu/bootstrap/js/scripts"
], function ($, Abstract, ko) {
    'use strict';
    return Abstract.extend({

        initialize: function () {
            this.content = this._super().value();
            window.current_table = null;
            window.countEditor = 0;
            return this._super();
        },

        afterRender: function(){
            var parent = this;
            window.tabCount = $('#tabs > ul.nav-tabs > li').length-1;
            window.currentEditTab;
            window.control = ' <i class="icon-edit open-content" data-toggle="modal" data-target="#myModal"></i><i class="icon-remove"></i>';
            window.currentDocument = null;
            window.timerSave = 1000;
            window.stopsave = 0;
            window.startdrag = 0;
            window.demoHtml = $(".demo").html();
            window.currenteditor = null;
            window.layouthistory; 


            $(window).resize(function() {
                $("body").css("min-height", $(window).height() - 90);
                $(".demo").css("min-height", $(window).height() - 160)
            });
            var data_href_li_check_active=null;
            $("#tabs > ul.nav-tabs > li > a").live("click",function(event){
                if($(event).parent().hasClass("active")){
                    alert("demo123");
                }else{
                  data_href_li_check_active=$(this).attr("href");
                  $("#myModal input[name='check_tab']").val(data_href_li_check_active);
                  $("#myModal select[name='width']").val($(this).attr("dwidth"))
                  $("#myModal input[name='title']").val($(this).text());
                  $("#myModal input[name='link']").val($(this).attr("dlink"));
                  
                  $("#myModal input[name='custom_class']").val($(this).attr("dcustom_class"));
                  parent.initDragDrop(data_href_li_check_active);
                }

            });
            $("#tabs > ul.nav-tabs > li ").each(function(i, items_list){
                if($(items_list).hasClass("active")){
                    var data_id=$(items_list).children("a").attr("href");
                    parent.initDragDrop(data_id);
                }
            });

            //init click modal
            $('#tabs > .nav-tabs > li .icon-edit').each(function(){
                ko.applyBindingsToNode($(this),{
                    click: parent.clickEditTab
                });
            });

            $('.tab-content .view .column .icon-edit').each(function(){
                ko.applyBindingsToNode($(this),{
                    click: parent.clickEditColumn
                });
            });    

            $('#tabs > .nav-tabs > li .icon-remove').each(function(){
                ko.applyBindingsToNode($(this),{
                    click: parent.removeTab
                });
            });
            
            
            
            //init editor;
            $('.box-element').each(function(i,e){
                countEditor++;
                var btn = $(this).find('.btn-edit').first();
                var edit = $(this).find('.view').first();
                edit.attr('id','edit'+countEditor);
                var editor = Object.create(catalogWysiwygEditor);
                btn.click(function(){
                    editor.open(url,edit.attr('id'));
                });
            });
        },
        addTab: function(form){
            var parent = this;
            tabCount++;
            var random=Math.random().toString(36).substring(5);
            var title = form.elements.title.value;
            var link = form.elements.link.value;
            var width = form.elements.width.value;
            var custom_class = form.elements.custom_class.value;
            $('#addTabButton').before('<li><a data-toggle="tab" href="#tab' + tabCount +"_"+random+'" dlink="'+link+'" dwidth="'+width+'" dcustom_class="'+custom_class+'">' + title + control + '</a></li>');

            $('#tabs > .tab-content').first().append('<div id="tab' + tabCount +"_"+random+'" class="demo ui-sortable tab-pane"></div>');
            var tabid="#tab"+tabCount+"_"+random;
            this.initDragDrop(tabid);
            ko.applyBindingsToNode($('#tabs > .nav-tabs > li .icon-edit').last(),{
                click: parent.clickEditTab
            });
            ko.applyBindingsToNode($('#tabs > .nav-tabs > li .icon-remove').last(),{
                click: parent.removeTab
            });
            $('#addTabModal').modal('hide');
            return false;
        },

        removeTab: function(ui, e){
            if(confirm("Do you want to delete ?")){
                var anchor = $(e.target).closest('a');
                var tabId = anchor.attr('href');
                $(e.target).closest('li').remove();
                $(tabId).remove();
            }
        },

        clickEditTab: function(ui,e){
            var anchor = $(e.target).closest('a');
            var form = document.getElementById('editTabForm');
            window.currentEditTab = anchor;
            form.elements.title.value = anchor.text();
            form.elements.link.value = anchor.attr('dlink')?anchor.attr('dlink'):'';
            form.elements.width.value = anchor.attr('dwidth')?anchor.attr('dwidth'):'';
            form.elements.custom_class.value = anchor.attr('dcustom_class')?anchor.attr('dcustom_class'):'';
        },

        saveEditTab: function(ui, e){
            var form = document.getElementById('editTabForm');
            var check_href=form.elements.check_tab.value;
            var title = form.elements.title.value;
            var link = form.elements.link.value;
            var width = form.elements.width.value;
            var custom_class = form.elements.custom_class.value;
            if(window.currentEditTab.attr('href')===check_href){
                window.currentEditTab.attr('dlink',link);
                window.currentEditTab.attr('dwidth',width);
                window.currentEditTab.attr('dcustom_class',custom_class);
                window.currentEditTab.html(title + control);
            }
            return false;
        },

        editColumn: function(ui,e){
            alert("1234");
        },
        saveEditColumn: function(ui, e){
            var form = document.getElementById('editColumn');
            var custom_class = form.elements.custom_class_column.value;
            window.currentEditTab.attr('dcustom_class',custom_class);
            return false;
        },
        supportstorage: function() {
            if (typeof window.localStorage=='object') 
                return true;
            else
                return false;       
        },

        downloadLayout: function(){
    
            $.ajax({  
                type: "POST",  
                url: "/build/downloadLayout",  
                data: { layout: $('#download-layout').html() },  
                success: function(data) { window.location.href = '/build/download'; }
            });
        },

        downloadHtmlLayout: function(){
            $.ajax({  
                type: "POST",  
                url: "/build/downloadLayout",  
                data: { layout: $('#download-layout').html() },  
                success: function(data) { window.location.href = '/build/downloadHtml'; }
            });
        },

        handleWysiwyg: function(obj){
            //init editor;
            countEditor++;
            var btn = obj.find('.btn-edit').first();
            var edit = obj.find('.view').first();
            edit.attr('id','edit'+countEditor);
            var editor = Object.create(catalogWysiwygEditor);
            btn.click(function(){
                editor.open(url,edit.attr('id'));
            });
        },
        randomNumber: function() {
            return this.randomFromInterval(1, 1e6)
        },
        randomFromInterval: function(e, t) {
            return Math.floor(Math.random() * (t - e + 1) + e)
        },
        gridSystemGenerator: function() {
            $(".lyrow .preview input").bind("keyup", function() {
                var e = 0;
                var t = "";
                var n = $(this).val().split(" ", 12);
                $.each(n, function(n, r) {
                    e = e + parseInt(r);
                    t += '<div class="span' + r + ' column"></div>'
                });
                if (e == 12) {
                    $(this).parent().next().children().html(t);
                    $(this).parent().prev().show()
                } else {
                    $(this).parent().prev().hide()
                }
            })
        },
        configurationElm: function(e, t) {
            $(".demo").delegate(".configuration > a", "click", function(e) {
                e.preventDefault();
                var t = $(this).parent().next().next().children();
                $(this).toggleClass("active");
                t.toggleClass($(this).attr("rel"))
            });
            $(".demo").delegate(".configuration .dropdown-menu a", "click", function(e) {
                e.preventDefault();
                var t = $(this).parent().parent();
                var n = t.parent().parent().next().next().children();
                t.find("li").removeClass("active");
                $(this).parent().addClass("active");
                var r = "";
                t.find("a").each(function() {
                    r += $(this).attr("rel") + " "
                });
                t.parent().removeClass("open");
                n.removeClass(r);
                n.addClass($(this).attr("rel"))
            })
        },
        removeElm: function() {
            var parent = this;
            $(".demo").delegate(".remove", "click", function(e) {
                e.preventDefault();
                $(this).parent().remove();
            })
        },
        removeMenuClasses: function() {
            $("#menu-layoutit li button").removeClass("active")
        },
        changeStructure: function(e, t) {
            $("#download-layout ." + e).removeClass(e).addClass(t)
        },

        restoreData: function(){
            if (supportstorage()) {
                layouthistory = JSON.parse(localStorage.getItem("layoutdata"));
                if (!layouthistory) return false;
                window.demoHtml = layouthistory.list[layouthistory.count-1];
                if (window.demoHtml) $(".demo").html(window.demoHtml);
            }
        },

        initContainer: function(){
            var parent = this;
            $(".demo, .demo .column").sortable({
                connectWith: ".column",
                opacity: .35,
                handle: ".drag",
                receive: function (ev, ui) {
                    var $target = $(this).data().sortable.currentItem;
                    if($target){
                        if($($target.context).hasClass('box-element')){
                            parent.handleWysiwyg($($target.context));
                        }
                    }
                } 
            });
            this.configurationElm();
        },
        initDragDrop: function(url_link){
            var parent = this;
            $(".demo").css("min-height", $(window).height() - 160);
            $(".sidebar-nav .lyrow").draggable({
                snap:  url_link,
                connectToSortable: url_link,
                helper: "clone",
                handle: ".drag",
                start: function(e,t) {
                    if (!startdrag) stopsave++;
                    startdrag = 1;
                },
                drag: function(e, t) {
                    t.helper.width(400)
                },
                stop: function(e, t) {
                    $(".demo .column").sortable({
                        opacity: .35,
                        connectWith: ".column",
                        start: function(e,t) {
                            if (!startdrag) stopsave++;
                            startdrag = 1;
                        },
                        stop: function(e,t) {
                            if(stopsave>0) stopsave--;
                            startdrag = 0;
                        }
                    });
                    if(stopsave>0) stopsave--;
                    startdrag = 0;
                }                
            });
            $(".sidebar-nav .box").draggable({
                connectToSortable: ".column",
                helper: "clone",
                handle: ".drag",
                start: function(e,t) {
                    if (!startdrag) stopsave++;
                    startdrag = 1;
                },
                drag: function(e, t) {
                    t.helper.width(400)
                }
            });
            this.initContainer();
            $('.edit .demo').on("click",".open-content",function(e) {
                e.preventDefault();
                currenteditor = $(this).parent().parent().find('.view');
                var eText = currenteditor.html();
                //contenthandle.setData(eText);
            });
            $("#savecontent").click(function(e) {
                e.preventDefault();
                currenteditor.html(contenthandle.getData());
            });

            $("#download").click(function() {
                downloadLayout();
                return false
            });
            $("#downloadhtml").click(function() {
                downloadHtmlLayout();
                return false
            });
            
            $(".nav-header").click(function() {
                $(".sidebar-nav .boxes, .sidebar-nav .rows").hide();
                $(this).next().slideDown()
            });
            
            this.removeElm();
            this.gridSystemGenerator();
        }
    });
});
