<?php
namespace Vg\Learn\Model;

use Magento\Framework\Model\AbstractModel;
use Vg\Learn\Api\Vendor\DataInterface;
use Vg\Learn\Helper\Debug;

class Vendor extends AbstractModel implements DataInterface
{

    const CACHE_TAG = 'vg_learn_vendor';
    protected $storeManager;

    protected function _construct(
            //\Magento\Store\Model\StoreManagerInterface $storeManager
        )
    {
        //$this->storeManager = $storeManager;
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
        if($this->getLogo()){
            $this->setLogo(
                    //$this->getMediaUrl().$this->getLogo()
                    'http://m2.local/pub/media/vg/learn/vendor/logo/file.png'
                    );
        }
        //Debug::dump($this->getData());die();
        parent::_afterLoad();
    }
    
    public function getMediaUrl()
    {
        $mediaUrl = $this->storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'vg/learn/logo/';
        return $mediaUrl;
    }

}
