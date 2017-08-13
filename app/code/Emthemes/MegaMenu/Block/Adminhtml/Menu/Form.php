<?php

namespace Emthemes\MegaMenu\Block\Adminhtml\Menu;

class Form extends \Magento\Framework\View\Element\Template
{
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Data\Form $form,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Magento\Framework\Data\Form\Element\Factory $elementFactory,
        \Magento\Catalog\Block\Adminhtml\Helper\Form\Wysiwyg $wysiwyg,
        array $data = []
    )
    {
        $this->_elementFactory = $elementFactory;
        $this->_form = $form;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_wysiwyg = $wysiwyg;
        parent::__construct($context, $data);
    }
    
    public function getEditor()
    {
        $config = $this->_wysiwygConfig->getConfig();
        $editor = $this->_elementFactory->create('editor',$config->getData());
        $editor->setConfig($config);
        $editor->setName('test');
        $editor->setHtmlId('test');
        
        $editor->setForm($this->_form);
        return $editor;
        //return $this->_wysiwyg;
    }
    
}
