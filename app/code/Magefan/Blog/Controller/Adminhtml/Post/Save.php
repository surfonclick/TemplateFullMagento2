<?php
/**
 * Copyright © 2015 Ihor Vansach (ihor@magefan.com). All rights reserved.
 * See LICENSE.txt for license details (http://opensource.org/licenses/osl-3.0.php).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magefan\Blog\Controller\Adminhtml\Post;
use Magento\Framework\App\Filesystem\DirectoryList;
/**
 * Blog post save controller
 */
class Save extends \Magefan\Blog\Controller\Adminhtml\Post
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
	/**
	 * Before model save
	 * @param  \Magefan\Blog\Model\Post $model
	 * @param  \Magento\Framework\App\Request\Http $request
	 * @return void
	 */
	protected function _beforeSave($model, $request)
	{
		if ($links = $request->getParam('links')) {

			foreach (array('post', 'product') as $key) {
				$param = 'related'.$key.'s';
				if (!empty($links[$param])) {
					$ids = array_unique(
						array_map('intval',
							explode('&', $links[$param])
						)
					);
					if (count($ids)) {
						$model->setData('related_'.$key.'_ids', $ids);
					}
				}
			}
		}
		$data = $request->getParams();
		$imageName = $this->uploadFileAndGetName('image',$data);
		$model->setData('image',$imageName);
	}
	
	public function getBaseDir()
    {
        return $this->fileSystem->getDirectoryWrite(DirectoryList::MEDIA)->getAbsolutePath('blog');
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
}
