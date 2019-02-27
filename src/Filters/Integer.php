<?php
namespace Able\Validation\Filters;

use Able\Reglib\Regex;
use \Able\Validation\Abstractions\AFilter;
use \Able\Helpers\Src;

class Integer extends AFilter {

	/**
	 * @var string
	 */
	protected $message = "The %{name} must be an integer!";

	/**
	 * @param string $source
	 * @param array $Related
	 * @return bool
	 */
	public final function check(string $source, array $Related = []): bool {
		return Regex::checkNumber($source);
	}
}
