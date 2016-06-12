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

    /**
     * @param Action\Context $context
     * @param Brand\Builder $brandBuilder
     * @param BrandRepositoryInterface $brandRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Brand\Builder $brandBuilder,
        BrandRepositoryInterface $brandRepository
    ) {
        $this->brandBuilder = $brandBuilder;
        $this->_brandRepository = $brandRepository;
        parent::__construct($context);
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
