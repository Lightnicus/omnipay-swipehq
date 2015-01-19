<?php

namespace Omnipay\Swipehq\Message;

/**
 * Swipehq Payment Page Purchase Request (step 3 - purchase method)
 */


class PaymentPagePurchaseRequest extends PaymentPageAuthorizeRequest {
    
    protected $action = 'Payable';

}
