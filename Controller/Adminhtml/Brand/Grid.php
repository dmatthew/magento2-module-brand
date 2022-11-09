<?php

namespace Dmatthew\Brand\Controller\Adminhtml\Brand;

class Grid extends \Dmatthew\Brand\Controller\Adminhtml\Brand
{
    /**
     * Brand grid for AJAX request.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
