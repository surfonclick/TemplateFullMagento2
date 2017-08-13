<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Emthemes\MegaMenu\Controller\Adminhtml\Index;

/**
 * Cms manage blocks controller
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Index extends \Magento\Backend\App\Action
{

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
	
	public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        //$this->initPage($resultPage)->getConfig()->getTitle()->prepend(__('Blocks'));
        return $resultPage;
    }
}
