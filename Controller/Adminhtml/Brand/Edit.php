<?php

namespace Dmatthew\Brand\Controller\Adminhtml\Brand;

use Dmatthew\Brand\Api\BrandRepositoryInterface;

class Edit extends \Dmatthew\Brand\Controller\Adminhtml\Brand
{
    /**
     * Array of actions which can be processed without secret key validation
     *
     * @var array
     */
    protected $_publicActions = ['edit'];

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
     * Brand edit form
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $brandId = (int) $this->getRequest()->getParam('id');
        $brand = $this->brandBuilder->build($this->getRequest());

        if ($brandId && !$brand->getId()) {
            $this->messageManager->addError(__('This brand no longer exists.'));
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('brand/*/');
        }

        $this->_eventManager->dispatch('dmatthew_brand_edit_action', ['brand' => $brand]);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Dmatthew_Brand::brands');
        $resultPage->getConfig()->getTitle()->prepend(__('Brands'));
        $resultPage->getConfig()->getTitle()->prepend($brand->getName());

        if (!$this->_objectManager->get('Magento\Store\Model\StoreManagerInterface')->isSingleStoreMode()
            &&
            ($switchBlock = $resultPage->getLayout()->getBlock('store_switcher'))
        ) {
            $switchBlock->setDefaultStoreName(__('Default Values'))
                ->setSwitchUrl(
                    $this->getUrl(
                        'brand/*/*',
                        ['_current' => true, 'active_tab' => null, 'tab' => null, 'store' => null]
                    )
                );
        }

        return $resultPage;
    }
}
