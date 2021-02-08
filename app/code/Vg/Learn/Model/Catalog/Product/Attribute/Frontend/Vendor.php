<?php
namespace Vg\Learn\Model\Catalog\Product\Attribute\Frontend;

class Vendor extends \Magento\Eav\Model\Entity\Attribute\Frontend\AbstractFrontend
{
    /**
     * 
     * @param \Magento\Framework\DataObject $object
     * @return string
     */
    public function getValue(\Magento\Framework\DataObject $object)
    {
        $value = $object->getData($this->getAttribute()->getAttributeCode());
        return "<b>$value</b>";
    }
}