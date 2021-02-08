<?php
namespace Vg\Learn\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Vendor extends AbstractDb
{
    
    protected $date;

    /**
     * @param Context $context
     * @param DateTime $date
     */
    public function __construct(
        Context $context,
        DateTime $date
    ) {
        $this->date = $date;
        parent::__construct($context);
    }

    /**
     * 
     */
    protected function _construct()
    {
        $this->_init('vg_learn_vendor', 'vendor_id');
    }

    /**
     * @param AbstractModel $object
     * @return \Magento\Framework\Model\ResourceModel\Db\AbstractDb
     */
    protected function _beforeSave(AbstractModel $object)
    {
        $object->setUpdatedAt($this->date->gmtDate());
        if ($object->isObjectNew()) {
            $object->setCreatedAt($this->date->gmtDate());
        }
        return parent::_beforeSave($object);
    }
}
