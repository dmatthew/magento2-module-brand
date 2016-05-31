<?php

namespace Dmatthew\Brand\Model;

use Dmatthew\Brand\Model\Brand;
use Dmatthew\Brand\Model\Brand\CanonicalUrlRewriteGenerator;
use Dmatthew\Brand\Model\Brand\CurrentUrlRewritesRegenerator;
use Magento\CatalogUrlRewrite\Service\V1\StoreViewService;
use Magento\Store\Model\Store;

class BrandUrlRewriteGenerator
{
    /**
     * Entity type code
     */
    const ENTITY_TYPE = 'dmatthew_brand';

    /** @var \Magento\CatalogUrlRewrite\Service\V1\StoreViewService */
    protected $storeViewService;

    /** @var \Dmatthew\Brand\Model\Brand */
    protected $brand;

    /** @var \Dmatthew\Brand\Model\Brand\CurrentUrlRewritesRegenerator */
    protected $currentUrlRewritesRegenerator;

    /** @var \Dmatthew\Brand\Model\Brand\CanonicalUrlRewriteGenerator */
    protected $canonicalUrlRewriteGenerator;

    /** @var \Magento\CatalogUrlRewrite\Model\ObjectRegistryFactory */
    protected $objectRegistryFactory;

    /** @var \Magento\Store\Model\StoreManagerInterface */
    protected $storeManager;

    /**
     * @param \Dmatthew\Brand\Model\Brand\CanonicalUrlRewriteGenerator $canonicalUrlRewriteGenerator
     * @param \Dmatthew\Brand\Model\Brand\CurrentUrlRewritesRegenerator $currentUrlRewritesRegenerator
     * @param \Magento\CatalogUrlRewrite\Model\ObjectRegistryFactory $objectRegistryFactory
     * @param \Magento\CatalogUrlRewrite\Service\V1\StoreViewService $storeViewService
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        CanonicalUrlRewriteGenerator $canonicalUrlRewriteGenerator,
        CurrentUrlRewritesRegenerator $currentUrlRewritesRegenerator,
        ObjectRegistryFactory $objectRegistryFactory,
        StoreViewService $storeViewService,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->canonicalUrlRewriteGenerator = $canonicalUrlRewriteGenerator;
        $this->currentUrlRewritesRegenerator = $currentUrlRewritesRegenerator;
        $this->objectRegistryFactory = $objectRegistryFactory;
        $this->storeViewService = $storeViewService;
        $this->storeManager = $storeManager;
    }

    /**
     * Generate brand url rewrites
     *
     * @param \Dmatthew\Brand\Model\Brand $brand
     * @return \Magento\UrlRewrite\Service\V1\Data\UrlRewrite[]
     */
    public function generate(Brand $brand)
    {
        $this->brand = $brand;
        $storeId = $this->brand->getStoreId();

        $urls = $this->isGlobalScope($storeId)
            ? $this->generateForGlobalScope()
            : $this->generateForSpecificStoreView($storeId);

        $this->brand = null;
        return $urls;
    }

    /**
     * Check is global scope
     *
     * @param int|null $storeId
     * @return bool
     */
    protected function isGlobalScope($storeId)
    {
        return null === $storeId || $storeId == Store::DEFAULT_STORE_ID;
    }

    /**
     * Generate list of urls for global scope
     *
     * @return \Magento\UrlRewrite\Service\V1\Data\UrlRewrite[]
     */
    protected function generateForGlobalScope()
    {
        $urls = [];
        $brandId = $this->brand->getId();
        foreach ($this->brand->getStoreIds() as $id) {
            if (!$this->isGlobalScope($id)
                && !$this->storeViewService->doesEntityHaveOverriddenUrlKeyForStore($id, $brandId, Brand::ENTITY)
            ) {
                $urls = array_merge($urls, $this->generateForSpecificStoreView($id));
            }
        }
        return $urls;
    }

    /**
     * Generate list of urls for specific store view
     *
     * @param int $storeId
     * @return \Magento\UrlRewrite\Service\V1\Data\UrlRewrite[]
     */
    protected function generateForSpecificStoreView($storeId)
    {
        /**
         * @var $urls \Magento\UrlRewrite\Service\V1\Data\UrlRewrite[]
         */
        $urls = array_merge(
            $this->canonicalUrlRewriteGenerator->generate($storeId, $this->brand),
            $this->currentUrlRewritesRegenerator->generate($storeId, $this->brand)
        );

        /* Reduce duplicates. Last wins */
        $result = [];
        foreach ($urls as $url) {
            $result[$url->getTargetPath() . '-' . $url->getStoreId()] = $url;
        }
        return $result;
    }
}
