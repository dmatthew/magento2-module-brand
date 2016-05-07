<?php

namespace Dmatthew\Brand\Test\Unit\Setup;

class BrandSetupTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Dmatthew\Brand\Setup\BrandSetup */
    protected $unit;

    protected function setUp()
    {
        $this->unit = (new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this))->getObject(
            'Dmatthew\Brand\Setup\BrandSetup'
        );
    }

    public function testGetDefaultEntitiesContainAllAttributes()
    {
        $defaultEntities = $this->unit->getDefaultEntities();

        $this->assertEquals(
            [
                'name',
            ],
            array_keys($defaultEntities['dmatthew_brand']['attributes'])
        );
    }
}
