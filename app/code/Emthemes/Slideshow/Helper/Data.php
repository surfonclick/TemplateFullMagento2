<?php
namespace Emthemes\Slideshow\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    protected $_scopeConfig;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context
       // \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
        //\Magento\MediaStorage\Helper\File\Storage\Database $coreFileStorageDatabase
    ) {

        $this->_scopeConfig = $context->getScopeConfig();
        parent::__construct($context);
    }

    public function checkEnabel(){

        return $this->_scopeConfig->getValue('slideshow/general/active', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

    }

    function getAssetUrl($asset) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $assetRepository = $objectManager->get('Magento\Framework\View\Asset\Repository');
        return $assetRepository->createAsset($asset)->getUrl();
    }
}