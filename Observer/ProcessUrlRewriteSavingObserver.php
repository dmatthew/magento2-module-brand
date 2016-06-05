<?php

namespace Dmatthew\Brand\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\UrlRewrite\Model\UrlPersistInterface;
use Magento\Framework\Event\ObserverInterface;
use Dmatthew\Brand\Model\BrandUrlRewriteGenerator;

class ProcessUrlRewriteSavingObserver implements ObserverInterface
{
    /**
     * @var \Dmatthew\Brand\Model\BrandUrlRewriteGenerator
     */
    protected $brandUrlRewriteGenerator;

    /**
     * @var UrlPersistInterface
     */
    protected $urlPersist;

    /**
     * @param \Dmatthew\Brand\Model\BrandUrlRewriteGenerator $brandUrlRewriteGenerator
     * @param UrlPersistInterface $urlPersist
     */
    public function __construct(BrandUrlRewriteGenerator $brandUrlRewriteGenerator, UrlPersistInterface $urlPersist)
    {
        $this->brandUrlRewriteGenerator = $brandUrlRewriteGenerator;
        $this->urlPersist = $urlPersist;
    }

    /**
     * Generate urls for UrlRewrite and save it in storage.
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {
        /** @var $brand \Dmatthew\Brand\Model\Brand */
        $brand = $observer->getEvent()->getBrand();
        if ($brand->dataHasChangedFor('url_key')) {
            $urls = $this->brandUrlRewriteGenerator->generate($brand);
            $this->urlPersist->replace($urls);
        }
    }
}
