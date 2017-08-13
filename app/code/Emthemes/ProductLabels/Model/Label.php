<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Emthemes\ProductLabels\Model;

use Magento\Cms\Api\Data\BlockInterface;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * CMS block model
 *
 * @method \Magento\Cms\Model\ResourceModel\Block _getResource()
 * @method \Magento\Cms\Model\ResourceModel\Block getResource()
 */
class Label extends \Magento\Rule\Model\AbstractModel//\Magento\Framework\Model\AbstractModel implements BlockInterface, IdentityInterface
{
    /**
     * CMS block cache tag
     */
    const CACHE_TAG = 'emthemes_productlabels';

    /**
     * @var string
     */
    protected $_cacheTag = 'emthemes_productlabels';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'emthemes_productlabels';

	public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\CatalogRule\Model\Rule\Condition\CombineFactory $combineFactory,
        \Magento\CatalogRule\Model\Rule\Action\CollectionFactory $actionCollectionFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\Model\ResourceModel\Iterator $resourceIterator,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\CatalogRule\Helper\Data $catalogRuleData,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypesList,
        \Magento\Framework\Stdlib\DateTime $dateTime,
        \Magento\CatalogRule\Model\Indexer\Rule\RuleProductProcessor $ruleProductProcessor,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $relatedCacheTypes = [],
        array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_storeManager = $storeManager;
        $this->_combineFactory = $combineFactory;
        $this->_actionCollectionFactory = $actionCollectionFactory;
        $this->_productFactory = $productFactory;
        $this->_resourceIterator = $resourceIterator;
        $this->_customerSession = $customerSession;
        $this->_catalogRuleData = $catalogRuleData;
        $this->_cacheTypesList = $cacheTypesList;
        $this->_relatedCacheTypes = $relatedCacheTypes;
        $this->dateTime = $dateTime;
        $this->_ruleProductProcessor = $ruleProductProcessor;
        parent::__construct($context, $registry, $formFactory, $localeDate, $resource, $resourceCollection, $data);
    }	
	
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Emthemes\ProductLabels\Model\ResourceModel\Label');
    }

    public function getConditionsInstance()
    {
        return $this->_combineFactory->create();
    }
    
    public function getActionsInstance()
    {
        return $this->_actionCollectionFactory->create();
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getIdentifier()];
    }

    /**
     * Retrieve block id
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData('label_id');
    }

    /**
     * Retrieve block identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return (string)$this->getData(self::IDENTIFIER);
    }

    /**
     * Retrieve block content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Retrieve block creation time
     *
     * @return string
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * Retrieve block update time
     *
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Is active
     *
     * @return bool
     */
    public function isActive()
    {
        return (bool)$this->getData(self::IS_ACTIVE);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return BlockInterface
     */
    public function setId($id)
    {
        return $this->setData('label_id', $id);
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     * @return BlockInterface
     */
    public function setIdentifier($identifier)
    {
        return $this->setData(self::IDENTIFIER, $identifier);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return BlockInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return BlockInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return BlockInterface
     */
    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return BlockInterface
     */
    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    /**
     * Set is active
     *
     * @param bool|int $isActive
     * @return BlockInterface
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Receive page store ids
     *
     * @return int[]
     */
    public function getStores()
    {
        return $this->hasData('stores') ? $this->getData('stores') : $this->getData('store');
    }
    
    public function getDefaultValue($attributeCode)
    {
    	$default = $this->getData('default_values');
    	return $default[$attributeCode];
    }
    
    public function getExistsStoreValueFlag($attributeCode)
    {
    	$default = $this->getData('store_values');
    	
    	return isset($default[$attributeCode]) && ($default[$attributeCode] !== NULL);
    }
}
