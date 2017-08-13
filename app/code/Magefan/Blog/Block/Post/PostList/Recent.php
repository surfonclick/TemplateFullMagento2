<?php
/**
 * Copyright © 2015 Ihor Vansach (ihor@magefan.com). All rights reserved.
 * See LICENSE.txt for license details (http://opensource.org/licenses/osl-3.0.php).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magefan\Blog\Block\Post\PostList;

/**
 * Blog sidebar categories block
 */
class Recent extends \Magefan\Blog\Block\Post\PostList\AbstractList
{
    //use \Magefan\Blog\Block\Sidebar\Widget;

    /**
     * @var string
     */
    protected $_widgetKey = 'recent_posts';

    /**
     * @return $this
     */
    public function _construct()
    {
        /*$this->setPageSize(
            (int) $this->_scopeConfig->getValue(
                'mfblog/sidebar/'.$this->_widgetKey.'/posts_per_page',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            )
        );*/
        $this->setPageSize((int) $this->_scopeConfig->getValue(
                'mfblog/sidebar/'.$this->_widgetKey.'/posts_per_page',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            ));
        return parent::_construct();
    }

    /**
     * Retrieve block identities
     * @return array
     */
	public function getIdentities()
    {
        return [\Magento\Cms\Model\Block::CACHE_TAG . '_blog_recent_posts_widget'  ];
    }

	public function short($string, $max = 255)
	{
		if(mb_strlen($string, 'utf-8') >= $max)
		{
			$string = mb_substr($string, 0, $max - 5, 'utf-8').'...';
		} 
		return $string;
	}
}
