<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Emthemes\MegaMenu\Model;

use Emthemes\MegaMenu\Api\Data\PageInterface;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Cms Page Model
 *
 * @method \Magento\Cms\Model\ResourceModel\Page _getResource()
 * @method \Magento\Cms\Model\ResourceModel\Page getResource()
 */
class Menu extends \Magento\Framework\Model\AbstractModel// implements IdentityInterface
{
    /**
     * No route page id
     */
    const NOROUTE_PAGE_ID = 'no-route';

    /**#@+
     * Page's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    /**#@-*/

    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'emthemes_megemenu';

    /**
     * @var string
     */
    protected $_cacheTag = 'emthemes_megemenu';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'emthemes_megemenu';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Emthemes\MegaMenu\Model\ResourceModel\Menu');
    }

}
