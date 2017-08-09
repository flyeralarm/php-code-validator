<?php

// @expectedError YODA is discouraged

namespace Flyeralarm\CodingGuidelines;

class IfTrueEqualsThisIsTrue
{
    private $isTrue;

    public function foo()
    {
        if (true == $this->isTrue) {
        }
    }
}
