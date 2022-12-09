<?php

namespace Exceptions;

use Exception;

class FieldNotFoundInProvidedData extends Exception {
    protected $message = 'The field is not found in the provided data';
}