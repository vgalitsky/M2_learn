<?php

namespace Vg\Learn\Controller\Adminhtml;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Psr\Log\LoggerInterface;
use Vg\Learn\Api\DataRepositoryInterface;
use Vg\Learn\Helper\Debug;


abstract class Vendor extends Action
{
    
    const ACTION_RESOURCE = 'Vg_Learn::vendor';

    protected $dataRepository;

    protected $coreRegistry;

    protected $resultPageFactory;

    protected $resultForwardFactory;

    /**
     * @param Registry $registry
     * @param DataRepositoryInterface $dataRepository
     * @param PageFactory $resultPageFactory
     * @param ForwardFactory $resultForwardFactory
     * @param Context $context
     */
    public function __construct(
        Registry $registry,
        DataRepositoryInterface $dataRepository,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        Context $context
    ) {
        $this->coreRegistry         = $registry;
        $this->dataRepository       = $dataRepository;
        $this->resultPageFactory    = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }
}
