<?php

// @expectedPass

namespace flyeralarm\CodingGuidelines;

class IfThisIsTrueEqualsTrue
{
    private $isTrue;

    public function foo()
    {
        if ($this->isTrue == true) {
        }
    }
}
