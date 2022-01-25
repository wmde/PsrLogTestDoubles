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

}
