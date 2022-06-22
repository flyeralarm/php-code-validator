<?php

// @expectedError Return type "array int" is discouraged

class MissingAlternativeSeparatorInReturnTypeInDocComment
{
    /**
     * @return array int
     */
    public function foo()
    {
        return true;
    }
}
