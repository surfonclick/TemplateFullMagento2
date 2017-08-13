<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Emthemes\ProductLabels\Controller\Adminhtml\Label;

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
            'Emthemes_ProductLabels::product_labels'
        )->_addBreadcrumb(
            __('Product Labels'),
            __('Product Labels')
        );
        return $this;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('label_id');
        $storeId = $this->getRequest()->getParam('store');
        $model = $this->_objectManager->create('Magento\CatalogRule\Model\Rule');
        $labelModel = $this->_objectManager->create('Emthemes\ProductLabels\Model\Label');
        $labelModel->setStore($storeId);
        if ($id) {
            $labelModel->load($id);
            if (!$model->getRuleId()) {
                //$this->messageManager->addError(__('This rule no longer exists.'));
                //$this->_redirect('catalog_rule/*');
                //return;
            }
        }

        // set entered data if was error when we do save
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getPageData(true);
        if (!empty($data)) {
            $model->addData($data);
        }
        $model->getConditions()->setJsFormObject('rule_conditions_fieldset');

        $this->_coreRegistry->register('current_label', $labelModel);
        $this->_coreRegistry->register('current_rule', $model);

        $this->_initAction();
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Label Rule'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(
            $model->getRuleId() ? $model->getName() : __('New Label')
        );
        $this->_view->getLayout()->getBlock(
            'promo_catalog_edit'
        )->setData(
            'action',
            $this->getUrl('catalog_rule/promo_catalog/save')
        );

        $breadcrumb = $id ? __('Edit Rule') : __('New Rule');
        $this->_addBreadcrumb($breadcrumb, $breadcrumb);
        $this->_view->renderLayout();
    }
}
