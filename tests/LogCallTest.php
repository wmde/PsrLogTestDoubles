<?php

declare( strict_types = 1 );

namespace WMDE\PsrLogTestDoubles\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;
use WMDE\PsrLogTestDoubles\LogCall;

/**
 *
 * @license GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
#[CoversClass( LogCall::class)]
class LogCallTest extends TestCase {

	public function testIsNotError(): void {
		$this->assertFalse( ( new LogCall( LogLevel::DEBUG, '' ) )->isError() );
		$this->assertFalse( ( new LogCall( LogLevel::NOTICE, '' ) )->isError() );
	}

	public function testIsError(): void {
		$this->assertTrue( ( new LogCall( LogLevel::ERROR, '' ) )->isError() );
		$this->assertTrue( ( new LogCall( LogLevel::EMERGENCY, '' ) )->isError() );
		$this->assertTrue( ( new LogCall( LogLevel::ALERT, '' ) )->isError() );
		$this->assertTrue( ( new LogCall( LogLevel::CRITICAL, '' ) )->isError() );
	}

	public function testWithoutContextRemovesContext(): void {
		$call = new LogCall( LogLevel::DEBUG, 'whatever', [ 'foo' => 'bar' ] );

		$this->assertEquals(
			new LogCall( LogLevel::DEBUG, 'whatever', [] ),
			$call->withoutContext()
		);

		$this->assertSame(
			[ 'foo' => 'bar' ],
			$call->getContext()
		);
	}

}
