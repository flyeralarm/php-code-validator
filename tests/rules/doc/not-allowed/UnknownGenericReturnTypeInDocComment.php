<?php

// @expectedError Unexpected generic specification in type "int<array>"

class UnknownGenericReturnTypeInDocComment
{
    /**
     * @return int<array>
     */
    public function foo()
    {
        return true;
    }
}
