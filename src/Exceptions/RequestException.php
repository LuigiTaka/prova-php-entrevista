<?php

namespace TestePratico\Exceptions;

use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use Throwable;

class RequestException extends \Exception
{

    public function __construct(string $message = "", int $httpStatus = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $httpStatus, $previous);
    }
}