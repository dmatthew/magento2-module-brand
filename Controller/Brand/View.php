<?php

namespace Dmatthew\Brand\Controller\Brand;

use Dmatthew\Brand\Api\BrandRepositoryInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Exception\NoSuchEntityException;

class View extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;

    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var BrandRepositoryInterface
     */
    protected $brandRepository;

    /**
     * Constructor
     *
     * @param Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Registry $coreRegistry,
     * @param \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
     * @param PageFactory $resultPageFactory
     * @param BrandRepositoryInterface $brandRepository
     */
    public function __construct(
        Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Registry $coreRegistry,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
        PageFactory $resultPageFactory,
        BrandRepositoryInterface $brandRepository
    ) {
        parent::__construct($context);
        $this->_storeManager = $storeManager;
        $this->_coreRegistry = $coreRegistry;
        $this->_logger = $logger;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->brandRepository = $brandRepository;
    }

    /**
     * Brand view action
     */
    public function execute()
    {
        $brand = $this->_initBrand();
        if ($brand) {
            $page = $this->resultPageFactory->create();
            return $page;
        }
        elseif (!$this->getResponse()->isRedirect()) {
            return $this->resultForwardFactory->create()->forward('noroute');
        }
    }

    /**
     * Initialize requested brand object
     *
     * @return \Dmatthew\Brand\Model\Brand
     */
    protected function _initBrand()
    {
        $this->_eventManager->dispatch(
            'brand_controller_brand_init_before',
            ['controller_action' => $this]
        );

        $brandId = (int) $this->getRequest()->getParam('id');

        if (!$brandId) {
            return false;
        }

        try {
            $brand = $this->brandRepository->get($brandId, $this->_storeManager->getStore()->getId());
        } catch (NoSuchEntityException $e) {
            return false;
        }

        // Register current data and dispatch final events
        $this->_coreRegistry->register('current_brand', $brand);
        $this->_coreRegistry->register('brand', $brand);

        try {
            $this->_eventManager->dispatch(
                'brand_controller_brand_init_after',
                ['brand' => $brand, 'controller_action' => $this]
            );
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->_logger->critical($e);
            return false;
        }

        return $brand;
    }
}