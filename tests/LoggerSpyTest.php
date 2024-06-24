<?php

declare( strict_types = 1 );

namespace WMDE\PsrLogTestDoubles\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;
use WMDE\PsrLogTestDoubles\AssertionException;
use WMDE\PsrLogTestDoubles\LogCall;
use WMDE\PsrLogTestDoubles\LogCalls;
use WMDE\PsrLogTestDoubles\LoggerSpy;

/**
 * @covers \WMDE\PsrLogTestDoubles\LoggerSpy
 */
#[CoversClass( LoggerSpy::class )]
#[CoversClass( LogCall::class )]
#[CoversClass( LogCalls::class)]
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

	#[DoesNotPerformAssertions]
	public function testWhenLoggerWasNotCalled_assertNoCallsDoesNotThrowException(): void {
		$loggerSpy = new LoggerSpy();

		$loggerSpy->assertNoLoggingCallsWhereMade();
	}

	public function testWhenThereAreNoLogCalls_getFirstLogCallReturnsNull(): void {
		$this->assertNull( ( new LoggerSpy() )->getFirstLogCall() );
	}

	public function testWhenMultipleThingsAreLogged_getFirstLogCallReturnsTheFirst(): void {
		$loggerSpy = new LoggerSpy();

		$loggerSpy->info( 'And so it begins', [ 'year' => 2258 ] );
		$loggerSpy->alert( "There's a hole in your mind" );

		$firstLogCall = $loggerSpy->getFirstLogCall();

		$this->assertNotNull( $firstLogCall );
		$this->assertSame( LogLevel::INFO, $firstLogCall->getLevel() );
		$this->assertSame( 'And so it begins', $firstLogCall->getMessage() );
		$this->assertSame( [ 'year' => 2258 ], $firstLogCall->getContext() );
	}

}
