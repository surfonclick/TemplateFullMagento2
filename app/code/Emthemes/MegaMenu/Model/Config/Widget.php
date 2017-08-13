<?php 


namespace Emthemes\MegaMenu\Model\Config;
class Widget implements \Magento\Framework\Option\ArrayInterface
{
    protected $_modelFactory;
    public function __construct(
        \Emthemes\MegaMenu\Model\ResourceModel\Menu\CollectionFactory  $modelFactory
    ) {
        $this->_modelFactory = $modelFactory;
    }	

    public function toOptionArray()
    {
        $a  = $this->getMenu();
        return $a;
    }

    public function getMenu()
    {
        $collection = $this->_modelFactory->create()->addFieldToFilter('is_active',1);
        foreach ($collection as $menu) {
	        $option[]= [
		        'label' => $menu->getName(),
		        'value' => $menu->getId(),
	        ];
        }
        return $option;
    }	
}
