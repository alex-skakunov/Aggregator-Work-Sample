<?php

namespace Exceptions;

use Exception;

class NoGroupbyFieldSetException extends Exception {
    protected $message = 'No GroupBy field name is set';
}