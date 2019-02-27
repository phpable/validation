<?php
namespace Able\Validation\Utilities;

use \Able\Helpers\Str;

use \Able\Prototypes\ICountable;
use \Able\Prototypes\IArrayable;
use \Able\Prototypes\IStringable;
use \Able\Prototypes\IIteratable;
use \Able\Prototypes\TStringable;

use \Able\Validation\Structures\SError;

class Decision
	implements ICountable, IStringable, IIteratable, IArrayable {

	use TStringable;

	/**
	 * @var SError[]
	 */
	private $Errors = [];

	/**
	 * @return bool
	 */
	public final function fails(): bool {
		return count($this->Errors) > 0;
	}

	/**
	 * @param array $Errors
	 * @throws \Exception
	 */
	public final function __construct(array $Errors = []) {
		foreach ($Errors as $Error){
			if (!($Error instanceof SError)) {
				throw new \Exception(sprintf('Invalid error type: %s!', get_class($Error)));
			}

			array_push($this->Errors, $Error);
		}
	}

	/**
	 * @return \Generator
	 */
	public final function iterate(): \Generator {
		foreach ($this->Errors as $Error){
			yield $Error;
		}
	}

	/**
	 * @return int
	 */
	public final function count(): int {
		return count($this->Errors);
	}

	/**
	 * @return array
	 */
	public final function toArray(): array {
		return array_map(function(SError $Error){
			return $Error->message; }, $this->Errors);
	}

	/**
	 * @return string
	 */
	public final function toString(): string {
		return Str::join("\n", $this->toArray());
	}

}
