<?php

declare( strict_types = 1 );

namespace WMDE\PsrLogTestDoubles\Tests;

use Psr\Log\LogLevel;
use WMDE\PsrLogTestDoubles\LoggerSpy;

/**
 * @covers \WMDE\PsrLogTestDoubles\LoggerSpy
 *
 * @license GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LoggerSpyTest extends \PHPUnit_Framework_TestCase {

	public function testWhenNothingIsLogged_getLogCallsReturnsEmptyArray() {
		$loggerSpy = new LoggerSpy();

		$this->assertSame( [], $loggerSpy->getLogCalls() );
	}

	public function testWhenLogIsCalled_getLogCallsReturnsAllCalls() {
		$loggerSpy = new LoggerSpy();

		$loggerSpy->log( LogLevel::INFO, 'And so it begins', [ 'year' => 2258 ] );
		$loggerSpy->log( LogLevel::ALERT, "There's a hole in your mind" );

		$this->assertSame(
			[
				[
					'level' => LogLevel::INFO,
					'message' => 'And so it begins',
					'context' => [ 'year' => 2258 ]
				],
				[
					'level' => LogLevel::ALERT,
					'message' => "There's a hole in your mind",
					'context' => []
				]
			],
			$loggerSpy->getLogCalls()
		);
	}

	public function testWhenShotcutMethodsAreCalled_getLogCallsReturnsAllCalls() {
		$loggerSpy = new LoggerSpy();

		$loggerSpy->info( 'And so it begins', [ 'year' => 2258 ] );
		$loggerSpy->alert( "There's a hole in your mind" );

		$this->assertSame(
			[
				[
					'level' => LogLevel::INFO,
					'message' => 'And so it begins',
					'context' => [ 'year' => 2258 ]
				],
				[
					'level' => LogLevel::ALERT,
					'message' => "There's a hole in your mind",
					'context' => []
				]
			],
			$loggerSpy->getLogCalls()
		);
	}

}
