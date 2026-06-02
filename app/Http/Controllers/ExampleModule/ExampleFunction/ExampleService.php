<?php

namespace App\Http\Controllers\ExampleModule\ExampleFunction;

class ExampleService implements IExampleService
{

    public function isOdd(int $number): bool
    {
        return ($number % 2) != 0;
    }
}
