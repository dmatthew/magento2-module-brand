<?php

namespace Dmatthew\Brand\Controller\Adminhtml\Brand;

use Magento\Backend\App\Action;

class Validate extends \Dmatthew\Brand\Controller\Adminhtml\Brand
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * Brand validation
     *
     * @param \Magento\Framework\DataObject $response
     */
    protected function _validateBrand($response)
    {
        try {
            $data = $this->getRequest()->getPost('brand');

            /* @var $product \Dmatthew\Brand\Model\Brand */
            $brand = $this->brandFactory->create();
            $brand->setData('_edit_mode', true);
            $storeId = $this->getRequest()->getParam('store');
            if ($storeId) {
                $brand->setStoreId($storeId);
            }
            $brandId = $this->getRequest()->getParam('id');
            if ($brandId) {
                $brand->load($brandId);
            }

            $brand->addData($data);
            $brand->validate();
        } catch (\Magento\Eav\Model\Entity\Attribute\Exception $e) {
            $response->setError(true);
            $response->setAttribute($e->getAttributeCode());
            $response->setMessage($e->getMessage());
        } catch (\Exception $e) {
            $response->setError(true);
            $response->setMessage($e->getMessage());
        }
    }

    public function execute()
    {
        $response = new \Magento\Framework\DataObject();
        $response->setError(false);

        $this->_validateBrand($response);

        $resultJson = $this->resultJsonFactory->create();
        $resultJson->setData($response);
        return $resultJson;
    }
}