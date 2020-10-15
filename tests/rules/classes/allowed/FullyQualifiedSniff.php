<?php

// @expectedPass

namespace flyeralarm\Test;

use IteratorAggregate;
use RuntimeException;
use stdClass;

class FullyQualifiedSniff extends stdClass implements IteratorAggregate
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

    public function getIterator()
    {
    }
}
