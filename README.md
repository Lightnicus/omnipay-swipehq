# Omnipay: Swipehq

**Swipehq driver for the Omnipay PHP payment processing library**

Website: http://www.swipehq.co.nz

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

The current version of this library takes the user to the offsite to process the credit card but has trouble with the Authorise Complete stage, where a verify transaction API is sent.  It returns a 404 Error.  Unforetunately, there is no access here to the initial identifier (which might help?).

Tests are copied from another library

Pull request welcome!

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.
