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

	public function log( $level, $message, array $context = [] ) {
		$this->logCalls[] = [
			'level' => $level,
			'message' => $message,
			'context' => $context
		];
	}

	public function getLogCalls(): array {
		return $this->logCalls;
	}

}
