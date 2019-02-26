<?php
namespace Able\Validation;

use \Able\Helpers\Arr;

use \Able\Reglib\Regex;

use \Able\Validation\Filters\Max;
use \Able\Validation\Filters\Min;
use \Able\Validation\Filters\Url;
use \Able\Validation\Filters\Less;
use \Able\Validation\Filters\Email;
use \Able\Validation\Filters\Integer;
use \Able\Validation\Filters\Greater;

use \Able\Validation\Structures\SError;
use \Able\Validation\Utilities\Decision;
use \Able\Validation\Abstractions\AFilter;

class Validator {

	/**
	 * @var array
	 */
	private static $Rules = [];

	/**
	 * @param string $name
	 * @param string $class
	 * @throws \Exception
	 */
	public static final function register(string $name, string $class): void {
		$name = strtolower($name);

		if (!Regex::checkVariable($name)) {
			throw new \Exception(sprintf('Invalid rule name: %s!', $name));
		}

		if (array_key_exists($name, self::$Rules)) {
			throw new \Exception(sprintf('Rule with name "%s" is already registered!', $name));
		}

		if (!class_exists($class)) {
			throw new \Exception(sprintf('Undefined rule class: %s!', $class));
		}

		if (!is_subclass_of($class, AFilter::class)) {
			throw new \Exception(sprintf('Undefined rule class: %s!', $class));
		}

		self::$Rules[$name] = $class;
	}

	/**
	 * @var array
	 */
	private $Fields = [];

	/**
	 * @var array
	 */
	private $Required = [];

	/**
	 * @const string
	 */
	private const MS_REQIRED = "The %{name} field is required!";

	/**
	 * @param array $Rules
	 * @throws \Exception
	 */
	public function __construct(array $Rules) {
		foreach ($Rules as $name => $condition) {
			$name = strtolower($name);

			foreach (preg_split('/\|+/', $condition, -1, PREG_SPLIT_NO_EMPTY) as $rule) {
				if (strtolower($rule) == "required"){
					array_push($this->Required, $name);

					continue;
				}

				extract(Regex::create('/^(' . Regex::RE_KEYWORD . '):?(.*)$/')->parse($rule, 'token', 'argument'));
				if (!array_key_exists($token, self::$Rules)){
					throw new \Exception(sprintf('Undefined rule: %s!', $token));
				}

				$this->Fields = Arr::improve($this->Fields, $name,
					new self::$Rules[$token]($argument));
			}
		}
	}

	/**
	 * @param string $message
	 * @param array $Values
	 * @return string
	 */
	private function parseMessage(string $message, array $Values = []): string {
		return preg_replace_callback('/%\{(' . Regex::RE_VARIABLE . ')\}/', function(array $Matches) use ($Values) {
			return isset($Values[$Matches[1]]) ? $Values[$Matches[1]] : $Matches[0];
		}, $message);
	}

	/**
	 * @param array $Data
	 * @return Decision
	 * @throws \Exception
	 */
	public function validate(array $Data): Decision {
		$Errors = [];

		foreach ($this->Required as $name){
			if (!array_key_exists($name, $Data)){
				array_push($Errors, new SError($name,
					sprintf('The %s field is required!', $name)));
			}
		}

		foreach ($Data as $name => $value){
			if (array_key_exists($name, $this->Fields)){
				foreach ($this->Fields[$name] as $Filter) {

					if (!$Filter->check($Data[$name])) {
						array_push($Errors, new SError($name,
							$this->parseMessage($Filter,
								array_merge($Filter->toArray(), ['name' => $name, 'value' => $Data[$name]]))));
					}
				}
			}
		}

		return new Decision($Errors);
	}

}

/** @noinspection PhpUnhandledExceptionInspection */
Validator::register('email', Email::class);

/** @noinspection PhpUnhandledExceptionInspection */
Validator::register('max', Max::class);

/** @noinspection PhpUnhandledExceptionInspection */
Validator::register('min', Min::class);

/** @noinspection PhpUnhandledExceptionInspection */
Validator::register('url', Url::class);

/** @noinspection PhpUnhandledExceptionInspection */
Validator::register('integer', Integer::class);

/** @noinspection PhpUnhandledExceptionInspection */
Validator::register('greater', Greater::class);

/** @noinspection PhpUnhandledExceptionInspection */
Validator::register('less', Less::class);
