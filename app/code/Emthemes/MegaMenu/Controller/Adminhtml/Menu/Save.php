<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Emthemes\MegaMenu\Controller\Adminhtml\Menu;

use Emthemes\MegaMenu\Model\Menu;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Request\DataPersistorInterface;

//class Save extends \Magento\Backend\App\Action//\Magento\CatalogRule\Controller\Adminhtml\Promo\Catalog
class Save extends \Magento\Backend\App\Action//\Magento\Cms\Controller\Adminhtml\Block
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @param Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
		\Magento\Backend\App\Action\Context $context,
    	\Magento\Framework\Registry $coreRegistry,
        DataPersistorInterface $dataPersistor
	){
		$this->dataPersistor = $dataPersistor;
		parent::__construct($context);
	}

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */

        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('menu_id');

            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = Menu::STATUS_ENABLED;
            }
            if (empty($data['menu_id'])) {
                $data['menu_id'] = null;
            }

            /** @var \Magento\Cms\Model\Block $model */
            $model = $this->_objectManager->create('Emthemes\MegaMenu\Model\Menu')->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addError(__('This menu no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the menu.'));
                $this->dataPersistor->clear('megamenu');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['menu_id' => $model->getId()]);
                }
                $this->_eventManager->dispatch('controller_action_after_megamenu_adminhtml_menu_save');
                return $resultRedirect->setPath('megamenu/index/index');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the menu.'));
            }

            $this->dataPersistor->set('megamenu', $data);


            return $resultRedirect->setPath('*/*/edit', ['menu_id' => $this->getRequest()->getParam('menu_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
