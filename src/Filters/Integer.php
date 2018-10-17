<?php
namespace Able\Validation\Filters;

use \Able\Reglib\Regex;
use \Able\Helpers\Src;

use \Able\Validation\Abstractions\AFilter;

class Integer extends AFilter {

	/**
	 * @var string
	 */
	protected string $message = "The %{name} must be an integer!";

	/**
	 * @param string $source
	 * @param array $Related
	 * @return bool
	 */
	public final function check(string $source, array $Related = []): bool {
		return Regex::checkNumber($source);
	}
}
