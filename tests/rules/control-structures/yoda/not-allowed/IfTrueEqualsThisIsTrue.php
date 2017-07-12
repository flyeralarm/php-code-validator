<?php

// @expectedError YODA is discouraged

namespace flyeralarm\CodingGuidelines;

class IfTrueEqualsThisIsTrue
{
    private $isTrue;

    public function foo()
    {
        if (true == $this->isTrue) {
        }
    }
}
