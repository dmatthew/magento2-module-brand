<?php

namespace Dmatthew\Brand\Block\Brand;

class View extends \Magento\Framework\View\Element\Template
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $brand = $this->getBrand();
        if ($brand) {
            $title = $brand->getName();
            if ($title) {
                $this->pageConfig->getTitle()->set($title);
            }
        }
        
        return $this;
    }

    /**
     * Retrieve current brand model object
     *
     * @return \Dmatthew\Brand\Model\Brand
     */
    public function getBrand()
    {
        if (!$this->hasData('current_brand')) {
            $this->setData('current_brand', $this->_coreRegistry->registry('current_brand'));
        }
        return $this->getData('current_brand');
    }
}