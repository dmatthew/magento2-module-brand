<?php

namespace Dmatthew\Brand\Test\Unit\Model\ResourceModel\Brand;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Dmatthew\Brand\Model\Product\Attribute\Source\Brand
     */
    private $model;

    /**
     * @var \Dmatthew\Brand\Model\ResourceModel\Brand\Collection|MockObject
     */
    private $brandCollection;

    /**
     * @var \Dmatthew\Brand\Model\ResourceModel\Brand|MockObject
     */
    private $brand;

    protected function setUp()
    {
        $this->brandCollection = $this->getMockBuilder('Dmatthew\Brand\Model\ResourceModel\Brand\Collection')
            ->disableOriginalConstructor()
            ->getMock();

        $this->brand = $this->getMockBuilder('Dmatthew\Brand\Model\ResourceModel\Brand')
            ->setMethods(['getName', 'getId'])
            ->disableOriginalConstructor()
            ->getMock();

        /**
         * @var \Dmatthew\Brand\Model\ResourceModel\Brand\CollectionFactory|MockObject $brandCollectionFactory
         */
        $brandCollectionFactory =
            $this->getMockBuilder('Dmatthew\Brand\Model\ResourceModel\Brand\CollectionFactory')
                ->setMethods(['create'])
                ->disableOriginalConstructor()
                ->getMock();
        $brandCollectionFactory->expects($this->any())->method('create')->will(
            $this->returnValue($this->brandCollection)
        );

        $helper = new ObjectManager($this);
        $this->model = $helper->getObject('Dmatthew\Brand\Model\Product\Attribute\Source\Brand', [
            'brandCollectionFactory' => $brandCollectionFactory
        ]);
    }

    public function testToOptionArray()
    {
        $expect = [
            ['label' => '-- Please Select a Brand --', 'value' => ''],
            ['label' => 'name', 'value' => 3],
        ];

        $this->brandCollection->expects($this->once())->method('addAttributeToSelect')->with(
            $this->equalTo('name')
        )->will($this->returnValue($this->brandCollection));
        $this->brandCollection->expects($this->once())->method('load');
        $this->brandCollection->expects($this->any())->method('getIterator')->will(
            $this->returnValue(new \ArrayIterator([$this->brand]))
        );

        $this->brand->expects($this->once())->method('getName')->will($this->returnValue('name'));
        $this->brand->expects($this->once())->method('getId')->will($this->returnValue(3));

        $this->assertEquals($expect, $this->model->toOptionArray());
    }
}
