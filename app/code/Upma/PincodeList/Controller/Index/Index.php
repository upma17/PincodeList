<?php

namespace Upma\PincodeList\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
$collection = $this->_modelFactory->create()->getCollection();
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}