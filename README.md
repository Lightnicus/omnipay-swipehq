# Omnipay: Swipehq

**Swipehq driver for the Omnipay PHP payment processing library**

Swipehq Website: http://www.swipehq.co.nz

[Omnipay](https://github.com/omnipay/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements Swipehq support for Omnipay.

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
        "antonythorpe/omnipay-swipehq": "dev-master"
    }
}
```
Reference: https://getcomposer.org/doc/05-repositories.md#using-private-repositories

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Issues

1) The current version of this library takes the user offsite to process a credit card but has trouble with the following Authorise Complete stage, when a verify transaction API is sent.  Presently, it returns a 404 Error.  Unforetunately, there is no access here to the initial identifier or transaction id (which might help?).  Next, will implement the Live Payment Notification feature and test this on a staging site.  The verify transaction API call can be made following receipt of a Live Payment Notification.

2) The tests have been copied from another driver library.

Pull request welcome!

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.
