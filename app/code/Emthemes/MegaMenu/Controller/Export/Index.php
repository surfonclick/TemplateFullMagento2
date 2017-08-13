<?php
/**
 * Copyright © 2015 Emthemes. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Emthemes\MegaMenu\Controller\Export;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Catalog\Controller\Product
{
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Emthemes\MegaMenu\Model\ResourceModel\Menu\Collection $itemsCollection
	)
	{
		$this->itemsCollection = $itemsCollection;
		parent::__construct($context);
	}
    public function execute()
    {
    	$path = dirname(dirname(__DIR__)).'/fixtures';
        $list = array (
			array('name','identifier','type','content','frontend','css_class','is_active')
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
		echo 'export megemenu finish'.'<br/>';
        exit;
    }
}
