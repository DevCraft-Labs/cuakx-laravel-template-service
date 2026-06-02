<?php

namespace App\Http\Controllers\ExampleModule\ExampleFunction\Exception;

use Cuakx\Core\Exceptions\BaseException;

class TestingException extends BaseException
{
    public function __construct()
    {
        parent::__construct(
            "Congratulations! You\'re trying to use this function.",
            'FFFFFF'
        );
    }
}
