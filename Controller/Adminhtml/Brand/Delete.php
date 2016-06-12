<?php

namespace Dmatthew\Brand\Controller\Adminhtml\Brand;

use Magento\Framework\Controller\ResultFactory;

class Delete extends \Dmatthew\Brand\Controller\Adminhtml\Brand
{
    /**
     * Delete brand action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $formKeyIsValid = $this->_formKeyValidator->validate($this->getRequest());
        $isPost = $this->getRequest()->isPost();
        if (!$formKeyIsValid || !$isPost) {
            $this->messageManager->addError(__('Brand could not be deleted.'));
            return $resultRedirect->setPath('brand/brand/index');
        }

        $brand = $this->brandBuilder->build($this->getRequest());
        if ($brand->getId()) {
            try {
                $this->_brandRepository->deleteById($brand->getId());
                $this->messageManager->addSuccess(__('You deleted the brand.'));
            } catch (\Exception $exception) {
                $this->messageManager->addError($exception->getMessage());
            }
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('brand/brand/index');
    }
}