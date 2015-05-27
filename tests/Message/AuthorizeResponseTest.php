<?php

namespace Omnipay\Swipehq\Message;
use Omnipay\TestCase;

class PxPayAuthorizeResponseTest extends TestCase{
    
    public function testPurchaseSuccess(){
        $httpResponse = $this->getMockHttpResponse('PurchaseSuccess.txt');
        $response = new PaymentPageAuthorizeResponse($this->getMockRequest(), $httpResponse->json());

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertContains($response->getTransactionReference(), "bar123", "The identifier from the response");
        $this->assertSame($response->getCode(), "200", "Response Code is 200");
        $this->assertSame($response->getMessage(), "OK", "Response Message is 'OK'");
        $this->assertSame('GET', $response->getRedirectMethod());
    }

    public function testPurchaseFailure(){
        $httpResponse = $this->getMockHttpResponse('PurchaseFailure.txt');
        $response = new PaymentPageAuthorizeResponse($this->getMockRequest(), $httpResponse->json());

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame($response->getCode(), "400", "Response Code is 400");
        $this->assertSame('Access Denied', $response->getMessage(), "Response Message is 'Access Denied'");
    }
    
}
