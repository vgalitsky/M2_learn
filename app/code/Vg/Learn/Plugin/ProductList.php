<?php
namespace Vg\Learn\Plugin;

class ProductList
{   
    protected $layout;

    public function __construct(
        \Magento\Framework\View\LayoutInterface $layout
    ) 
    {
        $this->layout = $layout;
    }

    public function aroundGetProductDetailsHtml(
        \Magento\Catalog\Block\Product\ListProduct $subject,
        \Closure $proceed,
        \Magento\Catalog\Model\Product $product
    ) 
    {
        return $this->layout->createBlock('Vg\Learn\Block\Catalog\Category\Product\View\Vendor')
                ->setProduct($product)
                ->setTemplate('Vg_Learn::catalog/category/product/view/vendor.phtml')
                ->toHtml();
    }
    
    public function getProductVendorsCollection()
    {
        
    }
}