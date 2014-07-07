<?php namespace Users\Validation;

use Illuminate\Validation\Validator;

class CustomValidator extends Validator {
 
  public function validateGroups($attribute, $value, $parameters)
  {
    return !empty($value) && is_array($value);
  }
}