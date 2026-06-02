<?php

namespace App\Http\Controllers\ExampleModule\ExampleFunction;

interface IExampleService
{
    /**
     * Return true if the passed number is odd.
     */
    public function isOdd(int $number): bool;
}
