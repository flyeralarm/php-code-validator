<?php

// @expectedError Qualifier should be replaced with an import: "new \RuntimeException"

namespace flyeralarm\Test;

class FullyQualifiedSniff
{
    public function a()
    {
        $a = new \RuntimeException();
    }
}
