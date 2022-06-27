<?php

// @expectedError Missing return type in first alternative of type "| string"

class EmptyAlternativeInReturnTypeInDocComment
{
    /**
     * @return | string
     */
    public function foo()
    {
        return true;
    }
}
