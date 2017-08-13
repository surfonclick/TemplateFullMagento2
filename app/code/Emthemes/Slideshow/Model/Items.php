<?php
/**
 * Copyright © 2015 Emthemes. All rights reserved.
 */

namespace Emthemes\Slideshow\Model;

class Items extends \Magento\Framework\Model\AbstractModel
{

    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('Emthemes\Slideshow\Model\Resource\Items');
    }
	

}
