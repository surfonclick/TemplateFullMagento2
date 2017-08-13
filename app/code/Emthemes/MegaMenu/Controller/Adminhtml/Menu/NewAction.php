<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Emthemes\MegaMenu\Controller\Adminhtml\Menu;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
class NewAction extends \Magento\Backend\App\Action
{
    
    public function __construct(
    	Context $context, 
    	Registry $coreRegistry, 
    	Date $dateFilter
    ){
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->_dateFilter = $dateFilter;
    }
    
    protected function _initAction()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu(
            'Emthemes_MegaMenu::megamenu'
        )->_addBreadcrumb(
            __('MegaMenu'),
            __('MegaMenu')
        );
        return $this;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('menu_id');
        $storeId = $this->getRequest()->getParam('store');
        $model = $this->_objectManager->create('Magento\CatalogRule\Model\Rule');
        $menuModel = $this->_objectManager->create('Emthemes\MegaMenu\Model\Menu');
        $menuModel->setStore($storeId);
        if ($id) {
            $menuModel->load($id);
        }

        // set entered data if was error when we do save
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getPageData(true);
        if (!empty($data)) {
            $model->addData($data);
        }
        $this->_coreRegistry->register('current_menu', $menuModel);
        $this->_initAction();
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('MegaMenu'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(
            $model->getRuleId() ? $model->getName() : __('New Menu')
        );

        $breadcrumb = $id ? __('Edit Rule') : __('New Rule');
        $this->_addBreadcrumb($breadcrumb, $breadcrumb);
        $this->_view->renderLayout();
    }
}
