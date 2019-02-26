<?php
namespace Able\Validation\Filters;

use \Able\Validation\Abstractions\AFilter;
use \Able\Helpers\Src;
use \Able\Reglib\Regex;

class Min extends AFilter {

	/**
	 * @var bool
	 */
	protected $required = true;

	/**
	 * @var string
	 */
	protected $message = 'The %{name} must be at least %{argument} characters!';

	/**
	 * @param string $argument
	 * @throws \Exception
	 */
	public final function setArgument(string $argument): void {
		if (!Regex::checkNumber($argument) || (int)$argument < 0) {
			throw new \Exception(sprintf('Invalid argument for function min: %s!', $argument));
		}

		parent::setArgument($argument);
	}

	/**
	 * @param string $source
	 * @return bool
	 */
	public final function check(string $source): bool {
		return strlen($source) >= (int)$this->getArgument();
	}
}
