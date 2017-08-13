<?php
/**
 * Copyright © 2015 Emthemes. All rights reserved.
 */

namespace Emthemes\Slideshow\Controller\Adminhtml\Items;

class Index extends \Emthemes\Slideshow\Controller\Adminhtml\Items
{
    /**
     * Items list.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Emthemes_Slideshow::slideshow');
        $resultPage->getConfig()->getTitle()->prepend(__('Emthemes Items'));
        $resultPage->addBreadcrumb(__('Emthemes'), __('Emthemes'));
        $resultPage->addBreadcrumb(__('Items'), __('Items'));
        return $resultPage;
    }
}
