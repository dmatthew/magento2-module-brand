<?php

namespace Dmatthew\Brand\Test\Unit\Model;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class BrandRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $brandMock;

    /**
     * @var \Dmatthew\Brand\Model\BrandRepository
     */
    protected $brandRepository;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $resourceModelMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $brandFactoryMock;

    /**
     * @var \Magento\Framework\TestFramework\Unit\Helper\ObjectManager
     */
    protected $objectManager;

    /**
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function setUp()
    {
        $this->brandFactoryMock = $this->getMock('Dmatthew\Brand\Model\BrandFactory', ['create'], [], '', false);
        $this->brandMock = $this->getMock('Dmatthew\Brand\Model\Brand', [], [], '', false);

        $this->resourceModelMock = $this->getMock('\Dmatthew\Brand\Model\ResourceModel\Brand', [], [], '', false);
        $this->objectManager = new ObjectManager($this);

        $this->brandRepository = $this->objectManager->getObject(
            'Dmatthew\Brand\Model\BrandRepository',
            [
                'brandFactory' => $this->brandFactoryMock,
                'resourceModel' => $this->resourceModelMock,
            ]
        );
    }

    public function testSave()
    {
        $this->resourceModelMock->expects($this->once())
            ->method('save')
            ->with($this->brandMock)
            ->willReturnSelf();
        $this->assertEquals($this->brandMock, $this->brandRepository->save($this->brandMock));
    }

    public function testGet()
    {
        $id = '7';
        $this->brandFactoryMock->expects($this->once())->method('create')
            ->will($this->returnValue($this->brandMock));
        $this->brandMock->expects($this->once())->method('getId')->willReturn('7');
        $this->assertSame($this->brandMock, $this->brandRepository->get($id));
    }

    public function testGetWithSetStoreId()
    {
        $id = '7';
        $storeId = 5;
        $this->brandFactoryMock->expects($this->once())->method('create')->willReturn($this->brandMock);
        $this->brandMock->expects($this->once())->method('setStoreId')->with($storeId);
        $this->brandMock->expects($this->once())->method('load')->with($id);
        $this->brandMock->expects($this->once())->method('getId')->willReturn($id);
        $this->assertSame($this->brandMock, $this->brandRepository->get($id, $storeId));
    }

    public function testDelete()
    {
        $this->brandMock->expects($this->once())->method('getId')->willReturn('7');
        $this->resourceModelMock->expects($this->once())->method('delete')->with($this->brandMock)
            ->willReturn(true);
        $this->assertTrue($this->brandRepository->delete($this->brandMock));
    }

    /**
     * @expectedException \Magento\Framework\Exception\StateException
     * @expectedExceptionMessage Cannot delete brand with id 7
     */
    public function testDeleteException()
    {
        $this->brandMock->expects($this->exactly(2))->method('getId')->willReturn('7');
        $this->resourceModelMock->expects($this->once())->method('delete')->with($this->brandMock)
            ->willThrowException(new \Exception());
        $this->brandRepository->delete($this->brandMock);
    }

    public function testDeleteById()
    {
        $id = '7';
        $this->brandFactoryMock->expects($this->once())->method('create')
            ->will($this->returnValue($this->brandMock));
        $this->brandMock->expects($this->any())->method('getId')->willReturn('7');
        $this->brandMock->expects($this->once())->method('load')->with('7');
        $this->assertTrue($this->brandRepository->deleteById($id));
    }

    public function testGetList()
    {
        
    }
}