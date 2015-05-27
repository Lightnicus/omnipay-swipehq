<?php

namespace Omnipay\Swipehq;

use Omnipay\GatewayTestCase;

class GatewayTest extends GatewayTestCase {
    
    public function setUp() {
        parent::setUp();

        $this->gateway = new PaymentPageGateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = array(
            'merchant_id' => '12345',
            'api_key' => '67890',
            'description' => 'Ginger Ninger',
            'amount' => '25.25',
            'cancelUrl' => 'http://localhost:8888/cancelurltest',
            'returnUrl' => 'http://localhost:8888/returnurltest',
            'notifyUrl' => 'http://localhost:8888/notifyurltest',
            'clientIp' => '123.45.67.8',
            'transactionId' => '111',
            'currency' => 'NZD',
            'card' => array(
                'email' => 'ed@everest.net',
                'billingFirstName' => 'Edmond',
                'billingLastName' => 'Hillary'
            )
        );
    }


    public function testPurchaseSuccess() {
        $this->setMockHttpResponse('PurchaseSuccess.txt');
        $response = $this->gateway->purchase($this->options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertContains($response->getTransactionReference(), "bar123", "The identifier from the response");
        $this->assertSame($response->getCode(), "200", "Response Code is 200");
        $this->assertSame($response->getMessage(), "OK", "Response Message is 'OK'");
        $this->assertContains('https://payment.swipehq.com/?identifier_id=bar123', $response->getRedirectUrl());
        $this->assertSame('GET', $response->getRedirectMethod());
        
    }


    public function testAuthorizeSuccess() {
        $this->setMockHttpResponse('PurchaseSuccess.txt');
        $response = $this->gateway->authorize($this->options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertContains($response->getTransactionReference(), "bar123", "The identifier from the response");
        $this->assertSame($response->getCode(), "200", "Response Code is 200");
        $this->assertSame($response->getMessage(), "OK", "Response Message is 'OK'");
        $this->assertContains('https://payment.swipehq.com/?identifier_id=bar123', $response->getRedirectUrl());
        $this->assertSame('GET', $response->getRedirectMethod());
        
    }


    public function testPurchaseFailure() {
        $this->setMockHttpResponse('PurchaseFailure.txt');
        $response = $this->gateway->purchase($this->options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame($response->getCode(), "400", "Response Code is 400");
        $this->assertSame('Access Denied', $response->getMessage(), "Response Message is 'Access Denied'");
    }


    public function testAuthorizeFailure() {
        $this->setMockHttpResponse('PurchaseFailure.txt');
        $response = $this->gateway->authorize($this->options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame($response->getCode(), "400", "Response Code is 400");
        $this->assertSame('Access Denied', $response->getMessage(), "Response Message is 'Access Denied'");
    }


    public function testCompletePurchaseSuccess() {
        $this->getHttpRequest()->request->replace(array('identifier_id' => 'bar123'));
        $this->setMockHttpResponse('CompletePurchaseSuccess.txt');
        $response = $this->gateway->completePurchase($this->options)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame($response->getCode(), "200", "Response Code is 200");
        $this->assertSame('OK', $response->getMessage(), "Response Message is 'OK'");
        $this->assertSame('d123456', $response->getTransactionReference());
        
    }


    /**
     * @expectedException Omnipay\Common\Exception\InvalidResponseException
     */
    public function testCompleteAuthorizeInvalid() {
        $this->getHttpRequest()->query->replace(array('identifier_id' => 'fake'));
        $response = $this->gateway->completePurchase($this->options)->send();
    }


    public function testCompletePurchaseFailure() {
        $this->getHttpRequest()->request->replace(array('identifier_id' => 'bar123'));
        $this->setMockHttpResponse('CompletePurchaseFailure.txt');
        $response = $this->gateway->completePurchase($this->options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame($response->getCode(), "200", "Response Code is 200");
        $this->assertContains($response->getTransactionReference(), "getstuffed");
        $this->assertSame('OK', $response->getMessage());
        $this->assertSame('declined', $response->getStatus());
        $this->assertSame('no', $response->getTransactionApproved());
    }

}
