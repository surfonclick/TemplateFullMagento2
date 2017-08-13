<?php
/**
 * Copyright © 2015 Emthemes. All rights reserved.
 */

namespace Emthemes\Slideshow\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();
        $table  = $installer->getConnection()
            ->newTable($installer->getTable('emthemes_slideshow_items'))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Id'
            )
            ->addColumn('name', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 100, array(
				), 'Slideshow name')		
			->addColumn('identity', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 100, array(
				), 'Identity name')
			->addColumn('dev_en', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, array(
					'nullable'  => false,
					'default'   => '0',
					), 'Developt')
			->addColumn('slider_params', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '4M', array(
				), 'Slideshow params')
			->addColumn('configure_params', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '1M', array(
				), 'Configure params')	
			->addColumn('transition_effect', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '4M', array(
				), 'Layer Transition Effects')	
			->addColumn('width', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,50, array(
				), 'Width')
			->addColumn('height', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,50, array(
				), 'Height')
			->addColumn('number', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,50, array(
				), 'Number Image')				
			->addColumn('status', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, array(
					'nullable'  => false,
					'default'   => '0',
					), 'Is Slideshow Active');
        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}
