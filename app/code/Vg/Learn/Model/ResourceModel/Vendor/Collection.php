<?php
namespace Vg\Learn\Model\ResourceModel\Vendor;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    
    protected $_idFieldName = 'vendor_id';

    /**
     * 
     */
    protected function _construct()
    {
        
        $this->_init('Vg\Learn\Model\Vendor', 'Vg\Learn\Model\ResourceModel\Vendor');
    }
}
