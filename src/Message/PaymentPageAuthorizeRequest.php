<?php

namespace Omnipay\Swipehq\Message;

use Omnipay\Common\Message\AbstractRequest;
use GuzzleHttp\Client;

/**
 * PaymentPage Authorize Request (from authorize & purchase methods)
 *
 * Objective: obtain an identifier from Swipe HQ
 */

class PaymentPageAuthorizeRequest extends AbstractRequest {

    protected $endpoint = 'https://api.swipehq.com/createTransactionIdentifier.php';

    // Merchant ID
    public function getMerchant_id(){
        return $this->getParameter('merchant_id');
    }

    public function setMerchant_id($value){
        return $this->setParameter('merchant_id', $value);
    }

    // API Key
    public function getApi_key(){
        return $this->getParameter('api_key');
    }

    public function setApi_key($value){
        return $this->setParameter('api_key', $value);
    }

    public function getData(){

        $data = array();

        $this->validate('amount', 'returnUrl', 'notifyUrl');

        // for connecting to the API
        $data['api_key'] = $this->getApi_key();
        $data['merchant_id'] = $this->getMerchant_id();

        // returning to the website following credit card transaction
        $data['td_callback_url'] = $this->getReturnUrl();

        // Live Payment Notifications
        $data['td_lpn_url'] = $this->getParameter('notifyUrl');

        $data['td_item'] = $this->getDescription();  
        $data['td_amount'] = $this->getAmount();      // method in AbstractRequest class
        
        // Email plus address stored in the card
        $card = $this->getCard();
        $data['td_email'] = $card->getEmail();
        
        // Link back to transaction id in eCommerce system
        $data['td_reference'] = $this->getParameter('transactionId');

        return $data;
    }


    // send a message server to server
    public function send(){
        
        // Variables
        $headers = null;
        $data = $this->getData();

        // send request to payment gateway
        $httpResponse = $this->httpClient->post($this->endpoint, $headers, $data)->send();


        // sends data to the below function
        $create_response = $this->createResponse($httpResponse->json());
        return $create_response;
    }

    protected function createResponse($data){
        $this->response = new PaymentPageAuthorizeResponse($this, $data);
        return $this->response;
    }
}
