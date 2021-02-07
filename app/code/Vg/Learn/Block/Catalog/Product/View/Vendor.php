<?php

namespace Vg\Learn\Block\Catalog\Product\View;

use \Magento\Framework\View\Element\Template;
use Magento\Catalog\Block\Product\View;


class Vendor extends Template
{
    
    
    public function __construct(
            Template\Context $context, array $data = array()) 
    {
        parent::__construct($context, $data);
    }
    protected $product;
    
    
    public function getVendor()
    {
        die('template::getVendor');
    }
    
    public function setProduct( $product )
    {
        $this->product = $product;
    }
    
    public function getProduct()
    {
        die(get_class(parent::getProduct()));
        die('111');
        return $this->product;
    }
	
}