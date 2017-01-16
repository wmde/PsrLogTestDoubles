# PSR Log Test Doubles

[![Build Status](https://secure.travis-ci.org/wmde/PsrLogTestDoubles.png?branch=master)](http://travis-ci.org/wmde/PsrLogTestDoubles)
[![Latest Stable Version](https://poser.pugx.org/wmde/psr-log-test-doubles/version.png)](https://packagist.org/packages/wmde/psr-log-test-doubles)
[![Download count](https://poser.pugx.org/wmde/psr-log-test-doubles/d/total.png)](https://packagist.org/packages/wmde/psr-log-test-doubles)

[Test Doubles][doubles] for the [PSR-3 Logger Interface][psr-3]

## Release notes

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