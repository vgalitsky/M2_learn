<?php

namespace Vg\Learn\Controller\Adminhtml\Vendor;

use Vg\Learn\Model\Vendor;

class MassDelete extends MassAction
{
    /**
     * @param Data $data
     * @return $this
     */
    protected function massAction(Vendor $data)
    {
        $this->dataRepository->delete($data);
        return $this;
    }
}
