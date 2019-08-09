<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Free shipping model
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */
namespace Upma\PincodeList\Model\Carrier;

use Magento\Quote\Model\Quote\Address\RateRequest;

class Freeshipping extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements
    \Magento\Shipping\Model\Carrier\CarrierInterface
{
    /**
     * @var string
     */
    protected $_code = 'freeshipping';

    /**
     * @var bool
     */
    protected $_isFixed = true;

    /**
     * @var \Magento\Shipping\Model\Rate\ResultFactory
     */
    protected $_rateResultFactory;

    /**
     * @var \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
     */
    protected $_rateMethodFactory;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        array $data = []
    ) {
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    /**
     * FreeShipping Rates Collector
     *
     * @param RateRequest $request
     * @return \Magento\Shipping\Model\Rate\Result|bool
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }
     /** custom code to disable free shipping for some zipcode. fetch the pincode list here and condition as required */
	$objectManager =   \Magento\Framework\App\ObjectManager::getInstance();
	$testquery = $objectManager->create('Upma\PincodeList\Model\Pincodes');
	$collection = $testquery->getCollection();	
	foreach($collection as $pin){
		$pincodes[]=$pin['pincode'];
	}
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
	$logger = new \Zend\Log\Logger();
	$logger->addWriter($writer);
    $logger->info(print_r($pincodes,true));

 	$postCode = $request->getDestPostcode();
	//disable freeshipping if shipping pincode is there in list
	if(in_array($postCode,$pincodes)){
		return false;
	}
//end of custom code
    /** @var \Magento\Shipping\Model\Rate\Result $result */
        $result = $this->_rateResultFactory->create();

        $this->_updateFreeMethodQuote($request);

        if ($request->getFreeShipping() || $request->getBaseSubtotalInclTax() >= $this->getConfigData(
            'free_shipping_subtotal'
        )
        ) {
            /** @var \Magento\Quote\Model\Quote\Address\RateResult\Method $method */
            $method = $this->_rateMethodFactory->create();

            $method->setCarrier('freeshipping');
            $method->setCarrierTitle($this->getConfigData('title'));

            $method->setMethod('freeshipping');
            $method->setMethodTitle($this->getConfigData('name'));

            $method->setPrice('0.00');
            $method->setCost('0.00');

            $result->append($method);
        }

        return $result;
    }

    /**
     * Allows free shipping when all product items have free shipping (promotions etc.)
     *
     * @param \Magento\Quote\Model\Quote\Address\RateRequest $request
     * @return void
     */
    protected function _updateFreeMethodQuote($request)
    {
        $freeShipping = false;
        $items = $request->getAllItems();
        $c = count($items);
        for ($i = 0; $i < $c; $i++) {
            if ($items[$i]->getProduct() instanceof \Magento\Catalog\Model\Product) {
                if ($items[$i]->getFreeShipping()) {
                    $freeShipping = true;
                } else {
                    return;
                }
            }
        }
        if ($freeShipping) {
            $request->setFreeShipping(true);
        }
    }

    /**
     * @return array
     */
    public function getAllowedMethods()
    {
        return ['freeshipping' => $this->getConfigData('name')];
    }
}
