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

class Effect implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [['value' => 2, 'label' => __('shake to fly')], ['value' => 1, 'label' => __('fade')], ['value' => 0, 'label' => __('normal')]];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [0 => __('normal'), 1 => __('fade'), 2 => __('shake to fly')];
    }
}
