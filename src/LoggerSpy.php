<?php

declare( strict_types = 1 );

namespace WMDE\PsrLogTestDoubles;

use Psr\Log\AbstractLogger;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LoggerSpy extends AbstractLogger {

	/**
	 * @var array<int, LogCall>
	 */
	private array $logCalls = [];

	/**
	 * Signature changed in 3.0
	 */
	public function log( $level, string|\Stringable $message, array $context = [] ): void {
		$this->logCalls[] = new LogCall( $level, (string)$message, $context );
	}

	/**
	 * @since 2.0
	 */
	public function getLogCalls(): LogCalls {
		return new LogCalls( ...$this->logCalls );
	}

	/**
	 * @since 2.2
	 */
	public function getFirstLogCall(): ?LogCall {
		return $this->getLogCalls()->getFirstCall();
	}

	/**
	 * @since 1.1
	 * @throws AssertionException
	 */
	public function assertNoLoggingCallsWhereMade(): void {
		if ( !empty( $this->logCalls ) ) {
			throw new AssertionException(
				'Logger calls where made while non where expected: ' . var_export( $this->logCalls, true )
			);
		}
	}

}
