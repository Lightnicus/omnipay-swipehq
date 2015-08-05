# Omnipay: Swipehq

**Swipe HQ driver for the Omnipay PHP payment processing library**

Swipe HQ Website: http://www.swipehq.co.nz

[Omnipay](https://github.com/omnipay/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements Swipehq support for Omnipay v 1.1.

Omnipay uses [Symphony2's HttpFoundation Component](http://symfony2-document.readthedocs.org/en/latest/components/http_foundation.html) through [Guzzle](http://docs.guzzlephp.org/en/latest/).  [Symphony2's HttpFoundation Component] replaces some default PHP global variables and functions by an Object-Oriented layer.  [Guzzle] is a PHP HTTP client that makes it easy to send and receive HTTP requests.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "repositories": [
            {
                "type": "vcs",
                "url": "https://github.com/antonythorpe/omnipay-swipehq"
            }
        ],
    "require": {
        "antonythorpe/omnipay-swipehq": "1.0.2"
    }
}
```
Reference: https://getcomposer.org/doc/05-repositories.md#using-private-repositories

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

  
## Getting Started

- Swipe HQ is an Offsite Payment Gateway so for the Live Payment Notifications (Swipe HQ's servers to yours) to work, you will need a staging server.  The Live Payment Notifications will not be able to find your localhost.


## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.
