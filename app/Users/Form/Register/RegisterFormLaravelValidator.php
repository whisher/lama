<?php 
namespace Users\Form\Register;

use Users\Validation\AbstractLaravelValidator;

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
        'password' => 'required|min:5|max:15|confirmed',
        'password_confirmation' => 'required|min:5|max:15'
    );

}