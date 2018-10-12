<?php
namespace Able\Validation\Abstractions;

use \Able\Helpers\Src;

use \Able\Prototypes\IStringable;
use \Able\Prototypes\TStringable;

abstract class AFilter
	implements IStringable {

	use TStringable;

	/**
	 * @var string
	 */
	private string $argument = '';

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
	protected bool $required = false;

	/**
	 * @const string
	 */
 	protected string $message = "The %{name} field is invalid!";

	/**
	 * @return string
	 */
	public final function toString(): string {
		return $this->message;
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
