<?php namespace App\Utils;

class LinkValidation
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        return $this->isValidate($attribute, $value);
    }

    protected function isValidate($attribute, $value)
    {
        return filter_var($value, FILTER_VALIDATE_URL) === true;            
    }
}