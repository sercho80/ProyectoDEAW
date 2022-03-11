<?php
class SQLInjectException extends Exception
{
    public function __construct($error = null, $code = 0)
    {
        parent::__construct($error, $code);
    }
}
