<?php namespace Users\Form;

use Users\Validation\ValidableInterface;


abstract class AbstractForm {

    
    /**
     * Validator
     *
     * @var Users\Form\ValidableInterface 
     */
    protected $validator;

    public function __construct(ValidableInterface $validator)
    {
        $this->validator = $validator;
    }

    
    /**
     * Return validation data
     *
     * @return array 
     */
    public function data() 
    {
        return $this->validator->data();
    }
    
    /**
     * Return any validation errors
     *
     * @return array 
     */
    public function errors() 
    {
        return $this->validator->errors();
    }

    /**
     * Test if form validator passes
     *
     * @return boolean 
     */
    public function valid(array $input) 
    {
        return $this->validator->with($input)->passes();
    }

}