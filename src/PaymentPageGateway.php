<?php

namespace Omnipay\Swipehq;

use Omnipay\Common\AbstractGateway;
use Swipehq\Message\PaymentPageAuthorizeRequest;
use Swipehq\Message\PaymentPageCompleteAuthorizeRequest;
use Swipehq\Message\PaymentPagePurchaseRequest;

/**
 * Swipehq Gateway
 */
class PaymentPageGateway extends AbstractGateway {
   
    public function getName(){
        return 'Swipehq Payment Page';
    }

    public function getDefaultParameters(){
        return array(
            'merchant_id' => '',
            'api_key' => '',
            'description' => ''
        );
    }

    // Merchant ID
    public function getMerchantId(){
        return $this->getParameter('merchant_id');
    }

    public function setMerchantId($value){
        return $this->setParameter('merchant_id', $value);
    }

    // API Key
    public function getApiKey() {
        return $this->getParameter('api_key');
    }

    public function setApiKey($value) {
        return $this->setParameter('api_key', $value);
    }


    public function getDescription(){
        return $this->getParameter('description');
    }

    public function setDescription($value){
        return $this->setParameter('description', $value);
    }

    public function getTransactionId(){
        return $this->getParameter('transactionId');
    }

    public function setTransactionId($value){
        return $this->setParameter('transactionId', $value);
    }

    public function getTransactionReference(){
        return $this->getParameter('transactionReference');
    }

    public function setTransactionReference($value){
        return $this->setParameter('transactionReference', $value);
    }
    

    //*** Gateway Methods ***//

 
    /**
    * Authorize and immediately capture an amount on the customer's card (to the site)
    */
    public function purchase(array $parameters = array()){
        return $this->createRequest('\Omnipay\Swipehq\Message\PaymentPagePurchaseRequest', $parameters);
    }


    /**
    * Authorise an amount on the customer's card
    *
    * Returns an identifier for the redirection of the browser (I think)
    */
    public function authorize(array $parameters = array()){
        return $this->createRequest('\Omnipay\Swipehq\Message\PaymentPageAuthorizeRequest', $parameters);
    }


    /**
    * Handle return from off-site gateways after purchase (successful/failed transaction)
    *
    * Note: calls the below function
    * @var $parameters array clientIp, amount, currency
    */
    public function completePurchase(array $parameters = array()){
        return $this->completeAuthorize($parameters);
    }


    /**
    * Handle return from off-site gateways after authorization (called from above)
    *
    * @var $parameters array clientIp, amount, currency
    */
    public function completeAuthorize(array $parameters = array()){
        return $this->createRequest('\Omnipay\Swipehq\Message\PaymentPageCompleteAuthorizeRequest', $parameters);
    }


    
}
