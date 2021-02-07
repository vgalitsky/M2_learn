<?php

namespace Vg\Learn\Controller\Adminhtml\Vendor;

use Vg\Learn\Controller\Adminhtml\Vendor;

class Index extends Vendor
{
    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
