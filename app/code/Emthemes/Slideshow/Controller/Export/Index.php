<?php
/**
 * Copyright © 2015 Emthemes. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Emthemes\Slideshow\Controller\Export;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Catalog\Controller\Product
{
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Emthemes\Slideshow\Model\Resource\Items\Collection $itemsCollection
	)
	{
		$this->itemsCollection = $itemsCollection;
		parent::__construct($context);
	}
    public function execute()
    {
    	$path = dirname(dirname(__DIR__)).'/fixtures';
        $list = array (
			array('name','identity','dev_en','slider_params','configure_params','transition_effect','width','height','number','status')
		);
		
		$this->itemsCollection->addFieldToSelect('*');
		foreach($this->itemsCollection as $item){
			$data = [];
			foreach($list[0] as $attribute){
				$data[] = $item->getData($attribute);
			}
			$list[] = $data;
		}

		$fp = fopen($path.'/items.csv', 'w');

		foreach ($list as $fields) {
			fputcsv($fp, $fields);
		}

		fclose($fp);
		echo 'export slideshow finish'.'<br/>';
        exit;
    }
}
