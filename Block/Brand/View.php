<?php

namespace Dmatthew\Brand\Block\Brand;

class View extends \Magento\Framework\View\Element\Template
{
    /**
     * Magento string lib
     *
     * @var \Magento\Framework\Stdlib\StringUtils
     */
    protected $string;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Stdlib\StringUtils $string
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Stdlib\StringUtils $string,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->string = $string;
        parent::__construct($context, $data);
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $brand = $this->getBrand();
        if ($brand) {

            $metaTitle = $brand->getMetaTitle();
            if ($metaTitle) {
                $this->pageConfig->getTitle()->set($metaTitle);
            }

            $metaDescription = $brand->getMetaDescription();
            if ($metaDescription) {
                $this->pageConfig->setDescription($metaDescription);
            } else {
                $this->pageConfig->setDescription($this->string->substr($brand->getDescription(), 0, 255));
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