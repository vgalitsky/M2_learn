<?php
namespace Vg\Learn\Setup;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;
use Magento\Config\Model\ResourceModel\Config\Data;
use Magento\Config\Model\ResourceModel\Config\Data\CollectionFactory;

class Uninstall implements UninstallInterface
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    
    protected $configResource;

    /**
     * @param CollectionFactory $collectionFactory
     * @param Vendor $configResource
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        Vendor $configResource
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->configResource    = $configResource;
    }

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if ($setup->tableExists('vg_learn_vendor')) {
            $setup->getConnection()->dropTable('vg_learn_vendor');
        }
        $collection = $this->collectionFactory->create()
            ->addPathFilter('vg_learn');
        foreach ($collection as $config) {
            $this->deleteConfig($config);
        }
    }

    /**
     * @param AbstractModel $config
     */
    protected function deleteConfig(AbstractModel $config)
    {
        $this->configResource->delete($config);
    }
}
