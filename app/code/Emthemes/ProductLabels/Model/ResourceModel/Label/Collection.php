<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Emthemes\ProductLabels\Model\ResourceModel\Label;

use \Emthemes\ProductLabels\Model\ResourceModel\AbstractCollection;

/**
 * CMS Block Collection
 */
class Collection extends AbstractCollection
{

	
    
    /**
     * @var string
     */
    protected $_idFieldName = 'block_id';

    /**
     * Perform operations after collection load
     *
     * @return $this
     */
    protected function _afterLoad()
    {
        $this->performAfterLoad('cms_block_store', 'block_id');

        return parent::_afterLoad();
    }

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Emthemes\ProductLabels\Model\Label', 'Emthemes\ProductLabels\Model\ResourceModel\Label');
        $this->_map['fields']['store'] = 'store_table.store';
    }

    /**
     * Returns pairs block_id - title
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->_toOptionArray('label_id', 'title');
    }

    /**
     * Add filter by store
     *
     * @param int|array|\Magento\Store\Model\Store $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        $this->performAddStoreFilter($store, $withAdmin);

        return $this;
    }

    /**
     * Join store relation table if there is store filter
     *
     * @return void
     */
    
    
    protected function _renderFiltersBefore()
    {
        $this->joinStoreRelationTable('emthemes_product_label_store', 'label_id');
        //echo $this->getSelect();die;
    }
    
    
}
