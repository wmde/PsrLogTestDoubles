<?php

declare( strict_types = 1 );

namespace WMDE\PsrLogTestDoubles;

use Psr\Log\LogLevel;

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
		return $this->calls[0] ?? null;
	}

	/**
	 * @since 3.1
	 */
	public function getLastCall(): ?LogCall {
		return $this->calls[count( $this->calls ) - 1] ?? null;
	}

	/**
	 * @since 2.1
	 * @return int
	 */
	public function count(): int {
		return count( $this->calls );
	}

	/**
	 * @since 3.2
	 * @param callable(LogCall):bool $filter
	 * @return self
	 */
	public function filter( callable $filter ): self {
		return new self( ...array_filter( $this->calls, $filter ) );
	}

	/**
	 * Returns log calls with log level ERROR and above.
	 * @since 3.2
	 */
	public function getErrors(): self {
		return $this->filter( fn( LogCall $call ) => $call->isError() );
	}

	/**
	 * @since 3.2
	 * @param callable(LogCall):LogCall $map
	 * @return self
	 */
	public function map( callable $map ): self {
		$calls = [];

		foreach ( $this->calls as $call ) {
			$calls[] = $map( $call );
		}

		return new self( ...$calls );
	}

	/**
	 * Returns a copy of the log calls with their contexts removed.
	 * @since 3.2
	 */
	public function withoutContexts(): self {
		return $this->map( fn( LogCall $call ) => $call->withoutContext() );
	}

}
