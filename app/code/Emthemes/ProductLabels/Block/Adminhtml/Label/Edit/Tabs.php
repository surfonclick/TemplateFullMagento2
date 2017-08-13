<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * description
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
namespace Emthemes\ProductLabels\Block\Adminhtml\Label\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('promo_catalog_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Product Label'));
    }
}
