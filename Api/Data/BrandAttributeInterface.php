<?php

namespace Dmatthew\Brand\Api\Data;

/**
 * @api
 */
interface BrandAttributeInterface extends \Magento\Catalog\Api\Data\EavAttributeInterface
{
    const ENTITY_TYPE_CODE = 'dmatthew_brand';
}
