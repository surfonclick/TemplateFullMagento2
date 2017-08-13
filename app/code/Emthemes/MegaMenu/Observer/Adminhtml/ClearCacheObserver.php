<?php
/**
 * Module: Emthemes_MegaMenu
 * Author: Stephen Nguyen
 * Email: anhdung.phc@gmail.com
 * See COPYING.txt for license details.
 */

namespace Emthemes\MegaMenu\Observer\Adminhtml;
use Magento\Framework\Event\ObserverInterface;


class ClearCacheObserver implements ObserverInterface
{
    const ADMIN_RESOURCE = 'Magento_Backend::cache';

    /**
     * @var \Magento\Framework\App\Cache\TypeListInterface
     */
    protected $_cacheTypeList;

    /**
     * @var \Magento\Framework\App\Cache\StateInterface
     */
    protected $_cacheState;

    /**
     * @var \Magento\Framework\App\Cache\Frontend\Pool
     */
    protected $_cacheFrontendPool;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

  public function __construct(         
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Cache\StateInterface $cacheState,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory )
  {
    print_r("123");
    $this->_cacheTypeList = $cacheTypeList;
    $this->_cacheState = $cacheState;
    $this->_cacheFrontendPool = $cacheFrontendPool;
    $this->resultPageFactory = $resultPageFactory;

  }

  public function execute(\Magento\Framework\Event\Observer $observer)
  {
      foreach ($this->_cacheFrontendPool as $cacheFrontend) {
        $cacheFrontend->getBackend()->clean();
    }
  }
}