<?php
namespace Vg\Learn\Controller\Adminhtml\Vendor;

use Vg\Learn\Controller\Adminhtml\Vendor;

class Add extends Vendor
{
    /**
     * @return \Magento\Backend\Model\View\Result\Forward
     */
    public function execute()
    {
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
