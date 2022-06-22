<?php

// @expectedError Return type "foo" is discouraged

class UnknownGenericSubReturnTypeInDocComment
{
    /**
     * @return array<foo>
     */
    public function foo()
    {
        return true;
    }
}
