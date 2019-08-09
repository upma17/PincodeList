<?php
namespace Upma\PincodeList\Model;

class Pincodes extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Upma\PincodeList\Model\ResourceModel\Pincodes');
    }
}
?>