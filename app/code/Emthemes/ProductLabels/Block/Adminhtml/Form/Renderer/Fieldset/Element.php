<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Catalog fieldset element renderer
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
namespace Emthemes\ProductLabels\Block\Adminhtml\Form\Renderer\Fieldset;

class Element extends \Magento\Backend\Block\Widget\Form\Renderer\Fieldset\Element
{
    /**
     * Initialize block template
     */
    protected $_template = 'Magento_Catalog::catalog/form/renderer/fieldset/element.phtml';

    /**
     * Retrieve data object related with form
     *
     * @return \Magento\Catalog\Model\Product || \Magento\Catalog\Model\Category
     */
    public function getDataObject()
    {
        return $this->getElement()->getForm()->getDataObject();
    }

    /**
     * Retireve associated with element attribute object
     *
     * @return \Magento\Catalog\Model\ResourceModel\Eav\Attribute
     */
    public function getAttribute()
    {
        return $this->getElement()->getEntityAttribute();
    }

    /**
     * Retrieve associated attribute code
     *
     * @return string
     */
    public function getAttributeCode()
    {
    	return $this->getElement()->getName();
        //return $this->getAttribute()->getAttributeCode();
    }

    /**
     * Check "Use default" checkbox display availability
     *
     * @return bool
     */
    public function canDisplayUseDefault()
    {
    	//print_r($this->getDataObject()->getData());die;
        //if ($attribute = $this->getAttribute()) {
            if (!$this->isScopeGlobal() &&
                $this->getDataObject() &&
                $this->getDataObject()->getId() &&
                $this->getDataObject()->getStore()
            ) {
                return true;
            }
        //}
        return false;
    }

    /**
     * Check default value usage fact
     *
     * @return bool
     */
    public function usedDefault()
    {
    	$attributeCode = $this->getElement()->getName();
        $defaultValue = $this->getDataObject()->getDefaultValue($attributeCode);

        if (!$this->getDataObject()->getExistsStoreValueFlag($attributeCode)) {
            return true;
        } elseif ($this->getElement()->getValue() == $defaultValue &&
            $this->getDataObject()->getStore() != $this->_getDefaultStoreId()
        ) {
            return false;
        }
        if ($defaultValue === false && $this->getElement()->getValue()) {
            return false;
        }
        return $defaultValue === false;
    }

    /**
     * Disable field in default value using case
     *
     * @return \Magento\Catalog\Block\Adminhtml\Form\Renderer\Fieldset\Element
     */
    public function checkFieldDisable()
    {
        if ($this->canDisplayUseDefault() && $this->usedDefault()) {
            $this->getElement()->setDisabled(true);
        }
        return $this;
    }
    
    protected function isScopeGlobal()
    {
    	$names = ['title','condition','is_active','label_id','store'];
    	if(in_array($this->getElement()->getName(), $names)){
    		return true;
    	}else{
    		return false;
    	}
    }
    
    protected function isScopeStore()
    {
    	$names = ['image','background','text','css_class'];
    	if(in_array($this->getElement()->getName(), $names)){
    		return true;
    	}else{
    		return false;
    	}
    }

    /**
     * Retrieve label of attribute scope
     *
     * GLOBAL | WEBSITE | STORE
     *
     * @return string
     */
    public function getScopeLabel()
    {
    	//echo $this->getDataObject()->getStoreId();die('ab');
        $html = '';
        if ($this->isScopeGlobal()) {
            $html .= __('[GLOBAL]');
        } elseif ($this->isScopeStore()) {
            $html .= __('[STORE VIEW]');
        }

        return $html;
    }

    /**
     * Retrieve element label html
     *
     * @return string
     */
    public function getElementLabelHtml()
    {
        $element = $this->getElement();
        $label = $element->getLabel();
        if (!empty($label)) {
            $element->setLabel(__($label));
        }
        return $element->getLabelHtml();
    }

    /**
     * Retrieve element html
     *
     * @return string
     */
    public function getElementHtml()
    {
        return $this->getElement()->getElementHtml();
    }

    /**
     * Default sore ID getter
     *
     * @return integer
     */
    protected function _getDefaultStoreId()
    {
        return \Magento\Store\Model\Store::DEFAULT_STORE_ID;
    }
}
