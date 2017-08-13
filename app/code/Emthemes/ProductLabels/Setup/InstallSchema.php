<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Emthemes\ProductLabels\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Create table 'emthemes_product_label'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('emthemes_product_label')
        )->addColumn(
            'label_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'label ID'
        )->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Label Title'
        )->addColumn(
            'conditions_serialized',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '1M',
            ['nullable' => false],
            'Label conditions'
        )->addColumn(
            'is_active',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1'],
            'Is Label Active'
        )->addIndex(
            $installer->getIdxName('emthemes_product_label', ['label_id']),
            ['label_id']
        )->setComment(
            'Emthemes ProductLabels Store'
        );
        $installer->getConnection()->createTable($table);

        /**
         * Create table 'emthemes_product_label_store'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('emthemes_product_label_store')
        )->addColumn(
            'label_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'primary' => true],
            'label ID'
        )->addColumn(
            'store',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Store ID'
        )->addColumn(
            'image',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '1M',
            [],
            'Image'
        )->addColumn(
            'background',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '1M',
            [],
            'Background'
        )->addColumn(
            'text',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '2M',
            [],
            'Text'
        )->addColumn(
            'css_class',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '1M',
            [],
            'CSS class'
        )->addIndex(
            $installer->getIdxName('emthemes_product_label_store', ['store']),
            ['store']
        )->addForeignKey(
            $installer->getFkName('emthemes_product_label_store', 'label_id', 'emthemes_product_label', 'label_id'),
            'label_id',
            $installer->getTable('emthemes_product_label'),
            'label_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName('emthemes_product_label_store', 'store', 'store', 'store_id'),
            'store',
            $installer->getTable('store'),
            'store_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'emthemes_product_label To Store Linkage Table'
        );
        $installer->getConnection()->createTable($table);

        

        $installer->endSetup();
    }
}
