<?php

// @expectedPass

namespace Flyeralarm\CodingGuidelines;

class IfThisIsTrueEqualsTrue
{
    private $isTrue;

    public function foo()
    {
        if ($this->isTrue == true) {
        }
    }
}
