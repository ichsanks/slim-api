<?php 

namespace App\Exceptions;

use \Illuminate\Contracts\Debug\ExceptionHandler as Exceptions;

class Handler {
    public function report(Exceptions $e) {
        throw $e;
    }

    public function render($request, Exceptions $e) {
        throw $e;
    }

    public function renderForConsole($output, Exceptions $e) {
        throw $e;
    }
}