<?php
namespace Upma\PincodeList\Model\ResourceModel;

class Pincodes extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('pincodes_list', 'pincode_id');
    }
}
?>