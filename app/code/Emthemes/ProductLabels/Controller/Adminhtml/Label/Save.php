<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Emthemes\ProductLabels\Controller\Adminhtml\Label;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Magento\Backend\App\Action//\Magento\CatalogRule\Controller\Adminhtml\Promo\Catalog
{

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
    	\Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
    	\Magento\Framework\Filesystem $fileSystem,
    	\Magento\Framework\Filesystem\Driver\File $fileDriver
	){
		$this->uploaderFactory = $uploaderFactory;
		$this->fileSystem = $fileSystem;
		$this->fileDriver = $fileDriver;
		parent::__construct($context);
	}

	public function getBaseDir()
    {
        return $this->fileSystem->getDirectoryWrite(DirectoryList::MEDIA)->getAbsolutePath('productlabel');
    }

	public function uploadFileAndGetName($input, $data)
	{
		try {
		    if (isset($data[$input]['delete'])) {
		    	$file = $this->getBaseDir().'/'.$data[$input]['value'];
		    	$this->fileDriver->deleteFile($file);
		        return '';
		    } else {

		        $uploader = $this->uploaderFactory->create(['fileId' => $input]);
		        $uploader->setAllowRenameFiles(true);
		        $uploader->setFilesDispersion(false);
		        $uploader->setAllowCreateFolders(true);
		        $result = $uploader->save($this->getBaseDir());
		        //print_r($result);die;
		        return $result['file'];
		    }
		} catch (\Exception $e) {
		    if ($e->getCode() != \Magento\Framework\File\Uploader::TMP_NAME_EMPTY) {
		    	
		        throw new \Magento\Framework\Exception\LocalizedException(__($e->getMessage()));
		    } else {
		        if (isset($data[$input]['value'])) {
		            return $data[$input]['value'];
		        }
		    }
		}
		return '';
	}

	protected function _beforeSave($model, $request)
	{
		$data = $request->getParams();
		if(count($_FILES)){
			$imageName = $this->uploadFileAndGetName('image',$data);
			$model->setData('image',$imageName);
			$imageName = $this->uploadFileAndGetName('background',$data);
			$model->setData('background',$imageName);
		}
	}
    /**
     * @return void
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute()
    {
        if ($this->getRequest()->getPostValue()) {
            try {
                /** @var \Magento\CatalogRule\Model\Rule $model */
                
                $model = $this->_objectManager->create('Emthemes\ProductLabels\Model\Label');
                $data = $this->getRequest()->getPostValue();
                $id = $this->getRequest()->getParam('label_id');
                if ($id) {
                    $model->load($id);
                    if ($id != $model->getId()) {
                        throw new LocalizedException(__('Wrong label specified.'));
                    }
                }


                if (isset($data['rule'])) {
                    $data['conditions'] = $data['rule']['conditions'];
                    unset($data['rule']);
                }
                
                unset($data['rule']);
				$model->loadPost($data);
				$this->_beforeSave($model,$this->getRequest());
				
                //$this->_objectManager->get('Magento\Backend\Model\Session')->setPageData($model->getData());
                $model->save();

                $this->messageManager->addSuccess(__('You saved the label.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData(false);
                if ($this->getRequest()->getParam('auto_apply')) {
                    $this->getRequest()->setParam('rule_id', $model->getId());
                    $this->_forward('applyRules');
                } else {
                    if ($this->getRequest()->getParam('back')) {
                        $this->_redirect('productlabels/*/edit', ['label_id' => $model->getId(),'store' => $model->getStore()]);
                        return;
                    }
                    $this->_redirect('productlabels/');
                }
                return;
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __('Something went wrong while saving the label data. Please review the error log.')
                );
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData($data);
                $this->_redirect('productlabels/*/edit', ['label_id' => $this->getRequest()->getParam('label_id')]);
                return;
            }
        }
        $this->_redirect('productlabels/*/');
    }
}
