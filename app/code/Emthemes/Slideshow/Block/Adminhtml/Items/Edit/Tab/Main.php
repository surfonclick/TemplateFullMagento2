<?php
/**
 * Copyright © 2015 Emthemes. All rights reserved.
 */

// @codingStandardsIgnoreFile

namespace Emthemes\Slideshow\Block\Adminhtml\Items\Edit\Tab;


use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Emthemes\Slideshow\Model\Select; 
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;


class Main extends Generic implements TabInterface
{

    /**
     * {@inheritdoc}
     */
	 
	protected $_select;
	
	
	public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Select $_select,
        array $data = []
    ) {
        $this->_select = $_select;
        parent::__construct($context, $registry, $formFactory, $data);
    }	
	
    public function getTabLabel()
    {
        return __('General Setting');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('General');
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
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }
        $fieldset->addField(
            'name',
            'text',
            ['name' => 'name', 'label' => __('Slider Name'), 'title' => __('Slider Name'), 'required' => true]
        );
		
        $fieldset->addField(
            'identity',
            'text',
            ['name' => 'identity', 'label' => __('ID'), 'title' => __('ID'), 'required' => true]
        );
		
		$fieldset->addField(
			'status',
			'select',
			[
				'label' => __('Status'),
				'title' => __('Slideshow Status'),
				'name' => 'status',
				'options' => $this->_select->getAvailableStatuses(),
			]			
		);
		$fieldset->addField(
            'width',
            'text',
            ['name' => 'width', 'label' => __('Width'), 'title' => __('Width'), 'required' => false]
        );
		$fieldset->addField(
            'height',
            'text',
            ['name' => 'height', 'label' => __('Height'), 'title' => __('Height'), 'required' => false]
        );		
	
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
