# PSR Log Test Doubles

[![Build Status](https://secure.travis-ci.org/wmde/PsrLogTestDoubles.png?branch=master)](http://travis-ci.org/wmde/PsrLogTestDoubles)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/wmde/PsrLogTestDoubles/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/wmde/PsrLogTestDoubles/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/wmde/PsrLogTestDoubles/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/wmde/PsrLogTestDoubles/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/wmde/psr-log-test-doubles/version.png)](https://packagist.org/packages/wmde/psr-log-test-doubles)
[![Download count](https://poser.pugx.org/wmde/psr-log-test-doubles/d/total.png)](https://packagist.org/packages/wmde/psr-log-test-doubles)

[Test Doubles][doubles] for the [PSR-3 Logger Interface][psr-3]

## Motivation

In PHP world, most people create Test Doubles via PHPUnits mocking framework (`$this->createMock`).
(Please beware that a [PHPUnit mock really is a Test Double][better-mocks] and not necessarily a mock.)
While this framework is often helpful, using it instead of creating your own Test Doubles comes with
some cost:

* Tools do not understand the PHPUnit magic. You will not be able to use automated refactorings such
as method rename without your Test Doubles breaking. You will also get incorrect type warnings.
* When using `LoggerInterface`, your test will bind to an implementation detail: if you use `log` and
provide a log level, or call a shortcut method such as `error`.
* Developers need to be familiar with the mocking tool.
* Simple things such as asserting the logger got called with two messages become difficult.

## Usage

This library is unit testing tool agnostic. So while these examples use PHPUnit, any testing tool can be used.

**Assert the logger is called twice with expected messages**

```php
public function testWhenStuffIsDone_loggerGetsCalled() {
    $logger = new LoggerSpy();

    $serviceToTest = new ServiceToTest( $logger /*, other dependencies */ );
    $serviceToTest->doStuff( /**/ );

    $this->assertSame(
        [ 'First message', 'Second message' ],
        $logger->getLogCalls()->getMessages()
    );
}
```

**Assert the logger is called twice**

```php
$this->assertCount( 2, $logger->getLogCalls() );
```

**Assert the message and log level of the first logger call**

```php
$firstLogCall = $logger->getFirstLogCall();

$this->assertSame( 'First message', $firstLogCall->getMessage() );
$this->assertSame( LogLevel::ERROR, $firstLogCall->getLevel() );
```

## Release notes

### 3.0.0 (2022-01-26)

* Added support for `psr/log` 2.x and 3.x
* Changed minimum PHP version from PHP 7.1 to 8.0
* Added several property, parameter and return types
* Added Psalm and PHPStan CI and compliance with level 1 checks

### 2.2.0 (2017-05-23)

* Added `LoggerSpy::getFirstLogCall` convenience method
* Changed minimum PHP version from PHP 7.0 to 7.1

### 2.1.0 (2017-01-17)

* `LogCalls` now implements `Countable`

### 2.0.0 (2017-01-16)

* `LoggerSpy::getLogCalls` now returns an instance of `LogCalls`, which is a collection of `LogCall`
* Added `LogCalls::getMessages`
* Added `LogCalls::getFirstCall`

### 1.1.0 (2016-11-11)

* Added `LoggerSpy::assertNoLoggingCallsWhereMade`

### 1.0.0 (2016-10-18)

* Initial release with minimal `LoggerSpy`

[doubles]: https://en.wikipedia.org/wiki/Test_double
[psr-3]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md
[better-mocks]: https://www.entropywins.wtf/blog/2016/05/13/5-ways-to-write-better-mocks/
