<?php 
namespace Users\Form\Update;

use Users\Validation\AbstractLaravelValidator;

class UpdateFormLaravelValidator extends AbstractLaravelValidator {

    /**
     * Validation rules
     *
     * @var Array 
     */
    protected $rules = array(
        'fullname' => 'sometimes|required|min:5|max:25',
        'email' => 'sometimes|required|email',
        'username' => 'sometimes|required|min:3|max:15',
        'password' => 'sometimes|required|min:5|max:15|confirmed',
        'password_confirmation' => 'sometimes|required|min:5|max:15',
        'groups' => 'sometimes|required|groups',
        'minutes' => 'sometimes|required|numeric'
    );

}