<?php namespace Users\Form\Signin;

use Users\Validation\AbstractLaravelValidator;

class SigninFormLaravelValidator extends AbstractLaravelValidator {
	
	/**
	 * Validation rules
	 *
	 * @var Array 
	 */
	protected $rules = array(
		'email' => 'required|email',
		'password' => 'required|min:5|max:15'
	);

	
}