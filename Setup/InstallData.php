<?php

namespace Dmatthew\Brand\Setup;

use Dmatthew\Brand\Setup\BrandSetup;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * Brand setup factory
     *
     * @var BrandSetupFactory
     */
    private $brandSetupFactory;

    /**
     * Init
     *
     * @param BrandSetupFactory $brandSetupFactory
     */
    public function __construct(BrandSetupFactory $brandSetupFactory)
    {
        $this->brandSetupFactory = $brandSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var BrandSetup $brandSetup */
        $brandSetup = $this->brandSetupFactory->create(['setup' => $setup]);

        $brandSetup->installEntities();

        $brandSetup->updateAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'manufacturer',
            'source_model',
            'Dmatthew\Brand\Model\Product\Attribute\Source\Brand'
        );
    }
}
