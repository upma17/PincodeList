<?php
namespace Upma\PincodeList\Block\Adminhtml\Pincodes\Edit;

/**
 * Admin page left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('pincodes_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Pincodes Information'));
    }
}