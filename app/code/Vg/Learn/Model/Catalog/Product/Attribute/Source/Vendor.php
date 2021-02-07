<?php

namespace Vg\Learn\Model\Catalog\Product\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Vg\Learn\Model\ResourceModel\Vendor\CollectionFactory;


class Vendor extends AbstractSource
{
    protected $dataInterface;
    protected $options;
            
    public function __construct(
                CollectionFactory $dataInterface
            ) {
        $this->dataInterface = $dataInterface;
    }
    
    protected $optionFactory;
    
    public function getAllOptions()
    {
        $collection = $this->dataInterface->create(); 
        
        $this->_options = [];
        foreach($collection as $item){
            $this->_options[] = ['label' => $item->getName(), 'value' => $item->getId()];
        }
        return $this->_options;
    }
}