<?php

namespace Dmatthew\Brand\Api;

/**
 * Interface BrandAttributeRepositoryInterface must be implemented in new model.
 * @api
 */
interface BrandAttributeRepositoryInterface extends \Magento\Framework\Api\MetadataServiceInterface
{
    /**
     * Retrieve all attributes for entity type
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Dmatthew\Brand\Api\Data\BrandAttributeSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Retrieve specific attribute
     *
     * @param string $attributeCode
     * @return \Dmatthew\Brand\Api\Data\BrandAttributeInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($attributeCode);

    /**
     * Save attribute data
     *
     * @param \Dmatthew\Brand\Api\Data\BrandAttributeInterface $attribute
     * @return \Dmatthew\Brand\Api\Data\BrandAttributeInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function save(\Dmatthew\Brand\Api\Data\BrandAttributeInterface $attribute);

    /**
     * Delete Attribute
     *
     * @param \Dmatthew\Brand\Api\Data\BrandAttributeInterface $attribute
     * @return bool True if the entity was deleted (always true)
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function delete(\Dmatthew\Brand\Api\Data\BrandAttributeInterface $attribute);

    /**
     * Delete Attribute by id
     *
     * @param string $attributeCode
     * @return bool
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($attributeCode);
}
