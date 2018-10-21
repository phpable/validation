<?php
namespace Able\Validation\Filters;

use \Able\Validation\Abstractions\AFilter;
use \Able\Helpers\Src;

class Email extends AFilter {

	/**
	 * @var string
	 */
	protected string $message = "The %{name} must be a valid email address!";

	/**
	 * @param string $source
	 * @param array $Related
	 * @return bool
	 */
	public final function check(string $source, array $Related = []): bool {
		return (bool)filter_var($source, FILTER_VALIDATE_EMAIL);
	}
}
