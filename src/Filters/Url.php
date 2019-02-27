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
	 * @param array $Related
	 * @return bool
	 */
	public final function check(string $source, array $Related = []): bool {
		return (bool)filter_var($source, FILTER_VALIDATE_URL);
	}
}
