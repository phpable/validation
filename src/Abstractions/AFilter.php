<?php
namespace Able\Validation\Abstractions;

use \Able\Helpers\Src;

use \Able\Prototypes\IArrayable;
use \Able\Prototypes\IStringable;
use \Able\Prototypes\TStringable;

abstract class AFilter
	implements IStringable, IArrayable {

	use TStringable;

	/**
	 * @var string
	 */
	private $argument = null;

	/**
	 * @param string $argument
	 * @return void
	 */
	public function setArgument(string $argument): void {
		$this->argument = $argument;
	}

	/**
	 * @return string
	 */
	public final function getArgument(): string {
		return $this->argument;
	}

	/**
	 * @var bool
	 */
	protected $required = false;

	/**
	 * @const string
	 */
 	protected $message = "The %{name} field is invalid!";

	/**
	 * @return string
	 */
	public final function toString(): string {
		return $this->message;
	}

	/**
	 * @return array
	 */
	public final function toArray(): array {
		return [
			'filter' => Src::rns(static::class),
			'argument' => $this->argument,
		];
	}

	/**
	 * @param string|null $argument
	 * @throws \Exception
	 */
	public final function __construct(string $argument = null) {
		if ($this->required && is_null($argument)){
			throw new \Exception("The argument is required!");
		}

		if (!is_null($argument)) {
			$this->setArgument($argument);
		}
	}

	/**
	 * @param string $source
	 * @param array $Related
	 * @return bool
	 */
	abstract function check(string $source, array $Related = []): bool;
}
