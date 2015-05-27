<?php

namespace Omnipay\Swipehq\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use GuzzleHttp\Client;

/**
 * Payment Page Complete Authorize Request (step 2 - from completeAuthorize method)
 *
 * Handle return from off-site gateways after authorization.  The user has typed in cc number, clicked submit and the Live Payment Nofification is made.  Then the user is returned to the website.
 *  Use verifyTransaction API to confirm purchase.
 */


class PaymentPageCompleteAuthorizeRequest extends PaymentPageAuthorizeRequest{

    protected $endpoint = 'https://api.swipehq.com/verifyTransaction.php';

    // Merchant ID
    public function getMerchant_id(){
        return $this->getParameter('merchant_id');
    }

    // API Key
    public function getApi_key(){
        return $this->getParameter('api_key');
    }

       
    public function getData(){

        // validation check.  The Live Payment Notification should have provided the identifier_id
        $result = $this->httpRequest->request->get('identifier_id');
        if (empty($result)) {
            throw new InvalidResponseException;
        }

        // prepare data for API
        $data = array();
        
        $data['api_key'] = $this->getApi_key();
        $data['merchant_id'] = $this->getMerchant_id();
        $data['identifier_id'] = $this->httpRequest->request->get('identifier_id'); 
        $data['transaction_id'] = $this->httpRequest->request->get('transaction_id');
 
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


    // create response
    protected function createResponse($data){
        return $this->response = new PaymentPageCompleteAuthorizeResponse($this, $data);
    }

   
}
