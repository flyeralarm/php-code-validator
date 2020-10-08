<?php

// @expectedPass

namespace flyeralarm\Test;

use RuntimeException;

class FullyQualifiedSniff
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
