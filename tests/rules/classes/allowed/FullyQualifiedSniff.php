<?php

// @expectedPass

namespace flyeralarm\Test;

use RuntimeException;
use stdClass;

class FullyQualifiedSniff extends stdClass
{
    public function a()
    {
        $className = RuntimeException::class;
        $a = new RuntimeException();
    }

    public function b()
    {
        $a = new RuntimeException(
            'We can\'t explain'
        );
    }
}
