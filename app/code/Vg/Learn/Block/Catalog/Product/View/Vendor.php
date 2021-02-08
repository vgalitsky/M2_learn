<?php

namespace Vg\Learn\Block\Catalog\Product\View;

use \Magento\Framework\View\Element\Template;
use Magento\Catalog\Block\Product\View;
use Magento\Catalog\Helper\Image;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Vg\Learn\Model\ResourceModel\Vendor\CollectionFactory as vendorCollectionFactory;

/**
 * 
 */
class Vendor extends Template
{
    
    protected $product;
    protected $productFactory;
    protected $vendorCollectionFactory;
    protected $registry;
    protected $storeManager;
    protected $imageHelper;
    protected $urlBuilder;
    
    
    /**
     * 
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param vendorCollectionFactory $vendorCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
            Template\Context $context, 
            \Magento\Framework\Registry $registry,
            \Magento\Catalog\Model\ProductFactory $productFactory,
            vendorCollectionFactory $vendorCollectionFactory,
            StoreManagerInterface $storeManager,
            array $data = array()
        ) 
    {
        $this->registry = $registry;
        $this->productFactory = $productFactory;
        $this->vendorCollectionFactory = $vendorCollectionFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }
    
    /**
     * 
     * @return Vg\Learn\Model\ResourceModel\Vendor\Collection
     */
    public function getProductVendorsCollection()
    {
        /** @var Magento\Catalog\Model\Product $product */
        $product    = $this->getCurrentProduct();
        $vedorIds   = explode(',', $product->getVendor());
        $collection = $this->vendorCollectionFactory->create()
                ->addFieldToFilter('vendor_id',['IN'=>$vedorIds]);
        return $collection;
        
    }
    
    /**
     * @return Magento\Catalog\Model\Product
     */
    public function getCurrentProduct()
    { 
        if(!$this->product){
            $this->product = $this->registry->registry('current_product');
        }
        return $this->product;
    }
    
    /**
     * 
     * @param type $vendor
     * @return string
     */
    public function getVendorLogoImgSrc($vendor)
    {
        $path = \Vg\Learn\Model\Vendor\LogoUploader::IMAGE_PATH;
        $url = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)
                . "{$path}\\{$vendor->getLogo()}";
        return $url;
    }
	
}