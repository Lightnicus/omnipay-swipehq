<?php

namespace Omnipay\Swipehq\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use GuzzleHttp\Client;

/**
 * Payment Page Complete Authorize Request (step 2 - completeAuthorize method)
 *
 * Handle return from off-site gateways after authorization - ie have typed in cc no. and are now have returned to the website.  This helps recreate the state.  Use verifyTransaction API to confirm purchase.  Note that we do not have access to the identifier from Swipehq.  
 * Example response: {"response_code":200,"message":"OK","data":{"transaction_id":"XXXX","status":"declined","transaction_approved":"no"}}
 */


class PaymentPageCompleteAuthorizeRequest extends PaymentPageAuthorizeRequest{

    protected $endpoint = 'https://api.swipehq.com/verifyTransaction.php';

    // Merchant ID
    public function getMerchantId(){
        return $this->getParameter('merchant_id');
    }

    public function setMerchantId($value){
        return $this->setParameter('merchant_id', $value);
    }

    // API Key
    public function getApiKey(){
        return $this->getParameter('api_key');
    }

    public function setApiKey($value){
        return $this->setParameter('api_key', $value);
    }

    // Gateway's identifer (issue: returns null.  It would be nice to have it.)
    public function getTransactionReference(){
        return $this->getParameter('transactionReference');
    }

    public function setTransactionReference($value){
        return $this->setParameter('transactionReference', $value);
    }

       
    public function getData(){

        // validation check
        $result = $this->httpRequest->query->get('result');
        if (empty($result)) {
            throw new InvalidResponseException;
        }

        // prepare data for API
        $data = array();

        //var_dump(get_class_methods($this->httpRequest->query));
        //var_dump($this->httpRequest->query->all());
        //var_dump($this->httpRequest->query->keys()); 
        // var_dump($this->data); // doesn't exist
        //var_dump($this->httpRequest->request->all());   // null
        //var_dump($this->httpRequest->query->get('transactionReference'));   // null
        //var_dump($this->httpRequest->query->get('identifier_id'));   // null
        //var_dump($this->httpRequest->query->get('transactionId'));  // null
        //var_dump($this->httpRequest->query->get('td_reference'));  // null
        //var_dump($this->httpRequest->query->get('identifier'));  // null

        
        $data['api_key'] = $this->getApiKey();
        $data['merchant_id'] = $this->getMerchantId();
        

        // Problem: Is it possible to access the identifier?  
        // Presently, returning a 404 from Swipehq

        $data['identifier_id'] = $this->getTransactionReference();  // null

        //$data['tansaction_id'] = $this->getTransactionId();  // null

        // Link back to transaction id in SS Shop
        //$data['td_reference'] = $this->getParameter('transactionId');  // null
        //$data['td_user_data'] = $this->getParameter('transactionId');  // null

 
        return $data;
    }


    public function send(){
        
        // Variables
        $headers = null;
        $data = $this->getData();

        // send request to payment gateway
        $httpResponse = $this->httpClient->post($this->endpoint, $headers, $data)->send();

        // sends data to the below function
        $create_response = $this->createResponse($httpResponse->json());

        // getting 404
        /*
        protected 'response' => 
                &object(Omnipay\Swipehq\Message\Response)[1104]
          protected 'data' => 
            array (size=2)
              'response_code' => int 404
              'message' => string 'No results were found' (length=21)

        */

        return $create_response;
    }


    // create response
    protected function createResponse($data){
        return $this->response = new PaymentPageCompleteAuthorizeResponse($this, $data);
    }

   
}
