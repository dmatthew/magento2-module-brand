<?php

namespace Dmatthew\Brand\Model;

use Dmatthew\Brand\Api\Data\BrandInterface;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;
use Magento\UrlRewrite\Model\UrlFinderInterface;

/**
 * Dmatthew brand
 *
 * @method string getUrlKey()
 * @method Brand setUrlKey(string $urlKey)
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Brand extends \Magento\Catalog\Model\AbstractModel implements IdentityInterface, BrandInterface
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY = 'dmatthew_brand';

    const CACHE_TAG = 'dmatthew_brand';

    /**
     * Brand Store Id
     */
    const STORE_ID = 'store_id';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'dmatthew_brand';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'brand';

    /**
     * Model cache tag for clear cache in after save and after delete
     *
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * URL Model instance
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $_url;

    /**
     * Core data
     *
     * @var \Magento\Framework\Filter\FilterManager
     */
    protected $filter;

    /** @var UrlFinderInterface */
    protected $urlFinder;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $customAttributeFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\UrlInterface $url
     * @param \Magento\Framework\Filter\FilterManager $filter,
     * @param UrlFinderInterface $urlFinder,
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $url,
        \Magento\Framework\Filter\FilterManager $filter,
        UrlFinderInterface $urlFinder,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_url = $url;
        $this->filter = $filter;
        $this->urlFinder = $urlFinder;
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $storeManager,
            $resource,
            $resourceCollection,
            $data
        );
    }

    /**
     * Initialize resource mode
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dmatthew\Brand\Model\ResourceModel\Brand');
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        $identities = [self::CACHE_TAG . '_' . $this->getId()];
        return $identities;
    }

    /**
     * Get brand name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_getData(self::NAME);
    }

    /**
     * Set brand name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Get brand description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->_getData(self::DESCRIPTION);
    }

    /**
     * Set brand description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->_getData(self::CREATED_AT);
    }

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::NAME, $createdAt);
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt()
    {
        return $this->_getData(self::UPDATED_AT);
    }

    /**
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::NAME, $updatedAt);
    }

    /**
     * Retrieve Store Id
     *
     * @return int
     */
    public function getStoreId()
    {
        if ($this->hasData(self::STORE_ID)) {
            return $this->getData(self::STORE_ID);
        }
        return $this->_storeManager->getStore()->getId();
    }

    /**
     * Set brand store id
     *
     * @param int $storeId
     * @return $this
     */
    public function setStoreId($storeId)
    {
        return $this->setData(self::STORE_ID, $storeId);
    }

    /**
     * Retrieve array of store ids for this brand.
     *
     * @return array
     */
    public function getStoreIds()
    {
        if (!$this->hasStoreIds()) {
            $storeIds = [];
            if ($stores = $this->_storeManager->getStores()) {
                $storeIds = array_keys($stores);
            }
            $this->setStoreIds($storeIds);
        }
        return $this->getData('store_ids');
    }

    /**
     * Format URL key from name or defined key
     *
     * @param string $str
     * @return string
     */
    public function formatUrlKey($str)
    {
        return $this->filter->translitUrl($str);
    }

    /**
     * Retrieve URL instance
     *
     * @return \Magento\Framework\UrlInterface
     */
    public function getUrlInstance()
    {
        return $this->_url;
    }

    /**
     * Get brand url.
     *
     * @return string
     */
    public function getUrl()
    {
        $url = $this->_getData('url');
        if ($url === null) {
            if ($this->hasData('request_path') && $this->getRequestPath() != '') {
                $this->setData('url', $this->getUrlInstance()->getDirectUrl($this->getRequestPath()));
                return $this->getData('url');
            }

            $rewrite = $this->urlFinder->findOneByData([
                UrlRewrite::ENTITY_ID => $this->getId(),
                UrlRewrite::ENTITY_TYPE => BrandUrlRewriteGenerator::ENTITY_TYPE,
                UrlRewrite::STORE_ID => $this->getStoreId(),
            ]);
            if ($rewrite) {
                $this->setData('url', $this->getUrlInstance()->getDirectUrl($rewrite->getRequestPath()));
                return $this->getData('url');
            }

            $this->setData('url', $this->getBrandIdUrl());
            return $this->getData('url');
        }
        return $url;
    }

    /**
     * Retrieve brand id URL
     *
     * @return string
     */
    public function getBrandIdUrl()
    {
        $url = $this->getUrlInstance()->getUrl('brand/brand/view', ['id' => $this->getId()]);
        return $url;
    }
}
