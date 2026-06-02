<?php

use App\Http\Controllers\ExampleModule\ExampleController;
use Illuminate\Support\Facades\Route;


Route::prefix("v1/example")->group(function () {
    Route::get("get-is-odd", [ExampleController::class, "getIsOdd"]);
    Route::post("get-is-odd", [ExampleController::class, "postIsOdd"]);
    Route::post("exception-handling", [ExampleController::class, "exceptionThrowing"]);
});
