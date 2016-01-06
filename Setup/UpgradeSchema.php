<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Dys\Team\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Upgrade the Catalog module DB scheme
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
            /*$setup->getConnection()->addColumn(
                $setup->getTable('team'),
            'team_image',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 256,
                'nullable' => '',
                'comment' => 'Media Images'
            ]
            );*/

        //if (version_compare($context->getVersion(), '1.0.1', '<')) {
             $setup->getConnection()->addColumn(
                  $setup->getTable('team'),
                  'slogan',
                  [
                      'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                      'length' => 500,
                      'nullable' => false,
                      'comment' => 'team slogan'
                  ]
              );
              $setup->getConnection()->addColumn(
                  $setup->getTable('team'),
                  'team_color',
                  [
                      'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                      'length' => 10,
                      'nullable' => false,
                      'comment' => 'team color'
                  ]
              );
              $setup->getConnection()->addColumn(
                  $setup->getTable('team'),
                  'store_id',
                  [
                      'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                      null,
                      ['unsigned' => true, 'nullable' => false, 'primary' => true],
                      'comment' => 'Store Id'
                  ]
              );
              $setup->getConnection()->addColumn(
                  $setup->getTable('team'),
                  'extra',
                  [
                      'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                      null,
                      ['unsigned' => true, 'nullable' => ''],
                      'comment' => 'Extra param'
                  ]
              );

               $setup->getConnection()->addColumn(
                  $setup->getTable('team'),
                  'team_coach',
                  [
                      'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                      'length' => 40,
                      ['unsigned' => true, 'nullable' => ''],
                      'comment' => 'team coach'
                  ]
              );

               $setup->getConnection()->addColumn(
                  $setup->getTable('team'),
                  'team_image',
                  [
                      'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                      'length' => 255,
                      ['unsigned' => true, 'nullable' => ''],
                      'comment' => 'team Image'
                  ]
              );

          //}
        $setup->endSetup();
    }


}
