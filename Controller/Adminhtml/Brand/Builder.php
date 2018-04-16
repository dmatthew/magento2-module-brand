<?php

namespace Dmatthew\Brand\Controller\Adminhtml\Brand;

use Dmatthew\Brand\Controller\Adminhtml\Brand;
use Dmatthew\Brand\Model\BrandFactory;
use Magento\Cms\Model\Wysiwyg as WysiwygModel;
use Magento\Framework\App\RequestInterface;
use Psr\Log\LoggerInterface as Logger;
use Magento\Framework\Registry;

class Builder
{
    /**
     * @var \Dmatthew\Brand\Model\BrandFactory
     */
    protected $brandFactory;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $wysiwygConfig;

    /**
     * @param BrandFactory $brandFactory
     * @param Logger $logger
     * @param Registry $registry
     * @param WysiwygModel\Config $wysiwygConfig
     */
    public function __construct(
        BrandFactory $brandFactory,
        Logger $logger,
        Registry $registry,
        WysiwygModel\Config $wysiwygConfig
    ) {
        $this->brandFactory = $brandFactory;
        $this->logger = $logger;
        $this->registry = $registry;
        $this->wysiwygConfig = $wysiwygConfig;
    }

    /**
     * Build brand based on user request
     *
     * @param RequestInterface $request
     * @return \Dmatthew\Brand\Model\Brand
     */
    public function build(RequestInterface $request)
    {
        $brandId = (int)$request->getParam('id');
        /** @var $brand \Dmatthew\Brand\Model\Brand */
        $brand = $this->brandFactory->create();
        $brand->setStoreId($request->getParam('store', 0));

        $brand->setData('_edit_mode', true);
        if ($brandId) {
            try {
                $brand->load($brandId);
            } catch (\Exception $e) {
                $this->logger->critical($e);
            }
        }

        $this->registry->register('brand', $brand);
        $this->registry->register('current_brand', $brand);
        $this->wysiwygConfig->setStoreId($request->getParam('store'));
        return $brand;
    }
}
