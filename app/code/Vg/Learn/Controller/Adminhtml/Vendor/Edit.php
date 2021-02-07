<?php

namespace Vg\Learn\Controller\Adminhtml\Vendor;

use Vg\Learn\Controller\Adminhtml\Vendor;

class Edit extends Vendor
{
    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $dataId = $this->getRequest()->getParam('vendor_id');
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Vg_Learn::vendor')
            ->addBreadcrumb(__('Vendor'), __('Vendor'))
            ->addBreadcrumb(__('Manage Vendors'), __('Manage Vendors'));

        if ($dataId === null) {
            $resultPage->addBreadcrumb(__('New Vendor'), __('New Vendor'));
            $resultPage->getConfig()->getTitle()->prepend(__('New Vendor'));
        } else {
            $resultPage->addBreadcrumb(__('Edit Vendor'), __('Edit Vendor'));
            $resultPage->getConfig()->getTitle()->prepend(
                $this->dataRepository->getById($dataId)->getDataTitle()
            );
        }
        return $resultPage;
    }
}
