<?php

namespace Dmatthew\Brand\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Dmatthew\Brand\Api\BrandRepositoryInterface;

/**
 * Brand controller
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class Brand extends \Magento\Backend\App\Action
{
    /**
     * @var Brand\Builder
     */
    protected $brandBuilder;

    /** @var BrandRepositoryInterface */
    protected $_brandRepository;

    /** @var \Dmatthew\Brand\Model\BrandFactory */
    protected $brandFactory;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param Brand\Builder $brandBuilder
     * @param BrandRepositoryInterface $brandRepository
     * @param \Dmatthew\Brand\Model\BrandFactory $brandFactory
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Brand\Builder $brandBuilder,
        BrandRepositoryInterface $brandRepository,
        \Dmatthew\Brand\Model\BrandFactory $brandFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->brandBuilder = $brandBuilder;
        $this->_brandRepository = $brandRepository;
        $this->brandFactory = $brandFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Check for is allowed
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Dmatthew_Brand::brands');
    }
}
