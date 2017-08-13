<?php
/**
 * Copyright © 2015 Emthemes. All rights reserved.
 */

// @codingStandardsIgnoreFile

namespace Emthemes\Slideshow\Block\Adminhtml\Items\Edit\Tab;


use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;



class Option extends Generic implements TabInterface
{

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('Effect Setting');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Effect');
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
		$model = $this->_coreRegistry->registry('current_emthemes_slideshow_items');
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
		$number=$model->getNumber();

		$renderer = $this->getLayout()->createBlock('Emthemes\Slideshow\Block\Adminhtml\Form\Renderer\Option');
		if($model->getId())
		{
			$renderer->setId($model->getId());
		}
		$fieldset->setRenderer($renderer);
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
