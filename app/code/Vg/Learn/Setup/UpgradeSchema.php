<?php
namespace Vg\Learn\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    
    private $eavSetupFactory;
    
    public function __construct(\Magento\Eav\Setup\EavSetupFactory $eavSetupFactory){
        $this->eavSetupFactory = $eavSetupFactory;
    }
    
    public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
        

        $setup->startSetup();

        if(version_compare($context->getVersion(), '1.0.1', '<')) {
                $setup->getConnection()->addColumn(
                        $setup->getTable( 'vg_learn_vendor' ),
                        'logo',
                        [
                                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_VARCHAR,
                                'nullable' => true,
                                'length' => '1024',
                                'comment' => 'logo',
                                'after' => 'description'
                        ]
                );
        }

        if(version_compare($context->getVersion(), '1.0.2', '<')) {
            $eavSetup = $this->eavSetupFactory->create();
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'vendor',
                [
                    'group'             => 'General',
                    'type'              => 'text',
                    'label'             => 'Vendor',
                    'input'             => 'multiselect',
                    'source'            => 'Vg\Learn\Model\Catalog\Product\Attribute\Source\Vendor',
                    'required'          => false,
                    'sort_order'        => 30,
                    'global'            => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
                    'used_in_product_listing' => true,
                    //'frontend' => 'Vg\Learn\Model\Catalog\Product\Attribute\Frontend\Vendor',
                    'backend'           => 'Vg\Learn\Model\Catalog\Product\Attribute\Backend\Vendor',
                    'is_used_in_grid'   => true,
                    'filterable'        => true,
                    'is_filterable_in_grid' => false,
                    'visible'           => true,
                    'user_defined'      => true,
                    'is_html_allowed_on_front' => true,
                    'visible_on_front'  => true,
                ]
            );
        }
        
        $setup->endSetup();
    }
}