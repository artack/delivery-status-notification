# Parser for Delivery Status Notifications (RFC 3464 &amp; RFC 1894)

![Packagist](https://img.shields.io/packagist/v/ARTACK/delivery-status-notification.svg?style=flat-square)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/ARTACK/delivery-status-notification/master.svg?style=flat-square)](https://travis-ci.org/ARTACK/delivery-status-notification)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/ARTACK/delivery-status-notification.svg?style=flat-square)](https://scrutinizer-ci.com/g/ARTACK/delivery-status-notification/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/ARTACK/delivery-status-notification.svg?style=flat-square)](https://scrutinizer-ci.com/g/ARTACK/delivery-status-notification)
[![Total Downloads](https://img.shields.io/packagist/dt/ARTACK/delivery-status-notification.svg?style=flat-square)](https://packagist.org/packages/ARTACK/delivery-status-notification)

This package provides a parser for delivery status notifications (RFC 3464 &amp; RFC 1894).

## Installation

To install, use composer:

```
composer require artack/delivery-status-notification
```

## Usage
The DSN Model can be parsed by using the static method `from()`.

``` php
use Artack\Dsn\DeliveryStatusNotification;

$dsn = DeliveryStatusNotification::from($dsnMimePartContent);
```

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Credits

- [mailXpert GmbH](https://github.com/ARTACK)
- [ARTACK WebLab GmbH](https://github.com/artack)
- [All Contributors](https://github.com/ARTACK/delivery-status-notification/contributors)


## License

The MIT License (MIT). Please see [License File](https://github.com/ARTACK/delivery-status-notification/blob/master/LICENSE) for more information.

## Resources
- [RFC 3464](https://tools.ietf.org/html/rfc3464)
- [RFC 1894](https://tools.ietf.org/html/rfc1894)
- [RFC 822](https://tools.ietf.org/html/rfc822)
- [IANA DSN Types](https://www.iana.org/assignments/dsn-types/dsn-types.xhtml)
- [IANA SMTP Enhanced Status Code](https://www.iana.org/assignments/smtp-enhanced-status-codes/smtp-enhanced-status-codes.xhtml)
