Magento version 2.1.3
----------------------Feb/7/2017-----------------------
fix ajax review on EM_Quickshop


Magento version 2.1.3
----------------------Feb/15/2017-----------------------
update the app\code\Emthemes\QuickShop\view\frontend\web\js\quickshop.js to fix the issue on wishlist list

Magento version 2.1.4
----------------------Feb/24/2017-----------------------
update theme shopping center

----------------------March/1/2017----------------------
update version 2.1.5
fix quickshop issue

----------------------March/13/2017---------------------
add function show block, help to customize easily

----------------------April/10/2017---------------------
add function auto install data megamenu 
	+add folder app/code/Emthemes/MegaMenu/Controller/Export
	+add folder app/code/Emthemes/MegaMenu/fixtures
	+add more file on app/code/Emthemes/MegaMenu/Setup
fix issue about the mobile search
	+fix file app/design/frontend/Emthemes/everything/default/Magento_Search/templates/form.mini.mobile.phtml

----------------------April/19/2017------------------------
update version 2.1.6
update new slideshow va file app/code/Emthemes/ThemeSettings/etc/adminhtml/menu.xml
fix issue swatch-render.js by 
	+edit file app/code/design/frontend/Emthemes/everything/default/Magento_Swatches/templates/product/view/renderer.phtml 
	+create new js: app/code/design/frontend/Emthemes/everything/default/Magento_Swatches/web/js/swatch-renderer-custom.js

---------------------April/21/2017---------------------------
fix issue auto install sample data for megamenu
	+ edit file app/code/Emthemes/MegaMenu/Controller/Export/Index.php
	+ edit file app/code/Emthemes/MegaMenu/Setup/Model/Menu.php
	+ edit file app/code/Emthemes/Megamenu/etc/adminhtml/menu.xml
	+ edit file app/code/Emthemes/Themesettings/etc/adminhtml/menu.xml

----------------------April/25/2017-----------------------------
fix issue about Emthemes_ProductLabel can not save when select condition is SKU
	+ file fix: app/code/Emthemes/ProductLabels/Model/ResourceModel/Label.php

----------------------April/26/2017----------------------------------------------
fix issue about MegaMenu can not render the Widget CMS
	+ file fix: app/code/Emthemes/ShowBlock/Block/Magento/Cms/Widget/Block.php

----------------------May/05/2017-----------------------------------------------
fix wysiwyg don't display on firefox, widget can not open in chrome (windown)
 + \lib\web\mage\adminhtml\wysiwyg\tiny_mce\setup.js  --> add code on line 55
		   if (jQuery.isReady) {
               tinyMCE.dom.Event.domLoaded = true;
            }
 + lib\web\tiny_mce\tiny_mce_src.js on line 1173
	ed.selection.getSel().setBaseAndExtent(e, 0, e, 1); bằng lệnh ed.selection.select(e);

----------------------------May/17/2017-----------------------------------------------
fix issue about Megamenu on admin (change data after save new element tab)
+ app/code/Emthemes/MegaMenu/view/adminhtml/web/template/form/element/content.html on line 16
        			<input type="hidden" name="check_tab" />	
+ app/code/Emthemes/MegaMenu/view/adminhtml/web/js/form/element/megamenu.js on line 50 -> 56
	              
	              $("#myModal input[name='check_tab']").val(data_href_li_check_active);
                  $("#myModal select[name='width']").val($(this).attr("dwidth"))
                  $("#myModal input[name='title']").val($(this).text());
                  $("#myModal input[name='link']").val($(this).attr("dlink"));
                  
                  $("#myModal input[name='custom_class']").val($(this).attr("dcustom_class"));
 and line 143:

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

+ add function clear all cache after save the menu
	create new file  app/code/Emthemes/MegaMenu/etc/adminhtml/events.xml
	create new file  app/code/Emthemes/MegaMenu/Observer/Adminhtml/ClearCacheObserver.php
	change file app/code/Emthemes/MegaMenu/Controller/Adminhtml/Menu/Save.php line 74
        $this->_eventManager->dispatch('controller_action_after_megamenu_adminhtml_menu_save');
	change file app/code/Emthemes/MegaMenu/Controller/Adminhtml/Menu/Delete.php line 26
        $this->_eventManager->dispatch('controller_action_after_megamenu_adminhtml_menu_save');        


---------------------------May/19/2017------------------------------------------------------
+ fix issue about em0144.js has been conflicted with some extension which don't use header
  update file : app/design/frontend/Emthemes/everything/default/web/js/em0144.js
+ fix issue about theme get wrong media url
  update file : app/code/Emthemes/ThemeSettings/Controller/Adminhtml/Config/Save.php


---------------------------May/24/2017----------------------------------------------------
+ update cloudzoom function for theme
- Add new file - app/code/Emthemes/ThemeSettings/Model/Config/Source/Eventtype.php
- Add new file app/code/Emthemes/ThemeSettings/Model/Config/Source/Yesno.php
- Edit app/design/frontend/Emthemes/sarah/default/etc/adminhtml/emthemes_settings.xml from line 1032 to 1068
- Edit app/design/frontend/Emthemes/sarah/default/Magento_Catalog/templates/product/view/gallery.phtml
+ From line 66 to 80
+ From line 105 to 127
- Edit app/design/frontend/Emthemes/sarah/default/etc/view.xml from line 237 to 245
- Edit app/design/frontend/Emthemes/sarah/default/etc/config.xml from line 257 to 266
+ update cloudzoom function for Quickshop
- app/code/Emthemes/QuickShop/view/frontend/templates/product/view/gallery.phtml


---------------------------May/29/2017--------------------------------------------------------
+fix issue ajaxcart make site broken when use quickshop in related product
---update file: app/code/Emthemes/QuickShop/view/frontend/web/js/quickshop.js 

---------------------------June/7/2017--------------------------------------------------------
+ update magento 2.1.7
- fix issue export widget update file app/code/Emthemes/ThemeSettings/Controller/Export/Index.php line 128
+ update new homepage
---------------------------June/8/2017-------------------------------------------------------
+ fix issue export widget update file app/code/Emthemes/ThemeSettings/Controller/Export/Index.php line 132
	$data['theme_path'] = 'frontend/'.$theme->getData('theme_path');
	
---------------------------June/15/2017------------------------------------------------------
+ fix issue can not deleted the element on admin
  update file: app\code\Emthemes\MegaMenu\view\adminhtml\web\js\form\element\megamenu.js