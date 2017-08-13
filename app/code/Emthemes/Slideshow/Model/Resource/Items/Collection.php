<?php
/**
 * Copyright © 2015 Emthemes. All rights reserved.
 */

namespace Emthemes\Slideshow\Model\Resource\Items;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Emthemes\Slideshow\Model\Items', 'Emthemes\Slideshow\Model\Resource\Items');
    }

	
	

}
