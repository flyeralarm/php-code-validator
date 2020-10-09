<?php

// @expectedError Qualifier should be replaced with an import: "extends \stdClass"

namespace flyeralarm\Test;

class FullyQualifiedSniffExtends extends \stdClass
{
    public function a()
    {
        $a = 0;
    }
}
