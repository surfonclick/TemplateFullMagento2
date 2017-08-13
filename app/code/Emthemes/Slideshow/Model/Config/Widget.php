<?php 


namespace Emthemes\Slideshow\Model\Config;
class Widget implements \Magento\Framework\Option\ArrayInterface
{

		protected $_modelitemsFactory;
		public function __construct(
			
			\Emthemes\Slideshow\Model\Resource\Items\CollectionFactory  $modelNewsFactory
		) {
			
			$this->_modelitemsFactory = $modelNewsFactory;
		}	

 public function toOptionArray()
    {
		
		$a=$this->slideShow();
		return $a;
    }
	
		public function slideShow()
		{
			$newsModel = $this->_modelitemsFactory->create()->addFieldToFilter('status',1);
			foreach ($newsModel as $slider) {
						$option[]= [
							'label' => $slider->getName(),
							'value' => $slider->getId(),
						];
			}
			return $option;
		}	
}