<?php

// @expectedError Qualifier should be replaced with an import: "implements \IteratorAggregate"

namespace flyeralarm\Test;

class FullyQualifiedSniffImplements implements \IteratorAggregate
{
    public function getIterator()
    {
    }
}
