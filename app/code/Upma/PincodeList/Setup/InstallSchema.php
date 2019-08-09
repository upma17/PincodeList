<?php

namespace Upma\PincodeList\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.0.0') < 0){

		$installer->run('create table pincodes_list(pincode_id int not null auto_increment, pincode int(11), primary key(pincode_id))');
$installer->run('insert into pincodes_list values(null,301001)');
$installer->run('insert into pincodes_list values(null,110074)');


		

		}

        $installer->endSetup();

    }
}