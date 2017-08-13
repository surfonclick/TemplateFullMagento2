<?php 


namespace Emthemes\Slideshow\Model\Config;
class Widget2 implements \Magento\Framework\Option\ArrayInterface
{


	public function toOptionArray()
    {
        return [
        ['value' => 'Emthemes_Slideshow::slideshow.phtml', 'label' => __('one')]];
    }
}