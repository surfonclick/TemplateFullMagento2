<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Catalog Rule General Information Tab
 *
 * @author Magento Core Team <core@magentocommerce.com>
 */
namespace Emthemes\ProductLabels\Block\Adminhtml\Label\Edit\Tab;

use Magento\Backend\Block\Widget\Form;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;

class Main extends Generic implements TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @var \Magento\Customer\Api\GroupRepositoryInterface
     */
    protected $_groupRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $_searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Convert\DataObject
     */
    protected $_objectConverter;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Customer\Api\GroupRepositoryInterface $groupRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\Convert\DataObject $objectConverter
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Convert\DataObject $objectConverter,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_groupRepository = $groupRepository;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_objectConverter = $objectConverter;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare content for tab
     *
     * @return \Magento\Framework\Phrase
     * @codeCoverageIgnore
     */
    public function getTabLabel()
    {
        return __('Label Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     * @codeCoverageIgnore
     */
    public function getTabTitle()
    {
        return __('Label Information');
    }

    /**
     * Returns status flag about this tab can be showed or not
     *
     * @return bool
     * @codeCoverageIgnore
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return bool
     * @codeCoverageIgnore
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * @return Form
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('current_label');
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
        	
        );
        $form->setHtmlIdPrefix('label_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('General Information')]);
        if ($model->getId()) {
            $fieldset->addField('label_id', 'hidden', ['name' => 'label_id']);
        }
        
        $fieldset->addField('store', 'hidden', ['name' => 'store']);

        $fieldset->addField(
            'title',
            'text',
            ['name' => 'title', 'label' => __('Title'), 'title' => __('Title'), 'required' => true]
        );
        
        $fieldset->addField(
            'image',
            'Emthemes\ProductLabels\Block\Adminhtml\Label\Helper\Image',
            ['name' => 'image', 'label' => __('Image'), 'title' => __('Image')]
        );
        
        $fieldset->addField(
            'background',
            'Emthemes\ProductLabels\Block\Adminhtml\Label\Helper\Image',
            ['name' => 'background', 'label' => __('Background'), 'title' => __('Background')]
        );

        $fieldset->addField(
            'text',
            'textarea',
            [
                'name' => 'text',
                'label' => __('Text'),
                'title' => __('Text'),
                'style' => 'height: 100px;'
            ]
        );
        
        $fieldset->addField(
            'css_class',
            'text',
            ['name' => 'css_class', 'label' => __('CSS Class'), 'title' => __('CSS Class')]
        );

        $fieldset->addField(
            'is_active',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'is_active',
                'required' => true,
                'options' => ['1' => __('Active'), '0' => __('Inactive')]
            ]
        );

		$form->setDataObject($model);
        $form->setValues($model->getData());

        $this->setForm($form);

        return parent::_prepareForm();
    }
}
