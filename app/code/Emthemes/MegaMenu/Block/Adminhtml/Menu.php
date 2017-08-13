<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Catalog manage products block
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
namespace Emthemes\MegaMenu\Block\Adminhtml;

class Menu extends \Magento\Backend\Block\Widget\Container
{

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Catalog\Model\Product\TypeFactory $typeFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        array $data = []
    ) {
        $this->_productFactory = $productFactory;
        $this->_typeFactory = $typeFactory;

        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_controller = 'adminhtml_menu';
        $this->_headerText = __('MegaMenu');
        $this->_addButtonLabel = __('Add New Menu');
        parent::_construct();
    }
}
