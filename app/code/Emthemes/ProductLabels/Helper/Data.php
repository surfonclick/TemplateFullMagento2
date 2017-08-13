<?php
/**
 * Copyright © 2015 Emthemes . All rights reserved.
 */
namespace Emthemes\ProductLabels\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	 /**
     * @var \Magento\Framework\Locale\CurrencyInterface
     */
    protected $_localeCurrency;
	/**
     * @param \Magento\Framework\App\Helper\Context $context
     */
	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
		\Magento\Framework\Locale\CurrencyInterface $localeCurrency,
		\Emthemes\ProductLabels\Model\ResourceModel\Label\Collection $labelCollection,
		\Magento\Store\Model\StoreManagerInterface $storeManager
		       
	) {
		parent::__construct($context);
		$this->_storeManager = $storeManager;
		$this->_localeCurrency = $localeCurrency;
		$this->_labelCollection = $labelCollection;
	}
	
	public function display($product){
		$this->_labelCollection->addFieldToFilter('is_active',1);
		if($this->_labelCollection->count() > 0){
			echo '<ul class="productlabels_icons">';
			foreach($this->_labelCollection as $label){
				$label->setStore($this->_storeManager->getStore()->getStoreId());
				$label->load($label->getId());
				if($label->validate($product)){
					$this->labelHtml($label);
				}
			}
			echo '</ul>';
		}
	}
	
	public function labelHtml($label){
		$path = $this->_storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ) . 'productlabel/';
		$background = $label->getBackground();
		if ($background)
		{
		    $src = $path.$background;
		    $style = "style='background:url(\"$src\") no-repeat scroll 0 0 transparent'";
		}
		else $style = '';
		echo '<li class="label '.$label->getCssClass().'" '.$style.'>';
	    $image = $label->getImage();
	    if($image){
	    	echo '<img src="'.$path.$image.'"/>';
	    }
	    echo '<p>';
	    echo $label->getText();
	    echo '</p>';
		echo '</li>';
	}
}
