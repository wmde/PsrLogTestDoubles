<?php

declare( strict_types = 1 );

namespace WMDE\PsrLogTestDoubles\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;
use WMDE\PsrLogTestDoubles\LogCall;
use WMDE\PsrLogTestDoubles\LogCalls;

/**
 * @covers \WMDE\PsrLogTestDoubles\LogCalls
 *
 * @license GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LogCallsTest extends TestCase {

	public function testWhenThereAreNoLogCalls_getMessagesReturnsEmptyArray() {
		$this->assertSame( [], ( new LogCalls() )->getMessages() );
	}

	public function testWhenMultipleThingsAreLogged_getLogMessagesReturnsAllMessages() {
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

	public function testCanUseCollectionAsTraversable() {
		$logCalls = new LogCalls( new LogCall( LogLevel::INFO, 'And so it begins' ) );

		$this->assertContains( new LogCall( LogLevel::INFO, 'And so it begins' ), $logCalls, '', false, false );
		$this->assertNotContains( new LogCall( LogLevel::DEBUG, 'And so it begins' ), $logCalls, '', false, false );
	}

	public function testWhenThereAreNoLogCalls_getFirstCallReturnsNull() {
		$this->assertNull( ( new LogCalls() )->getFirstCall() );
	}

	public function testWhenMultipleThingsAreLogged_getFirstCallReturnsTheFirst() {
		$logCalls = new LogCalls(
			new LogCall( LogLevel::INFO, 'And so it begins', [ 'year' => 2258 ] ),
			new LogCall( LogLevel::ALERT, "There's a hole in your mind" )
		);

		$this->assertSame( LogLevel::INFO, $logCalls->getFirstCall()->getLevel() );
		$this->assertSame( 'And so it begins', $logCalls->getFirstCall()->getMessage() );
		$this->assertSame( [ 'year' => 2258 ], $logCalls->getFirstCall()->getContext() );
	}

	public function testImplementsCountable() {
		$logCalls = new LogCalls(
			new LogCall( LogLevel::INFO, 'And so it begins', [ 'year' => 2258 ] ),
			new LogCall( LogLevel::ALERT, "There's a hole in your mind" ),
			new LogCall( LogLevel::INFO, 'And so it begins' )
		);

		$this->assertCount( 3, $logCalls );
	}

}
