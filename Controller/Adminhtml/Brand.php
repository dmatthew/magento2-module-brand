<?php

namespace Dmatthew\Brand\Controller\Adminhtml;

use Magento\Backend\App\Action;

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

    /**
     * @param Action\Context $context
     * @param Brand\Builder $brandBuilder
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Brand\Builder $brandBuilder
    ) {
        $this->brandBuilder = $brandBuilder;
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
