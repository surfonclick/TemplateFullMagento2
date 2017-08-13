<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Used in creating options for Yes|No config value selection
 *
 */
namespace Emthemes\ThemeSettings\Model\Config\Source;

class Eventtype implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
        ['value' => 'hover', 'label' => __('Hover')], 
        ['value' => 'click', 'label' => __('Click')]
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [
        'hover' => __('Hover'), 
        'click' => __('Click')
        ];
    }
}
