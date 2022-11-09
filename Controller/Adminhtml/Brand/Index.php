<?php

namespace Dmatthew\Brand\Controller\Adminhtml\Brand;

class Index extends \Dmatthew\Brand\Controller\Adminhtml\Brand
{
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
