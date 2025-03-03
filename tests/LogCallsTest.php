<?php

declare( strict_types = 1 );

namespace WMDE\PsrLogTestDoubles\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;
use WMDE\PsrLogTestDoubles\LogCall;
use WMDE\PsrLogTestDoubles\LogCalls;

/**
 * @covers \WMDE\PsrLogTestDoubles\LogCalls
 * @covers \WMDE\PsrLogTestDoubles\LogCall
 */
class LogCallsTest extends TestCase {

	public function testWhenThereAreNoLogCalls_getMessagesReturnsEmptyArray(): void {
		$this->assertSame( [], ( new LogCalls() )->getMessages() );
	}

	public function testWhenMultipleThingsAreLogged_getLogMessagesReturnsAllMessages(): void {
		$logCalls = new LogCalls(
			new LogCall( LogLevel::INFO, 'And so it begins', [ 'year' => 2258 ] ),
			new LogCall( LogLevel::ALERT, "There's a hole in your mind" ),
			new LogCall( LogLevel::INFO, 'And so it begins' )
		);

		$this->assertSame(
			[
				'And so it begins',
				"There's a hole in your mind",
				'And so it begins'
			],
			$logCalls->getMessages()
		);
	}

	public function testCanUseCollectionAsTraversable(): void {
		$this->assertEquals(
			[
				new LogCall( LogLevel::INFO, 'And so it begins' )
			],
			iterator_to_array(
				new LogCalls( new LogCall( LogLevel::INFO, 'And so it begins' ) )
			)
		);
	}

	public function testWhenThereAreNoLogCalls_getFirstCallReturnsNull(): void {
		$this->assertNull( ( new LogCalls() )->getFirstCall() );
	}

	public function testWhenMultipleThingsAreLogged_getFirstCallReturnsTheFirst(): void {
		$logCalls = new LogCalls(
			new LogCall( LogLevel::INFO, 'And so it begins', [ 'year' => 2258 ] ),
			new LogCall( LogLevel::ALERT, "There's a hole in your mind" )
		);

		$firstCall = $logCalls->getFirstCall();
		$this->assertNotNull( $firstCall );
		$this->assertSame( LogLevel::INFO, $firstCall->getLevel() );
		$this->assertSame( 'And so it begins', $firstCall->getMessage() );
		$this->assertSame( [ 'year' => 2258 ], $firstCall->getContext() );
	}

	public function testImplementsCountable(): void {
		$logCalls = new LogCalls(
			new LogCall( LogLevel::INFO, 'And so it begins', [ 'year' => 2258 ] ),
			new LogCall( LogLevel::ALERT, "There's a hole in your mind" ),
			new LogCall( LogLevel::INFO, 'And so it begins' )
		);

		$this->assertCount( 3, $logCalls );
	}

	public function testGetLastCallReturnsLastCall(): void {
		$logCalls = new LogCalls(
			new LogCall( LogLevel::INFO, 'And so it begins', [ 'year' => 2258 ] ),
			new LogCall( LogLevel::ALERT, "There's a hole in your mind" )
		);

		$lastCall = $logCalls->getLastCall();
		$this->assertNotNull( $lastCall );
		$this->assertSame(
			"There's a hole in your mind",
			$lastCall->getMessage()
		);
	}

	public function testWhenThereAreNoLogCalls_getLastCallReturnsNull(): void {
		$this->assertNull( ( new LogCalls() )->getLastCall() );
	}

	public function testFilter(): void {
		$logCalls = new LogCalls(
			new LogCall( LogLevel::INFO, 'And so it begins', [ 'year' => 2258 ] ),
			new LogCall( LogLevel::ALERT, "There's a hole in your mind" ),
			new LogCall( LogLevel::INFO, 'And so it begins' ),
			new LogCall( LogLevel::CRITICAL, 'Enemy sighted' ),
		);

		$this->assertEquals(
			new LogCalls(
				new LogCall( LogLevel::INFO, 'And so it begins', [ 'year' => 2258 ] ),
				new LogCall( LogLevel::INFO, 'And so it begins' ),
			),
			$logCalls->filter( fn( LogCall $call ) => $call->getLevel() === LogLevel::INFO )
		);
	}

	public function testGetErrors(): void {
		$logCalls = new LogCalls(
			new LogCall( LogLevel::INFO, 'And so it begins', [ 'year' => 2258 ] ),
			new LogCall( LogLevel::ALERT, "There's a hole in your mind" ),
			new LogCall( LogLevel::INFO, 'And so it begins' ),
			new LogCall( LogLevel::CRITICAL, 'Enemy sighted' ),
		);

		$this->assertEquals(
			new LogCalls(
				new LogCall( LogLevel::ALERT, "There's a hole in your mind" ),
				new LogCall( LogLevel::CRITICAL, 'Enemy sighted' ),
			),
			$logCalls->getErrors()
		);
	}

	public function testMap(): void {
		$logCalls = new LogCalls(
			new LogCall( LogLevel::INFO, 'And so it begins', [ 'year' => 2258 ] ),
			new LogCall( LogLevel::ALERT, "There's a hole in your mind", [ 'year' => 2260 ] ),
		);

		$this->assertEquals(
			new LogCalls(
				new LogCall( LogLevel::INFO, 'And so it begins' ),
				new LogCall( LogLevel::ALERT, "There's a hole in your mind" ),
			),
			$logCalls->map( fn( LogCall $call ) => $call->withoutContext() )
		);
	}

	public function testWithoutContexts(): void {
		$logCalls = new LogCalls(
			new LogCall( LogLevel::INFO, 'And so it begins', [ 'year' => 2258 ] ),
			new LogCall( LogLevel::ALERT, "There's a hole in your mind", [ 'year' => 2260 ] ),
		);

		$this->assertEquals(
			new LogCalls(
				new LogCall( LogLevel::INFO, 'And so it begins' ),
				new LogCall( LogLevel::ALERT, "There's a hole in your mind" ),
			),
			$logCalls->withoutContexts()
		);
	}

}
