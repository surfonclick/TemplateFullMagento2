<?php

namespace Emthemes\ShowBlock\Block\Magento\Cms;


class Block extends \Magento\Cms\Block\Block
{

    protected function _toHtml()
    {
        $blockId = $this->getBlockId();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $check=$objectManager->create('Emthemes\ShowBlock\Helper\Data')->getShowBlockActive();        
        if($check){
            $blockname = "<span class=block-name>".$blockId."</span>"; 
        }
        else{
            $blockname="";       
        }
        $html = '';
        if ($blockId) {
            $storeId = $this->_storeManager->getStore()->getId();
            $block = $this->_blockFactory->create();
            $block->setStoreId($storeId)->load($blockId);
            if ($block->isActive()) {
                $html = $this->_filterProvider->getBlockFilter()->setStoreId($storeId)->filter($block->getContent());
                $html=$blockname.$html;   
            }
        }
    
        return $html;
    }

    public function getIdentities()
    {
        return [\Magento\Cms\Model\Block::CACHE_TAG . '_' . $this->getBlockId()];
    }
}
	
	