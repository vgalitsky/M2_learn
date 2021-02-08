<?php
namespace Vg\Learn\Controller\Adminhtml\Vendor;

use Exception;
use Codextblog\Imageupload\Model\ImageUploader;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Vg\Learn\Model\Vendor\LogoUploader;

class UploadLogo extends Action implements HttpPostActionInterface
{
    protected $logoUploader;
    
    /**
     * @param Context $context
     * @param LogoUploader $logoUploader
     */
    public function __construct(
        Context $context,
        LogoUploader $logoUploader
    ) {
        parent::__construct($context);
        $this->logoUploader = $logoUploader;
    }
    
    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $imageId = $this->_request->getParam('param_name', 'logo');
 
        try {
            $result = $this->logoUploader->saveFileToTmpDir($imageId);
        } catch (Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
