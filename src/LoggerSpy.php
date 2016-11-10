<?php

declare( strict_types = 1 );

namespace WMDE\PsrLogTestDoubles;

use Psr\Log\AbstractLogger;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LoggerSpy extends AbstractLogger {

	private $logCalls = [];

	/**
	 * @since 1.0
	 */
	public function log( $level, $message, array $context = [] ) {
		$this->logCalls[] = [
			'level' => $level,
			'message' => $message,
			'context' => $context
		];
	}

	/**
	 * @since 1.0
	 */
	public function getLogCalls(): array {
		return $this->logCalls;
	}

	/**
	 * @since 1.1
	 * @throws AssertionException
	 */
	public function assertNoLoggingCallsWhereMade() {
		if ( !empty( $this->logCalls ) ) {
			throw new AssertionException(
				'Logger calls where made while non where expected: ' . var_export( $this->logCalls, true )
			);
		}
	}

}
