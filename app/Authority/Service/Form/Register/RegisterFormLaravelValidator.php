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
        'fullname' => 'required|max:25',
        'email' => 'required|email|unique:users',
        'username' => 'required|max:15|unique:users',
        'password' => 'required|max:15|confirmed',
        'password_confirmation' => 'required|max:15'
    );

}