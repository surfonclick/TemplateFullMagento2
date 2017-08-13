<?php
/**
 * Copyright © 2015 Emthemes . All rights reserved.
 */
namespace Emthemes\ShowBlock\Helper;
use Magento\Framework\App\Filesystem\DirectoryList;
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	protected $_storeManager;
	protected $_scopeConfig;

	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager
		//\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
	) {
		parent::__construct($context);
		$this->_storeManager = $storeManager;
		$this->_scopeConfig = $context->getScopeConfig();//$scopeConfig;
	}



	public function getShowBlockActive(){
		return $this->_scopeConfig->getValue('showblock/general/active', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);	
	}
	public function getBaseUrl(){
		return $this->_storeManager->getStore()->getBaseUrl();
	}
}
