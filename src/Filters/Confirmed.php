<?php
namespace Able\Validation\Filters;

use \Able\Validation\Abstractions\AFilter;
use \Able\Helpers\Src;
use \Able\Helpers\Arr;

class Confirmed extends AFilter {

	/**
	 * @var string
	 */
	protected string $message = "The %{name} confirmation does not match!";

	/**
	 * @param string $source
	 * @param array $Related
	 * @return bool
	 */
	public final function check(string $source, array $Related = []): bool {
		return isset($Related['confirmation']) && $Related['confirmation'] == $source;
	}
}
