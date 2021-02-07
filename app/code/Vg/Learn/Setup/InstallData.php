<?php
namespace Vg\Learn\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallData implements InstallDataInterface
{

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.0', '<')) {
            $data = [
                [
                    'name' => 'Vendor1',
                    'description' => 'Vendor 1 desc',
                ],
            ];

            foreach ($data as $datum) {
                $setup->getConnection()
                    ->insertForce($setup->getTable('vg_learn_vendor'), $datum);
            }
        }
    }
}
