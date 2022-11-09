<?php

namespace Dmatthew\Brand\Model\Product\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\Data\OptionSourceInterface;

class Brand extends AbstractSource implements OptionSourceInterface
{
    /**
     * @var \Magento\Framework\App\Cache\Type\Config
     */
    protected $_configCacheType;

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Brand factory
     *
     * @var \Dmatthew\Brand\Model\BrandFactory
     */
    protected $_brandFactory;

    /**
     * Construct
     *
     * @param \Dmatthew\Brand\Model\BrandFactory $brandFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\Cache\Type\Config $configCacheType
     */
    public function __construct(
        \Dmatthew\Brand\Model\BrandFactory $brandFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Cache\Type\Config $configCacheType
    ) {
        $this->_brandFactory = $brandFactory;
        $this->_storeManager = $storeManager;
        $this->_configCacheType = $configCacheType;
    }

    /**
     * Get list of all available brands
     *
     * @return array
     */
    public function getAllOptions()
    {
        $cacheKey = 'BRAND_SELECT_STORE_' . $this->_storeManager->getStore()->getCode();
        if ($cache = $this->_configCacheType->load($cacheKey)) {
            $options = unserialize($cache);
        } else {
            $collection = $this->_brandFactory->create()->getResourceCollection()->load();
            $options = $collection->toOptionArray();
            $this->_configCacheType->save(serialize($options), $cacheKey);
        }
        return $options;
    }
}