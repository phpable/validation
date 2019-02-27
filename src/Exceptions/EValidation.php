<?php
namespace Able\Validation\Exceptions;

use \Able\Validation\Structures\SError;
use \Able\Validation\Utilities\Decision;

class EValidation extends \Exception {

	/**
	 * @var Decision
	 */
	private $Decision = null;

	/**
	 * EValidation constructor.
	 * @param Decision $Decision
	 */
	public final function __construct(Decision $Decision){
		$this->Decision = $Decision;

		/**
		 * For the compatibility reasons the first error
		 * has to be interpreted as a default error message.
		 */
		parent::__construct($Decision->first());
	}

	/**
	 * @return array
	 */
	public final function getMessages(){
		return $this->Decision->toArray();
	}
}
