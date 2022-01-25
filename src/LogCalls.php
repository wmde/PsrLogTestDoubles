<?php

declare( strict_types = 1 );

namespace WMDE\PsrLogTestDoubles;

/**
 * Immutable and ordered collection of LogCall objects
 *
 * @since 2.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LogCalls implements \IteratorAggregate, \Countable {

	/**
	 * @var LogCall[]
	 */
	private array $calls;

	public function __construct( LogCall... $calls ) {
		$this->calls = $calls;
	}

	public function getIterator(): \ArrayIterator {
		return new \ArrayIterator( $this->calls );
	}

	/**
	 * @return string[]
	 */
	public function getMessages(): array {
		return array_map(
			function( LogCall $logCall ) {
				return $logCall->getMessage();
			},
			$this->calls
		);
	}

	public function getFirstCall(): ?LogCall {
		return empty( $this->calls ) ? null : $this->calls[0];
	}

	/**
	 * @since 2.1
	 * @return int
	 */
	public function count(): int {
		return count( $this->calls );
	}

}
