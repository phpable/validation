<?php
namespace Able\Validation\Filters;

use \Able\Validation\Abstractions\AFilter;
use \Able\Helpers\Src;

class Url extends AFilter {

	/**
	 * @var string
	 */
	protected $message = "The %{name} format is invalid!";

	/**
	 * @param string $source
	 * @return bool
	 */
	public final function check(string $source): bool {
		return (bool)filter_var($source, FILTER_VALIDATE_URL);
	}
}
