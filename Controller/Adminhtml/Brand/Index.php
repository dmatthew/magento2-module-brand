<?php

namespace Dmatthew\Brand\Controller\Adminhtml\Brand;

class Index extends \Dmatthew\Brand\Controller\Adminhtml\Brand
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Dmatthew\Brand\Controller\Adminhtml\Brand\Builder $brandBuilder
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Dmatthew\Brand\Controller\Adminhtml\Brand\Builder $brandBuilder,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context, $brandBuilder);
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
