<?php

declare( strict_types = 1 );

namespace WMDE\PsrLogTestDoubles;

use Psr\Log\LogLevel;

/**
 * Value object representing a call to the logger
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LogCall {

	private const ERROR_LEVELS = [ LogLevel::ERROR, LogLevel::CRITICAL, LogLevel::ALERT, LogLevel::EMERGENCY ];

	private mixed $level;
	private string $message;
	private array $context;

	public function __construct( mixed $level, string $message, array $context = [] ) {
		$this->level = $level;
		$this->message = $message;
		$this->context = $context;
	}

	public function getLevel(): mixed {
		return $this->level;
	}

	public function getMessage(): string {
		return $this->message;
	}

	public function getContext(): array {
		return $this->context;
	}

	/**
	 * Returns if the log level is error or above.
	 * @since 3.2
	 */
	public function isError(): bool {
		return in_array( $this->level, self::ERROR_LEVELS );
	}

	/**
	 * @since 3.2
	 */
	public function withoutContext(): self {
		return new self( $this->level, $this->message, [] );
	}

}
