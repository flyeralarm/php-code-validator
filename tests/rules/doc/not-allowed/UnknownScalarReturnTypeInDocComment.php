<?php

// @expectedError Return type "mixed" is discouraged

class UnknownScalarReturnTypeInDocComment
{
    /**
     * @return int|mixed
     */
    public function foo()
    {
        return true;
    }
}
