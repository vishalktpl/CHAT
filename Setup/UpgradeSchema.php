<?php
/**
 * Created by PhpStorm.
 * User: kunj.joshi
 * Date: 11/7/15
 * Time: 10:52 AM
 */
namespace Ktpl\Hello\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context){
        if (version_compare($context->getVersion(), '1.0.1') < 0) {
            $installer = $setup;
            $installer->startSetup();
            $tableName = $setup->getTable('hello');
            if ($installer->tableExists($tableName)) {
                $columns = [
                    'image' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        255,
                        'length' => '1k',
                        'nullable' => false,
                        'comment' => 'image Base Path',
                    ],
                ];
                $connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($tableName, $name, $definition);
                }

            }
            $installer->endSetup();
        }
    }

}
