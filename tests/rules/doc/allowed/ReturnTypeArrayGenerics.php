<?php

// @expectedPass

namespace flyeralarm\Test;

class FooTest
{
    /**
     * @return array
     */
    public function testArray()
    {
    }

    /**
     * @return array<string>
     */
    public function testWithGeneric()
    {
    }

    /**
     * @return array<int, string>
     */
    public function testWithNumericIndex()
    {
    }

    /**
     * @return array<string | int>
     */
    public function testWithAlternativeInside()
    {
    }

    /**
     * @return int | array<array<string>>
     */
    public function testWithAlternativeOutside()
    {
    }

    /**
     * @return array<array<string>> | null
     */
    public function testWithAlternativeAtTheEnd()
    {
    }

    /**
     * @return int | array<string | array<string>>
     */
    public function testWithMultipleAlternatives()
    {
    }
}
