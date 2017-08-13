<?php

namespace Emthemes\ShowBlock\Block\Magento\Cms\Widget;


class Block extends \Magento\Cms\Block\Widget\Block
{
    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();
        $blockId = $this->getData('block_id');
        $blockHash = get_class($this) . $blockId;

        if (isset(self::$_widgetUsageMap[$blockHash])) {
            return $this;
        }
        self::$_widgetUsageMap[$blockHash] = true;

        if ($blockId) {
            $storeId = $this->_storeManager->getStore()->getId();
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $check=$objectManager->create('Emthemes\ShowBlock\Helper\Data')->getShowBlockActive(); 
            $block = $this->_blockFactory->create();
            $block->setStoreId($storeId)->load($blockId,"block_id");
            if ($block->isActive()) {
                if($check){
                    $this->setIdentifier($block->getIdentifier());
                }
                $this->setText(
                    $this->_filterProvider->getBlockFilter()->setStoreId($storeId)->filter($block->getContent())
                );
            }
        }

        unset(self::$_widgetUsageMap[$blockHash]);
        return $this;
    }

	
}
	
	