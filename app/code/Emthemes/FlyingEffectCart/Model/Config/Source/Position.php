<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Used in creating options for Yes|No config value selection
 *
 */
namespace Emthemes\FlyingEffectCart\Model\Config\Source;

class Position implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [['value' => 2, 'label' => __('bottom')], ['value' => 1, 'label' => __('right')], ['value' => 0, 'label' => __('left')]];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [0 => __('left'), 1 => __('right'), 2 => __('bottom')];
    }
}
