<?php

declare( strict_types = 1 );

namespace WMDE\PsrLogTestDoubles;

/**
 * Value object representing a call to the logger
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LogCall {

	private $level;
	private $message;
	private $context;

	/**
	 * @param mixed $level Typically one of the @see LogLevel constants
	 * @param string $message
	 * @param array $context
	 */
	public function __construct( $level, string $message, array $context = [] ) {
		$this->level = $level;
		$this->message = $message;
		$this->context = $context;
	}

	/**
	 * @return mixed Typically one of the @see LogLevel constants
	 */
	public function getLevel() {
		return $this->level;
	}

	public function getMessage(): string {
		return $this->message;
	}

	public function getContext(): array {
		return $this->context;
	}

}
