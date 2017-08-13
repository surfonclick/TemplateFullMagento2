<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Emthemes\MegaMenu\Controller\Adminhtml\Menu;

use Magento\Framework\Exception\LocalizedException;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * @return void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('menu_id');
        if ($id) {
            try {
                /** @var \Magento\CatalogRule\Model\Rule $model */
                $model = $this->_objectManager->create('Emthemes\MegaMenu\Model\Menu')->load($id);
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('You deleted the menu.'));
                $this->_eventManager->dispatch('controller_action_after_megamenu_adminhtml_menu_save');
                $this->_redirect('megamenu/index/index');
                return;
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __('We can\'t delete this Menu right now. Please review the log and try again.')
                );
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_redirect('megamenu/index/index', ['menu_id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        $this->messageManager->addError(__('We can\'t find a menu to delete.'));
        $this->_redirect('megamenu/');
    }
}
