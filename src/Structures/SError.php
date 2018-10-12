<?php
namespace Able\Validation\Structures;

use \Able\Struct\AStruct;

use \Able\Prototypes\IStringable;
use \Able\Prototypes\TStringable;

/**
 * @property string name
 * @property string message
 */
class SError extends AStruct
	implements IStringable {

	use TStringable;

	/**
	 * @var array
	 */
	protected static array $Prototype = ['name', 'message'];

	/**
	 * @param string $value
	 * @return string
	 */
	public final function setNameProperty(string $value): string {
		return $value;
	}

	/**
	 * @param string $value
	 * @return string
	 */
	public final function setMessageProperty(string $value): string {
		return $value;
	}

	/**
	 * @return string
	 */
	public final function toString(): string {
		return $this->message;
	}
}
