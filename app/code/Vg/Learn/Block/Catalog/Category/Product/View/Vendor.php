<?php

namespace Vg\Learn\Block\Catalog\Category\Product\View;

use \Magento\Framework\View\Element\Template;
use Vg\Learn\Model\ResourceModel\Vendor\CollectionFactory as vendorCollectionFactory;
class Vendor extends Template
{
    
    protected $product;
    protected $productFactory;
    protected $vendorCollectionFactory;
    protected $registry;
    
    /**
     * 
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param vendorCollectionFactory $vendorCollectionFactory
     * @param array $data
     */
    public function __construct(
            Template\Context $context,
            vendorCollectionFactory $vendorCollectionFactory,
            array $data = array()
        ) 
    {
        $this->vendorCollectionFactory = $vendorCollectionFactory;
        parent::__construct($context, $data);
    }
    
    /**
     * 
     * @return Vg\Learn\Model\ResourceModel\Vendor\Collection $collection
     */
    public function getProductVendorsCollection()
    {
        /* @var Magento\Catalog\Model\Product\ $product  */
        $product    = $this->getProduct();
        $vedorIds   = explode(',', $product->getVendor());
        /* @ar Vg\Learn\Model\ResourceModel\Vendor\Collection $collection */
        $collection = $this->vendorCollectionFactory->create()
                ->addFieldToFilter('vendor_id',['IN' => $vedorIds]);
        return $collection;
    }
    
   
}