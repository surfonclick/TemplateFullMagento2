<?php
/**
 * Copyright © 2015 Emthemes. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magefan\Blog\Controller\Export;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Catalog\Controller\Product
{
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magefan\Blog\Model\ResourceModel\Post\Collection $postCollection
	)
	{
		$this->postCollection = $postCollection;
		parent::__construct($context);
	}
    public function execute()
    {
    	$path = dirname(dirname(__DIR__)).'/fixtures';
        $list = array (
			array('title','meta_keywords','meta_description','identifier','content_heading','image','short_description','content','creation_time','update_time','publish_time','is_active')
		);
		
		$this->postCollection->addFieldToSelect('*');
		foreach($this->postCollection as $item){
			$data = [];
			foreach($list[0] as $attribute){
				$data[] = $item->getData($attribute);
			}
			$list[] = $data;
		}

		$fp = fopen($path.'/posts.csv', 'w');

		foreach ($list as $fields) {
			fputcsv($fp, $fields);
		}

		fclose($fp);
		echo 'export posts finish'.'<br/>';
        exit;
    }
}
