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

    public function getMerchant_id(){
        return $this->getParameter('merchant_id');
    }

    public function setMerchantId($value){
        return $this->setParameter('merchant_id', $value);
    }

    public function setMerchant_id($value){
        return $this->setParameter('merchant_id', $value);
    }

    // API Key
    public function getApiKey() {
        return $this->getParameter('api_key');
    }

    public function getApi_key() {
        return $this->getParameter('api_key');
    }

    public function setApiKey($value) {
        return $this->setParameter('api_key', $value);
    }

    public function setApi_key($value) {
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
    * Authorize an amount on the customer's card (forwards browser offsite)
    */
    public function purchase(array $parameters = array()){
        return $this->createRequest('\Omnipay\Swipehq\Message\PaymentPagePurchaseRequest', $parameters);
    }


    /**
    * Authorise an amount on the customer's card
    *
    * Returns an identifier, which is then used to redirect the browser
    * @param $parameters array
    */
    public function authorize(array $parameters = array()){
        return $this->createRequest('\Omnipay\Swipehq\Message\PaymentPageAuthorizeRequest', $parameters);
    }


    /**
    * Handle Live Payment Notification from off-site gateway following creditcard successful/failed transaction
    *
    * @param $parameters array e.g. clientIp, amount, currency
    */
    public function completePurchase(array $parameters = array()){
        return $this->completeAuthorize($parameters);
    }


    /**
    * Handle return from off-site gateways after authorization (called from above)
    *
    * @param $parameters array e.g. clientIp, amount, currency
    */
    public function completeAuthorize(array $parameters = array()){
        return $this->createRequest('\Omnipay\Swipehq\Message\PaymentPageCompleteAuthorizeRequest', $parameters);
    }


    
}
