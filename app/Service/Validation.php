<?php

namespace App\Services;

use Illuminate\Validation\Validator;

class Validation extends Validator
{
    public function ValidateTags($attribute, $value, $parameters)
    {

        return preg_match("/^[A-Za-z0-9-éèàù]{1,50}?(,[A-Za-z0-9-éèàù]{1,50})*$/", $value);
    }
}

?>