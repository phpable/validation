<?php
namespace Able\Validation\Filters;

use \Able\Validation\Abstractions\AFilter;
use \Able\Helpers\Src;
use \Able\Reglib\Regex;

class Less extends AFilter {

	/**
	 * @var bool
	 */
	protected $required = true;

	/**
	 * @var string
	 */
	protected $message = 'The %{name} must be at least %{argument}!';

	/**
	 * @param string $argument
	 * @throws \Exception
	 */
	public final function setArgument(string $argument): void {
		if (!Regex::checkNumber($argument) || (int)$argument <= 0) {
			throw new \Exception(sprintf('Invalid argument for function max: %s!', $argument));
		}

		parent::setArgument($argument);
	}

	/**
	 * @param string $source
	 * @return bool
	 * @throws \Exception
	 */
	public final function check(string $source): bool {
		return Regex::checkNumber($source) && (int)$source <= (int)$this->getArgument();
	}
}
