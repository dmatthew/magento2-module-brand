<?php

namespace Dmatthew\Brand\Model\ResourceModel;

use Magento\Catalog\Model\ResourceModel\AbstractResource;

/**
 * Product entity resource model
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Brand extends AbstractResource
{
    /**
     * Entity type getter and lazy loader
     *
     * @return \Magento\Eav\Model\Entity\Type
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getEntityType()
    {
        if (empty($this->_type)) {
            $this->setType(\Dmatthew\Brand\Model\Brand::ENTITY);
        }
        return parent::getEntityType();
    }
}