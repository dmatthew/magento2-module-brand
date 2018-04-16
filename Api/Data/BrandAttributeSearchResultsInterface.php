<?php

namespace Dmatthew\Brand\Api\Data;

/**
 * @api
 */
interface BrandAttributeSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get attributes list.
     *
     * @return \Dmatthew\Brand\Api\Data\BrandAttributeInterface[]
     */
    public function getItems();

    /**
     * Set attributes list.
     *
     * @param \Dmatthew\Brand\Api\Data\BrandAttributeInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
