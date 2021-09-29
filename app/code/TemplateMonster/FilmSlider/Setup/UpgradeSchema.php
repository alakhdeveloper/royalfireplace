<?php
namespace TemplateMonster\FilmSlider\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    )
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '2.0.5', '<')) {

            $tableName = $setup->getTable('film_slider_item');
            $setup->getConnection()->addColumn(
                $tableName,
                'sort_item',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'length' => 10,
                    ['nullable' => true, 'default' => null],
                    'comment' => 'Sort order item'
                ]);
        }
        if (version_compare($context->getVersion(), '2.0.6', '<')) {

            $tableName = $setup->getTable('film_slider_item');
            $setup->getConnection()->addColumn(
                $tableName,
                'slide_url',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    ['nullable' => true, 'default' => null],
                    'comment' => 'Slide URL'
                ]);
        }

        $setup->endSetup();
    }
}