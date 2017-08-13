<?php
 
namespace Emthemes\Slideshow\Model;
 
class Select extends \Magento\Config\Model\Config\Backend\Image
{
    /**
     * The tail part of directory path for uploading
     */
    
	const STATUS_ENABLED = 1;
	const STATUS_DISABLED = 0;
 
  	public function getAvailableStatuses() {
		return array(self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled'));
	}
	public function getNumber(){
		return array("0","1","2","3","4","5");
	}
}