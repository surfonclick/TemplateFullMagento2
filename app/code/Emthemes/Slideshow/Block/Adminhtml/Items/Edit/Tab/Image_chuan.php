<?php
/**
 * Copyright © 2015 Emthemes. All rights reserved.
 */

// @codingStandardsIgnoreFile

namespace Emthemes\Slideshow\Block\Adminhtml\Items\Edit\Tab;


use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;



class Image extends Generic implements TabInterface
{

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('Image Configure');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Image');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Prepare form before rendering HTML
     *
     * @return $this
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('current_emthemes_slideshow_items');
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('item_');
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Slideshow')]);

        $fieldset->addField(
            'image',
            'image',
            ['name' => 'image', 'label' => __('Item Name'), 'title' => __('Item Name'), 'required' => false,'note'=>__('Allowed file types: jpg, jpeg, gif, png')]
        );
	
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
