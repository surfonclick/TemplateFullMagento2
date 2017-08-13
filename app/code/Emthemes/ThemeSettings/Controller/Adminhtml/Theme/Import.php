<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Emthemes\ThemeSettings\Controller\Adminhtml\Theme;

class Import extends \Magento\Backend\App\Action
{
    private $_page;
    private $_block;
    private $_widget;
    private $_slideshow;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,                    
        \Emthemes\ThemeSettings\Setup\Model\Page $page,
        \Emthemes\ThemeSettings\Setup\Model\Block $block,
        \Emthemes\ThemeSettings\Setup\Model\Widget $widget,
        \Emthemes\Slideshow\Setup\Model\Item $slideshow,
        \Magento\Widget\Model\Widget\InstanceFactory $widgetFactory
    )
    {
        $this->_widgetFactory = $widgetFactory;       
        $this->_page = $page;
        $this->_block = $block;
        $this->_widget = $widget;        
        $this->_slideshow = $slideshow;
        $this->_objectManager = $context->getObjectManager();
        parent::__construct($context);
    }
    /**
     * Index action
     *
     * @return void
     */
    public function execute()
    {

        $path = \Magento\Framework\View\DesignInterface::XML_PATH_THEME_ID;
        /** @var $section \Magento\Config\Model\Config\Structure\Element\Section */
        try {
            $themeId = $this->getRequest()->getParam('settheme');
            $themeModel = $this->_objectManager->get('\Magento\Theme\Model\Theme');
            $themeModel->load($themeId);
            $theme_path = $themeModel->getData('theme_path');
            $theme_identifier = str_replace('Emthemes/','',$theme_path);                                                        
            $this->_page->install(['Emthemes_ThemeSettings::fixtures/page/'.$theme_identifier.'.csv']);
            $this->_block->install(['Emthemes_ThemeSettings::fixtures/block/'.$theme_identifier.'.csv']);
            $this->_widget->install(['Emthemes_ThemeSettings::fixtures/widget/'.$theme_identifier.'.csv']);
            $this->_slideshow->install(['Emthemes_Slideshow::fixtures/items.csv']);
            $params = array();
            $params['code'] = $this->getRequest()->getParam('code');                    
            $this->messageManager->addSuccess(__('You imported the theme.'));        	
        }
        catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
            $this->_getSession()->setThemeData($themeData);
            $this->_getSession()->setThemeCustomCssData($customCssData);        
        } catch (\Exception $e) {
            $this->messageManager->addError('The theme was not saved');
            $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
        }
        $this->_redirect('themesettings/theme/index',$params);
        
    }
}
