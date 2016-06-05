<?php

namespace Dmatthew\Brand\Model\Brand;

use Dmatthew\Brand\Model\Brand;
use Dmatthew\Brand\Model\BrandUrlPathGenerator;
use Dmatthew\Brand\Model\BrandUrlRewriteGenerator;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;
use Magento\UrlRewrite\Service\V1\Data\UrlRewriteFactory;

class CanonicalUrlRewriteGenerator
{
    /** @var BrandUrlPathGenerator */
    protected $brandUrlPathGenerator;

    /** @var UrlRewriteFactory */
    protected $urlRewriteFactory;

    /**
     * @param BrandUrlPathGenerator $brandUrlPathGenerator
     * @param UrlRewriteFactory $urlRewriteFactory
     */
    public function __construct(BrandUrlPathGenerator $brandUrlPathGenerator, UrlRewriteFactory $urlRewriteFactory)
    {
        $this->brandUrlPathGenerator = $brandUrlPathGenerator;
        $this->urlRewriteFactory = $urlRewriteFactory;
    }

    /**
     * Generate list based on store view
     *
     * @param int $storeId
     * @param Brand $brand
     * @return UrlRewrite[]
     */
    public function generate($storeId, Brand $brand)
    {
        return [
            $this->urlRewriteFactory->create()
                ->setEntityType(BrandUrlRewriteGenerator::ENTITY_TYPE)
                ->setEntityId($brand->getId())
                ->setRequestPath($this->brandUrlPathGenerator->getUrlPathWithSuffix($brand, $storeId))
                ->setTargetPath($this->brandUrlPathGenerator->getCanonicalUrlPath($brand))
                ->setStoreId($storeId)
        ];
    }
}
