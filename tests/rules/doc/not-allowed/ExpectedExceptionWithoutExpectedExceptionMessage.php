<?php

// @expectedError Annotation @expectedExceptionMessage missing

class FooTest
{
    /**
     * @expectedException \RuntimeException
     */
    public function testBar()
    {
    }
}
