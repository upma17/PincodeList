<?php

namespace Upma\PincodeList\Model\ResourceModel\Pincodes;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Upma\PincodeList\Model\Pincodes', 'Upma\PincodeList\Model\ResourceModel\Pincodes');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>