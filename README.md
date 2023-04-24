# Unique email address

[![Build Status](https://app.travis-ci.com/szepeviktor/unique-email-address.svg?branch=master)](https://app.travis-ci.com/szepeviktor/unique-email-address)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/szepeviktor/unique-email-address.svg)](https://packagist.org/packages/szepeviktor/unique-email-address)

Normalizes an email address. It removes tags, separators like `+something` and `.` in Gmail.

- extendable
- 100% flexible configuration
- tells whether a valid email address belongs to the configured domains
- normalizes an address
- compares two addresses

Inspired by https://github.com/imliam/php-unique-gmail-address :heavy_check_mark:

### Installation

```bash
composer require szepeviktor/unique-email-address
```

### Usage

```php
$gmail = new Gmail();
$address = 'firstname.LASTname+label@gmail.com';
$gmail->isLocal($address); // true
$gmail->normalize($address); // 'firstnamelastname@gmail.com'
```
