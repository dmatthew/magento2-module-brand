<?php

namespace Dmatthew\Brand\Controller\Adminhtml\Brand;

use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Controller\RegistryConstants;
use Magento\Customer\Model\EmailNotificationInterface;
use Magento\Customer\Model\Metadata\Form;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Dmatthew\Brand\Controller\Adminhtml\Brand
{
    /**
     * Save brand action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        die('Not Implemented yet!');
        $returnToEdit = false;
        $originalRequestData = $this->getRequest()->getPostValue();

        $brandId = $this->getCurrentBrandId();

        if ($originalRequestData) {
            try {
                // optional fields might be set in request for future processing by observers in other modules
                $brandData = $this->_extractCustomerData();

                if ($brandId) {
                    $currentBrand = $this->_brandRepository->getById($brandId);
                    $customerData = array_merge(
                        $this->brandMapper->toFlatArray($currentBrand),
                        $brandData
                    );
                    $brandData['id'] = $brandId;
                }

                /** @var CustomerInterface $customer */
                $brand = $this->brandDataFactory->create();
                $this->dataObjectHelper->populateWithArray(
                    $brand,
                    $customerData,
                    \Dmatthew\Brand\Api\Data\BrandInterface::class
                );

                $this->_eventManager->dispatch(
                    'adminhtml_brand_prepare_save',
                    ['brand' => $brand, 'request' => $this->getRequest()]
                );

                // Save brand
                if ($brandId) {
                    $this->_brandRepository->save($brand);
                } else {
                    $customer = $this->customerAccountManagement->createAccount($customer);
                    $brandId = $brand->getId();
                }

                // After save
                $this->_eventManager->dispatch(
                    'adminhtml_brand_save_after',
                    ['brand' => $brand, 'request' => $this->getRequest()]
                );
                $this->_getSession()->unsCustomerFormData();
                // Done Saving brand, finish save action
                $this->_coreRegistry->register(RegistryConstants::CURRENT_CUSTOMER_ID, $customerId);
                $this->messageManager->addSuccessMessage(__('You saved the brand.'));
                $returnToEdit = (bool)$this->getRequest()->getParam('back', false);
            } catch (\Magento\Framework\Validator\Exception $exception) {
                $messages = $exception->getMessages();
                if (empty($messages)) {
                    $messages = $exception->getMessage();
                }
                $this->_addSessionErrorMessages($messages);
                $this->_getSession()->setCustomerFormData($originalRequestData);
                $returnToEdit = true;
            } catch (LocalizedException $exception) {
                $this->_addSessionErrorMessages($exception->getMessage());
                $this->_getSession()->setCustomerFormData($originalRequestData);
                $returnToEdit = true;
            } catch (\Exception $exception) {
                $this->messageManager->addExceptionMessage($exception, __('Something went wrong while saving the brand.'));
                $this->_getSession()->setCustomerFormData($originalRequestData);
                $returnToEdit = true;
            }
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($returnToEdit) {
            if ($brandId) {
                $resultRedirect->setPath(
                    'brand/*/edit',
                    ['id' => $brandId, '_current' => true]
                );
            } else {
                $resultRedirect->setPath(
                    'brand/*/new',
                    ['_current' => true]
                );
            }
        } else {
            $resultRedirect->setPath('brand/brand/index');
        }
        return $resultRedirect;
    }

    /**
     * Get metadata form
     *
     * @param string $entityType
     * @param string $formCode
     * @param string $scope
     * @return Form
     */
    private function getMetadataForm($entityType, $formCode, $scope)
    {
        $attributeValues = [];

        if ($entityType == CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER) {
            $customerId = $this->getCurrentCustomerId();
            if ($customerId) {
                $customer = $this->_customerRepository->getById($customerId);
                $attributeValues = $this->customerMapper->toFlatArray($customer);
            }
        }

        if ($entityType == AddressMetadataInterface::ENTITY_TYPE_ADDRESS) {
            $scopeData = explode('/', $scope);
            if (isset($scopeData[1]) && is_numeric($scopeData[1])) {
                $customerAddress = $this->addressRepository->getById($scopeData[1]);
                $attributeValues = $this->addressMapper->toFlatArray($customerAddress);
            }
        }

        $metadataForm = $this->_formFactory->create(
            $entityType,
            $formCode,
            $attributeValues,
            false,
            Form::DONT_IGNORE_INVISIBLE
        );

        return $metadataForm;
    }

    /**
     * Retrieve current customer ID
     *
     * @return int
     */
    private function getCurrentCustomerId()
    {
        $originalRequestData = $this->getRequest()->getPostValue(CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER);

        $customerId = isset($originalRequestData['entity_id'])
            ? $originalRequestData['entity_id']
            : null;

        return $customerId;
    }
}
