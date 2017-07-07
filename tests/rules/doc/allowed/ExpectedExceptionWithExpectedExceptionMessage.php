<?php

// @expectedPass

namespace flyeralarm\Test;

class FooTest
{
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage The exception message
     */
    public function testBar()
    {
    }
}
