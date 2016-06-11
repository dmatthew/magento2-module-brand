<?php

namespace Dmatthew\Brand\Api\Data;

/**
 * @api
 */
interface BrandSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get brands list.
     *
     * @return \Dmatthew\Brand\Api\Data\BrandInterface[]
     */
    public function getItems();

    /**
     * Set brands list.
     *
     * @param \Dmatthew\Brand\Api\Data\BrandInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
