<?php

namespace Vg\Learn\Controller\Adminhtml\Vendor;

use Vg\Learn\Controller\Adminhtml\Vendor;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class Delete extends Vendor
{
    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $dataId = $this->getRequest()->getParam('vendor_id');
        if ($dataId) {
            try {
                $this->dataRepository->deleteById($dataId);
                $this->messageManager->addSuccessMessage(__('deleted.'));
                $resultRedirect->setPath('vglearn/vendor/index');
                return $resultRedirect;
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('Not exists.'));
                return $resultRedirect->setPath('vglearn/vendor/index');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('vgearn/vendor/index', ['vendor_id' => $dataId]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('error'));
                return $resultRedirect->setPath('vglearn/vendor/edit', ['vendor_id' => $dataId]);
            }
        }
        $this->messageManager->addErrorMessage(__('not found'));
        $resultRedirect->setPath('vglearn/vendor/index');
        return $resultRedirect;
    }
}
