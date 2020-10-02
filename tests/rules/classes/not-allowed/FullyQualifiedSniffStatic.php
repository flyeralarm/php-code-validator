<?php

// @expectedError Qualifier should be replaced with an import: "$a = \RuntimeException"

namespace flyeralarm\Test;

class FullyQualifiedSniffStatic
{
    public function a()
    {
        $a = \RuntimeException::class;
    }
}
