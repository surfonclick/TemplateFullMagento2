<?php 


namespace Emthemes\Slideshow\Model;

class Widget extends \Magento\Framework\Model\AbstractModel
{

	protected $_slideshowFactory;
	
	public function __construct(
		\Magento\Framework\Model\Context $context,
		\Magento\Framework\Registry $coreRegistry,		
        \Emthemes\Slideshow\Model\Resource\Items\CollectionFactory  $slideshowFactory

	)
	{
		parent::__construct();		
		$this->_slideshowFactory = $slideshowFactory;
		$this->_coreRegistry = $coreRegistry;		

	}
	
	public function toOptionArray()
    {
       $newsModel = $this->_slideshowFactory->create();
	   foreach($newsModel as $item)
	   {
		  $option[] = [
			'value' => $item->getId(),
			'label' => $item->getName(),
		  ];
	   }
	   return $option;
    }
}