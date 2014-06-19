<?php 
namespace Authority\Service\Form\Register;

use Authority\Service\Validation\AbstractLaravelValidator;

class RegisterFormLaravelValidator extends AbstractLaravelValidator {

    /**
     * Validation rules
     *
     * @var Array 
     */
    protected $rules = array(
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
        'password_confirmation' => 'required'
    );

}