<?php

namespace Dmatthew\Brand\Model\ResourceModel\Brand;


/**
 * Category resource collection
 *
 * @author      Magento Core Team <core@magentocommerce.com>
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
     * Construct
     *
     * @param \Dmatthew\Brand\Model\ResourceModel\Brand\CollectionFactory $brandCollectionFactory
     */
    public function __construct(
        \Dmatthew\Brand\Model\ResourceModel\Brand\CollectionFactory $brandCollectionFactory
    ) {
        $this->_brandCollectionFactory = $brandCollectionFactory;
    }

    /**
     * Init collection and determine table names
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dmatthew\Brand\Model\Brand', 'Dmatthew\Brand\Model\ResourceModel\Brand');
    }

    /**
     * Convert items array to array for select options
     *
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
