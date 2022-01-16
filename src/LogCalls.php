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

	private $calls;

	/**
	 * @param LogCall[] $calls
	 */
	public function __construct( LogCall... $calls ) {
		$this->calls = $calls;
	}

	#[\ReturnTypeWillChange]
	public function getIterator() {
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

	#[\ReturnTypeWillChange]
	/**
	 * @since 2.1
	 * @return int
	 */
	public function count() {
		return count( $this->calls );
	}

}
