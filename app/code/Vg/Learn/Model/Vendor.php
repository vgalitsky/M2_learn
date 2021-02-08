<?php
namespace Vg\Learn\Model;

use Magento\Framework\Model\AbstractModel;
use Vg\Learn\Api\Vendor\DataInterface;
use Vg\Learn\Helper\Debug;

class Vendor extends AbstractModel implements DataInterface
{

    const CACHE_TAG = 'vg_learn_vendor';
    protected $storeManager;

    protected function _construct()
    {
        $this->_init('Vg\Learn\Model\ResourceModel\Vendor');
    }
    /**
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->getData(DataInterface::ID);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getData(DataInterface::NAME);
    }
    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        return $this->setData(DataInterface::NAME, $name);
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->getData(DataInterface::DESCRIPTION);
    }

    /**
     * @param $description
     * @return $this
     */
    public function setDescription($description)
    {
        return $this->setData(DataInterface::DESCRIPTION, $description);
    }
    
    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->getData(DataInterface::LOGO);
    }
    
    /**
     * @return string
     */
    public function setLogo($filename)
    {
        return $this->setData(DataInterface::LOGO, $filename);
    }
    
    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(DataInterface::CREATED_AT);
    }
    
    protected function _afterLoad(){

        parent::_afterLoad();
    }

}
