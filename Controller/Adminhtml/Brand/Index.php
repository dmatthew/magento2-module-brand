<?php

namespace Dmatthew\Brand\Controller\Adminhtml\Brand;

use Dmatthew\Brand\Api\BrandRepositoryInterface;

class Index extends \Dmatthew\Brand\Controller\Adminhtml\Brand
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Dmatthew\Brand\Controller\Adminhtml\Brand\Builder $brandBuilder
     * @param BrandRepositoryInterface $brandRepository
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Dmatthew\Brand\Controller\Adminhtml\Brand\Builder $brandBuilder,
        BrandRepositoryInterface $brandRepository,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context, $brandBuilder, $brandRepository);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Brand list page
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Dmatthew_Brand::brands');
        $resultPage->getConfig()->getTitle()->prepend(__('Brand'));
        return $resultPage;
    }
}
