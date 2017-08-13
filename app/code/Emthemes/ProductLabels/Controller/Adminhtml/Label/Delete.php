<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Emthemes\ProductLabels\Controller\Adminhtml\Label;

use Magento\Framework\Exception\LocalizedException;

class Delete extends \Magento\CatalogRule\Controller\Adminhtml\Promo\Catalog
{
    /**
     * @return void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('label_id');
        if ($id) {
            try {
                /** @var \Magento\CatalogRule\Model\Rule $model */
                $model = $this->_objectManager->create('Emthemes\ProductLabels\Model\Label');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('You deleted the rule.'));
                $this->_redirect('productlabels/');
                return;
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __('We can\'t delete this label right now. Please review the log and try again.')
                );
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_redirect('productlabels/edit', ['label_id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        $this->messageManager->addError(__('We can\'t find a label to delete.'));
        $this->_redirect('productlabels/');
    }
}
