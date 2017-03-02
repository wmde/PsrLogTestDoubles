<?php

declare( strict_types = 1 );

namespace WMDE\PsrLogTestDoubles\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;
use WMDE\PsrLogTestDoubles\AssertionException;
use WMDE\PsrLogTestDoubles\LogCall;
use WMDE\PsrLogTestDoubles\LogCalls;
use WMDE\PsrLogTestDoubles\LoggerSpy;

/**
 * @covers \WMDE\PsrLogTestDoubles\LoggerSpy
 *
 * @license GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LoggerSpyTest extends TestCase {

	public function testWhenNothingIsLogged_getLogCallsReturnsEmptyArray() {
		$loggerSpy = new LoggerSpy();

		$this->assertEquals( new LogCalls(), $loggerSpy->getLogCalls() );
	}

	public function testWhenLogIsCalled_getLogCallsReturnsAllCalls() {
		$loggerSpy = new LoggerSpy();

		$loggerSpy->log( LogLevel::INFO, 'And so it begins', [ 'year' => 2258 ] );
		$loggerSpy->log( LogLevel::ALERT, "There's a hole in your mind" );

		$this->assertEquals(
			new LogCalls(
				new LogCall( LogLevel::INFO, 'And so it begins', [ 'year' => 2258 ] ),
				new LogCall( LogLevel::ALERT, "There's a hole in your mind" )
			),
			$loggerSpy->getLogCalls()
		);
	}

	public function testWhenShotcutMethodsAreCalled_getLogCallsReturnsAllCalls() {
		$loggerSpy = new LoggerSpy();

		$loggerSpy->info( 'And so it begins', [ 'year' => 2258 ] );
		$loggerSpy->alert( "There's a hole in your mind" );

		$this->assertEquals(
			new LogCalls(
				new LogCall( LogLevel::INFO, 'And so it begins', [ 'year' => 2258 ] ),
				new LogCall( LogLevel::ALERT, "There's a hole in your mind" )
			),
			$loggerSpy->getLogCalls()
		);
	}

	public function testWhenLoggerWasCalled_assertNoCallsThrowsException() {
		$loggerSpy = new LoggerSpy();
		$loggerSpy->alert( "There's a hole in your mind" );

		$this->expectException( AssertionException::class );
		$loggerSpy->assertNoLoggingCallsWhereMade();
	}

	public function testWhenLoggerWasNotCalled_assertNoCallsDoesNotThrowException() {
		$loggerSpy = new LoggerSpy();

		$loggerSpy->assertNoLoggingCallsWhereMade();

		$this->assertTrue( true );
	}

}
