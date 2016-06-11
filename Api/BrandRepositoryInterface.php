<?php

namespace Dmatthew\Brand\Api;

/**
 * @api
 */
interface BrandRepositoryInterface
{
    /**
     * Create brand
     *
     * @param \Dmatthew\Brand\Api\Data\BrandInterface $brand
     * @return \Dmatthew\Brand\Api\Data\BrandInterface
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Dmatthew\Brand\Api\Data\BrandInterface $brand);

    /**
     * Get info about brand by brand id
     *
     * @param string $sku
     * @param int|null $storeId
     * @return \Dmatthew\Brand\Api\Data\BrandInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($brandId, $storeId = null);

    /**
     * Delete brand
     *
     * @param \Dmatthew\Brand\Api\Data\BrandInterface $brand
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\Dmatthew\Brand\Api\Data\BrandInterface $brand);

    /**
     * @param string $id
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteById($id);

    /**
     * Get brand list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Dmatthew\Brand\Api\Data\BrandSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}