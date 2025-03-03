<?php

declare( strict_types = 1 );

namespace WMDE\PsrLogTestDoubles;

use Psr\Log\LogLevel;

class LogCall {

	private const ERROR_LEVELS = [ LogLevel::ERROR, LogLevel::CRITICAL, LogLevel::ALERT, LogLevel::EMERGENCY ];

	private mixed $level;
	private string $message;
	/**
	 * @var array<string, mixed>
	 */
	private array $context;

	/**
	 * @param mixed $level
	 * @param string $message
	 * @param array<string, mixed> $context
	 */
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

	/**
	 * @return array<string, mixed>
	 */
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
