<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Watermark position config source model
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
namespace Emthemes\MegaMenu\Model\Config\Source;

class Type implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Get available options
     *
     * @codeCoverageIgnore
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => '1', 'label' => __('Vertical')],
            ['value' => '0', 'label' => __('Horizon')],
        ];
    }
}
