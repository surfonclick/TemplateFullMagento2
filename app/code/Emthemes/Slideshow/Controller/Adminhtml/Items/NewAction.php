<?php
/**
 * Copyright © 2015 Emthemes. All rights reserved.
 */

namespace Emthemes\Slideshow\Controller\Adminhtml\Items;

class NewAction extends \Emthemes\Slideshow\Controller\Adminhtml\Items
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
