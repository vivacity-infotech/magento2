<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */
namespace Magento\GoogleOptimizer\Model\Observer\CmsPage;

class DeleteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $_codeMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $_eventObserverMock;

    /**
     * @var \Magento\GoogleOptimizer\Model\Observer\CmsPage\Delete
     */
    protected $_model;

    protected function setUp()
    {
        $this->_codeMock = $this->getMock('Magento\GoogleOptimizer\Model\Code', [], [], '', false);
        $this->_requestMock = $this->getMock('Magento\Framework\App\RequestInterface', [], [], '', false);

        $page = $this->getMock('Magento\Cms\Model\Page', [], [], '', false);
        $page->expects($this->once())->method('getId')->will($this->returnValue(3));
        $event = $this->getMock('Magento\Framework\Event', ['getObject'], [], '', false);
        $event->expects($this->once())->method('getObject')->will($this->returnValue($page));
        $this->_eventObserverMock = $this->getMock('Magento\Framework\Event\Observer', [], [], '', false);
        $this->_eventObserverMock->expects($this->once())->method('getEvent')->will($this->returnValue($event));

        $objectManagerHelper = new \Magento\TestFramework\Helper\ObjectManager($this);
        $this->_model = $objectManagerHelper->getObject(
            'Magento\GoogleOptimizer\Model\Observer\CmsPage\Delete',
            ['modelCode' => $this->_codeMock]
        );
    }

    public function testDeleteFromPageGoogleExperimentScriptSuccess()
    {
        $entityId = 3;
        $storeId = 0;

        $this->_codeMock->expects(
            $this->once()
        )->method(
            'loadByEntityIdAndType'
        )->with(
            $entityId,
            \Magento\GoogleOptimizer\Model\Code::ENTITY_TYPE_PAGE,
            $storeId
        );
        $this->_codeMock->expects($this->once())->method('getId')->will($this->returnValue(2));
        $this->_codeMock->expects($this->once())->method('delete');

        $this->_model->deleteCmsGoogleExperimentScript($this->_eventObserverMock);
    }

    public function testDeleteFromPageGoogleExperimentScriptFail()
    {
        $entityId = 3;
        $storeId = 0;

        $this->_codeMock->expects(
            $this->once()
        )->method(
            'loadByEntityIdAndType'
        )->with(
            $entityId,
            \Magento\GoogleOptimizer\Model\Code::ENTITY_TYPE_PAGE,
            $storeId
        );
        $this->_codeMock->expects($this->once())->method('getId')->will($this->returnValue(0));
        $this->_codeMock->expects($this->never())->method('delete');

        $this->_model->deleteCmsGoogleExperimentScript($this->_eventObserverMock);
    }
}
