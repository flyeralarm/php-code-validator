<?php

// @expectedError Invalid structure in return type "array<int"

class InvalidStructureInReturnTypeInDocComment
{
    /**
     * @return array<int
     */
    public function foo()
    {
        return true;
    }
}
