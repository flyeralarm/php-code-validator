<?php

// @expectedPass

namespace flyeralarm\Test;

class FooTest
{
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessageRegExp /The exception message can continue \w+/
     */
    public function testBar()
    {
    }
}
