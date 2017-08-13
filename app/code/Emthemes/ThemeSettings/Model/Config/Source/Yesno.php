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

class Yesno implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
        ['value' => 'true', 'label' => __('Yes')], 
        ['value' => 'false', 'label' => __('No')]
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
        'true' => __('Yes'), 
        'false' => __('No')
        ];
    }
}
