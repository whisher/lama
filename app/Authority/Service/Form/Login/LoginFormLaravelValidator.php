<?php namespace Authority\Service\Form\Login;

use Authority\Service\Validation\AbstractLaravelValidator;

class LoginFormLaravelValidator extends AbstractLaravelValidator {
	
	/**
	 * Validation rules
	 *
	 * @var Array 
	 */
	protected $rules = array(
		'email' => 'required|email',
		'password' => 'required'
	);

	
}