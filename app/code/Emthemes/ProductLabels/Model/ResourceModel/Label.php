<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Emthemes\ProductLabels\Model\ResourceModel;

use Magento\Framework\App\Filesystem\DirectoryList;

class Label extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Construct
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param string $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Filesystem\Driver\File $fileDriver,
        \Magento\Framework\Filesystem $fileSystem,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->fileSystem = $fileSystem;
        $this->fileDriver = $fileDriver;
        $this->_storeManager = $storeManager;
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('emthemes_product_label', 'label_id');
    }

    public function getBaseDir()
    {
        return $this->fileSystem->getDirectoryWrite(DirectoryList::MEDIA)->getAbsolutePath('productlabel');
    }
    
    protected function _beforeDelete(\Magento\Framework\Model\AbstractModel $object)
    {
    	//delete all image
    	$connection = $this->getConnection();

        $select = $connection->select()->from(
            $this->getTable('emthemes_product_label_store'),
            '*'
        )->where(
            'label_id = ?', $object->getId()
        );

        $labels = $connection->fetchAll($select);
        foreach($labels as $label){
        	$file = $this->getBaseDir().'/'.$label['image'];
        	if($this->fileDriver->isFile($file)){
	    		$this->fileDriver->deleteFile($file);
	    	}
	    	$file = $this->getBaseDir().'/'.$label['background'];
	    	if($this->fileDriver->isFile($file)){
	    		$this->fileDriver->deleteFile($file);
	    	}
        }
    	//end delete
        $condition = ['label_id = ?' => (int)$object->getId()];

        $this->getConnection()->delete($this->getTable('emthemes_product_label_store'), $condition);

        return parent::_beforeDelete($object);
    }

    /**
     * Perform operations before object save
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        /*if (!$this->getIsUniqueBlockToStores($object)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('A block identifier with the same properties already exists in the selected store.')
            );
        }*/
        return $this;
    }

    /**
     * Perform operations after object save
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
    	$table = $this->getTable('emthemes_product_label_store');
    	if($object->getStore() == ''){
    		$object->setStore(\Magento\Store\Model\Store::DEFAULT_STORE_ID);
    	}

        if($this->lookupStoreId($object)){//exist update
        	$insert = [];
        	$data = $object->getData();
        	unset($data['default_values']);
        	unset($data['store_values']);
        	unset($data['conditions']);
        	unset($data['form_key']);
        	unset($data['title']);
        	unset($data['is_active']);
        	unset($data['conditions_serialized']);
        	unset($data['actions_serialized']);
        	unset($data['use_default']);
        	if(isset($data['use_default'])){
		    	foreach(array_values($data['use_default']) as $col){
		    		$insert[$col] = "NULL";
		    	}
        	}
        	
        	
        	unset($data['use_default']);
        	$insert = array_merge($data, $insert);
        	
        	$columns = array_keys($insert);
        	$values = [];
        	foreach(array_values($insert) as $val){
        		if($val != 'NULL'){
        			$values[] = '"'.$val.'"';
        		}else{
        			$values[] = $val;
        		}
        	}
            $columns_not_use= array ("limit","page","in_products","entity_id","type","set_name","chooser_sku","chooser_name");
        	$set = [];
        	for($i = 0; $i < count($columns); $i++){
                if (!in_array($columns[$i], $columns_not_use)){
                    $set[] = $columns[$i].'='.$values[$i];
                }
        	}
        	$where = sprintf('label_id = %s AND store = %s ', $object->getId(),$object->getStore());


        	$query = sprintf('UPDATE %s SET %s WHERE %s', $table, implode(',',$set), $where);
            $this->getConnection()->query($query);
        }else{//not exist insert
        	$insert = [];
        	$data = $object->getData();
        	
        	unset($data['default_values']);
        	unset($data['store_values']);
        	unset($data['conditions']);
        	unset($data['form_key']);
        	unset($data['title']);
        	unset($data['is_active']);
        	unset($data['conditions_serialized']);
        	unset($data['actions_serialized']);
        	
        	if(isset($data['use_default'])){
		    	foreach(array_values($data['use_default']) as $col){
		    		$insert[$col] = "NULL";
		    	}
        	}
        	$insert = array_merge($data, $insert);
        	unset($insert['use_default']);
        	$columns = implode(',',array_keys($insert));
        	$values = [];
        	foreach(array_values($insert) as $val){
        		if($val != 'NULL'){
        			$values[] = '"'.$val.'"';
        		}else{
        			$values[] = $val;
        		}
        	}
        	$values = implode(',',$values);
        	
        	$query = sprintf('INSERT INTO %s(%s) VALUES(%s)', $table, $columns, $values);
            $this->getConnection()->query($query);
        }
        return parent::_afterSave($object);
    }

    /**
     * Load an object using 'identifier' field if there's no field specified and value is not numeric
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @param mixed $value
     * @param string $field
     * @return $this
     */
    public function load(\Magento\Framework\Model\AbstractModel $object, $value, $field = null)
    {
        if (!is_numeric($value) && $field === null) {
            $field = 'identifier';
        }

        return parent::load($object, $value, $field);
    }

    /**
     * Perform operations after object load
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _afterLoad(\Magento\Framework\Model\AbstractModel $object)
    {
        if ($object->getId()) {
        	
            $stores = $this->getStoresValues($object);
            $defaultValues = end($stores);
            $storeValues = reset($stores);
            $data = array_merge(array_filter($defaultValues),array_filter($storeValues));
            $object->setData($data);
            $object->setData('default_values', end($stores));
            $object->setStore($this->_store_choosen);
            if($object->getStore() == \Magento\Store\Model\Store::DEFAULT_STORE_ID){
            	$object->setData('store_values',$defaultValues);
            }
            else{ 
            	if($storeValues['store'] != \Magento\Store\Model\Store::DEFAULT_STORE_ID){
            		$object->setData('store_values',$storeValues);
            	}else{//store don't change default value
            		$object->setData('store_values',[]);
            	}
            }
            
        }

        return parent::_afterLoad($object);
    }
    
    protected function getStoresValues($object)
    {
    	$connection = $this->getConnection();

        $select = $connection->select()->from(
            ['pl' => $this->getTable('emthemes_product_label')],
            '*'
        )->where(
            'pl.label_id = ?',
            $object->getId()
        );
        
        $stores = [$object->getStore(),\Magento\Store\Model\Store::DEFAULT_STORE_ID];

        $select->join(
            ['pls' => $this->getTable('emthemes_product_label_store')],
            'pl.label_id = pls.label_id',
            ['*']
        )/*->where(
            'is_active = ?',
            1
        )*/->where(
            'pls.store in (?)',
            $stores
        )->order(
            'store DESC'
        )->limit(
            2
        );

        return $connection->fetchAll($select);
    }

    /**
     * Retrieve select object for load object data
     *
     * @param string $field
     * @param mixed $value
     * @param \Emthemes\ProductLabels\Model\Block $object
     * @return \Magento\Framework\DB\Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
    	$this->_store_choosen = $object->getStore();
        $select = parent::_getLoadSelect($field, $value, $object);

        if ($object->getStore() || 1) {
            $stores = [(int)$object->getStore(), \Magento\Store\Model\Store::DEFAULT_STORE_ID];

            $select->join(
                ['pls' => $this->getTable('emthemes_product_label_store')],
                $this->getMainTable() . '.label_id = pls.label_id',
                ['*']
            )/*->where(
                'is_active = ?',
                1
            )*/->where(
                'pls.store in (?)',
                $stores
            )->order(
                'store DESC'
            )->limit(
                1
            );
        }

        return $select;
    }

    /**
     * Check for unique of identifier of block to selected store(s).
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getIsUniqueBlockToStores(\Magento\Framework\Model\AbstractModel $object)
    {
        if ($this->_storeManager->hasSingleStore()) {
            $stores = [\Magento\Store\Model\Store::DEFAULT_STORE_ID];
        } else {
            $stores = (array)$object->getData('stores');
        }

        $select = $this->getConnection()->select()->from(
            ['cb' => $this->getMainTable()]
        )->join(
            ['cbs' => $this->getTable('cms_block_store')],
            'cb.block_id = cbs.block_id',
            []
        )->where(
            'cb.identifier = ?',
            $object->getData('identifier')
        )->where(
            'cbs.store IN (?)',
            $stores
        );

        if ($object->getId()) {
            $select->where('cb.block_id <> ?', $object->getId());
        }

        if ($this->getConnection()->fetchRow($select)) {
            return false;
        }

        return true;
    }

    /**
     * Get store ids to which specified item is assigned
     *
     * @param int $id
     * @return array
     */
    public function lookupStoreId($object)
    {
        $connection = $this->getConnection();

        $select = $connection->select()->from(
            $this->getTable('emthemes_product_label_store'),
            'label_id'
        )->where(
            'label_id = ?', $object->getId()
        )->where(
            'store = ?', $object->getStore()
        );

        return $connection->fetchCol($select);
    }
}
