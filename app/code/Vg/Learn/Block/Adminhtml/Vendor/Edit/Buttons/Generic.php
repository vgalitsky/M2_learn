<?php

namespace Vg\Learn\Block\Adminhtml\Vendor\Edit\Buttons;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

class Generic
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * GenericButton constructor.
     *
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }

    /**
     * @return string|null
     */
    public function getDataId()
    {
        try {
            return $this->context->getRequest()->getParam('vendor_id');
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
