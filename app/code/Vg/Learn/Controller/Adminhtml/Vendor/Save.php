<?php

namespace Vg\Learn\Controller\Adminhtml\Vendor;


use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Message\Manager;
use Magento\Framework\Api\DataObjectHelper;
use Psr\Log\LoggerInterface;
use Vg\Learn\Api\DataRepositoryInterface;
use Vg\Learn\Api\Vendor\DataInterface;
use Vg\Learn\Api\Vendor\DataInterfaceFactory;
use Vg\Learn\Controller\Adminhtml\Vendor;
use Vg\Learn\Model\Vendor\LogoUploader;
use Vg\Learn\Helper\Debug;

class Save extends Vendor
{
    /**
     * @var Manager
     */
    protected $messageManager;

    /**
     * @var DataRepositoryInterface
     */
    protected $dataRepository;

    /**
     * @var DataInterfaceFactory
     */
    protected $dataFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;
    
    /**
     * @var LogoUploader
     */
    protected $logoUploader;
    

    public function __construct(
        Registry $registry,
        DataRepositoryInterface $dataRepository,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        Manager $messageManager,
        DataInterfaceFactory $dataFactory,
        DataObjectHelper $dataObjectHelper,
        Context $context,
        logoUploader $logoUploader
    ) {
        $this->messageManager   = $messageManager;
        $this->dataFactory      = $dataFactory;
        $this->dataRepository   = $dataRepository;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->logoUploader     = $logoUploader;
        parent::__construct($registry, $dataRepository, $resultPageFactory, $resultForwardFactory, $context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $id = $this->getRequest()->getParam('vendor_id');
            if ($id) {
                $model = $this->dataRepository->getById($id);
            } else {
                unset($data['vendor_id']);
                $model = $this->dataFactory->create();
            }

            try {
                
                if (isset($data['logo'][0]['name']) && isset($data['logo'][0]['tmp_name'])) {
                $data['logo'] = $data['logo'][0]['name'];
               
                $this->logoUploader->moveFileFromTmp($data['logo']);
                } elseif (isset($data['logo'][0]['name']) && !isset($data['logo'][0]['tmp_name'])) {
                    $data['logo'] = $data['logo'][0]['name'];
                } else {
                    unset($data['logo']);
                }
                $this->dataObjectHelper->populateWithArray($model, $data, DataInterface::class);
                
                $this->dataRepository->save($model);
                $this->messageManager->addSuccessMessage(__('Saved'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['vendor_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->messageManager->addException($e, __('Error while saving'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['vendor_id' => $this->getRequest()->getParam('vendor_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
