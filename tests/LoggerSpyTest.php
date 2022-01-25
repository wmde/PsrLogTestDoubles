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

	public function testWhenNothingIsLogged_getLogCallsReturnsEmptyArray(): void {
		$loggerSpy = new LoggerSpy();

		$this->assertEquals( new LogCalls(), $loggerSpy->getLogCalls() );
	}

	public function testWhenLogIsCalled_getLogCallsReturnsAllCalls(): void {
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

	public function testWhenShortcutMethodsAreCalled_getLogCallsReturnsAllCalls(): void {
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

	public function testWhenLoggerWasCalled_assertNoCallsThrowsException(): void {
		$loggerSpy = new LoggerSpy();
		$loggerSpy->alert( "There's a hole in your mind" );

		$this->expectException( AssertionException::class );
		$loggerSpy->assertNoLoggingCallsWhereMade();
	}

	public function testWhenLoggerWasNotCalled_assertNoCallsDoesNotThrowException(): void {
		$loggerSpy = new LoggerSpy();

		$loggerSpy->assertNoLoggingCallsWhereMade();

		$this->assertTrue( true );
	}

	public function testWhenThereAreNoLogCalls_getFirstLogCallReturnsNull() {
		$this->assertNull( ( new LoggerSpy() )->getFirstLogCall() );
	}

	public function testWhenMultipleThingsAreLogged_getFirstLogCallReturnsTheFirst(): void {
		$loggerSpy = new LoggerSpy();

		$loggerSpy->info( 'And so it begins', [ 'year' => 2258 ] );
		$loggerSpy->alert( "There's a hole in your mind" );

		$this->assertSame( LogLevel::INFO, $loggerSpy->getFirstLogCall()->getLevel() );
		$this->assertSame( 'And so it begins', $loggerSpy->getFirstLogCall()->getMessage() );
		$this->assertSame( [ 'year' => 2258 ], $loggerSpy->getFirstLogCall()->getContext() );
	}

}
