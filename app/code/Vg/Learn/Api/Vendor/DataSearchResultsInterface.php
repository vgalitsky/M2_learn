<?php
namespace Vg\Learn\Api\Vendor;

use Magento\Framework\Api\SearchResultsInterface;

interface DataSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \Vg\Learn\Api\Vendor\VendorInterface[]
     */
    public function getItems();

    /**
     * @param \Vg\Learn\Api\Vendor\VendoraInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
