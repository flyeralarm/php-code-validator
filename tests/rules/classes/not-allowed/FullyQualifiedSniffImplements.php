<?php

// @expectedError Qualifier should be replaced with an import: "implements \IteratorAggregate"

namespace flyeralarm\Test;

class FullyQualifiedSniffExtends implements \IteratorAggregate
{
    public function getIterator()
    {
    }
}
