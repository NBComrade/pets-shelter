<?php

namespace App\Exceptions;

use Throwable;

/**
 * Class InvalidPetTypeException
 * @package App\Exceptions
 */
class InvalidPetTypeException extends \InvalidArgumentException
{
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        if (empty($message)) {
            $message = 'This type of animal can not be added to the shelter';
        }
        parent::__construct($message, $code, $previous);
    }
}
