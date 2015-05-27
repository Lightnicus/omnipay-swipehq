<?php

namespace Omnipay\Swipehq\Message;

use Omnipay\TestCase;

class CompleteAuthorizeResponseTest extends TestCase {
   
    public function testCompletePurchaseSuccess(){
        $httpResponse = $this->getMockHttpResponse('CompletePurchaseSuccess.txt');
        $response = new PaymentPageCompleteAuthorizeResponse($this->getMockRequest(), $httpResponse->json());

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame($response->getCode(), "200", "Response Code is 200");
        $this->assertSame('OK', $response->getMessage(), "Response Message is 'OK'");
        $this->assertSame('d123456', $response->getTransactionReference());
    }

    public function testCompletePurchaseFailure(){
        $httpResponse = $this->getMockHttpResponse('CompletePurchaseFailure.txt');
        $response = new PaymentPageCompleteAuthorizeResponse($this->getMockRequest(), $httpResponse->json());

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame($response->getCode(), "200", "Response Code is 200");
        $this->assertContains($response->getTransactionReference(), "getstuffed");
        $this->assertSame('OK', $response->getMessage());
        $this->assertSame('declined', $response->getStatus());
        $this->assertSame('no', $response->getTransactionApproved());
    }

    
}
