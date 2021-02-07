<?php
namespace Vg\Learn\Ui\Component\Listing\Column;

use Magento\Catalog\Helper\Image;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Logo extends Column
{
    const ALT_FIELD = 'name';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Image $imageHelper
     * @param UrlInterface $urlBuilder
     * @param StoreManagerInterface $storeManager
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Image $imageHelper,
        UrlInterface $urlBuilder,
        StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->imageHelper = $imageHelper;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if(isset($dataSource['data']['items'])) {
            foreach($dataSource['data']['items'] as & $item) {
                $url = '';
                if($item['logo'] != '') {
                    $path = \Vg\Learn\Model\Vendor\LogoUploader::IMAGE_PATH;
                    $url = $this->storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ). $path ."\\". $item['logo'];
                }
                $item['logo' . '_src'] = $url;
                $item['logo' . '_alt'] = $item['name'];
                $item['logo' . '_link'] = $this->urlBuilder->getUrl(
                    'vglearn/vendor/edit',
                    ['vendor_id' => $item['vendor_id']]
                );
                $item['logo' . '_orig_src'] = $url;
            }
        }

        return $dataSource;
    }

    
}