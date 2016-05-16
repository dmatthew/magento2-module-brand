<?php

namespace Dmatthew\Brand\Model\ResourceModel\Brand;

/**
 * Brand resource collection
 *
 */
class Collection extends \Magento\Catalog\Model\ResourceModel\Collection\AbstractCollection
{
    /**
     * Brand collection factory
     *
     * @var \Dmatthew\Brand\Model\ResourceModel\Brand\CollectionFactory
     */
    protected $_brandCollectionFactory;

    /**
     * @param \Magento\Framework\Data\Collection\EntityFactory $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Eav\Model\Config $eavConfig
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param \Magento\Eav\Model\EntityFactory $eavEntityFactory
     * @param \Magento\Catalog\Model\ResourceModel\Helper $resourceHelper
     * @param \Magento\Framework\Validator\UniversalFactory $universalFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Dmatthew\Brand\Model\ResourceModel\Brand\CollectionFactory $brandCollectionFactory
     * @param \Magento\Framework\DB\Adapter\AdapterInterface $connection
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactory $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Eav\Model\EntityFactory $eavEntityFactory,
        \Magento\Catalog\Model\ResourceModel\Helper $resourceHelper,
        \Magento\Framework\Validator\UniversalFactory $universalFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Dmatthew\Brand\Model\ResourceModel\Brand\CollectionFactory $brandCollectionFactory,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null
    ) {
        $this->_brandCollectionFactory = $brandCollectionFactory;
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $eavConfig,
            $resource,
            $eavEntityFactory,
            $resourceHelper,
            $universalFactory,
            $storeManager,
            $connection
        );
    }

    /**
     * Init collection and determine table names.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dmatthew\Brand\Model\Brand', 'Dmatthew\Brand\Model\ResourceModel\Brand');
    }

    /**
     * Convert items array to array for select options.
     *
     * @param $addEmpty bool
     * @return array
     */
    public function toOptionArray($addEmpty = true)
    {
        /** @var \Dmatthew\Brand\Model\ResourceModel\Brand\Collection $collection */
        $collection = $this->_brandCollectionFactory->create();

        $collection->addAttributeToSelect('name')->load();

        $options = [];

        if ($addEmpty) {
            $options[] = ['label' => __('-- Please Select a Brand --'), 'value' => ''];
        }
        foreach ($collection as $brand) {
            $options[] = ['label' => $brand->getName(), 'value' => $brand->getId()];
        }

        return $options;
    }
}
