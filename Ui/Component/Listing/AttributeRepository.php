<?php

namespace Dmatthew\Brand\Ui\Component\Listing;

class AttributeRepository
{
    /**
     * @var null|\Dmatthew\Brand\Api\Data\BrandAttributeInterface[]
     */
    protected $attributes;

    /** @var \Magento\Framework\Api\SearchCriteriaBuilder */
    protected $searchCriteriaBuilder;

    /**
     * @param \Dmatthew\Brand\Api\BrandAttributeRepositoryInterface $attributeRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        \Dmatthew\Brand\Api\BrandAttributeRepositoryInterface $attributeRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->brandAttributeRepository = $attributeRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @return \Dmatthew\Brand\Api\Data\BrandAttributeInterface[]
     */
    public function getList()
    {
        if (null == $this->attributes) {
            $this->attributes = $this->brandAttributeRepository
                ->getList($this->buildSearchCriteria())
                ->getItems();
        }
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    protected function buildSearchCriteria()
    {
        return $this->searchCriteriaBuilder->create();
    }
}
