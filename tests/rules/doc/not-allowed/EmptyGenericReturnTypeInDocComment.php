<?php

// @expectedError Generic specification may not be empty in type "array<>"

class EmptyGenericReturnTypeInDocComment
{
    /**
     * @return array<>
     */
    public function foo()
    {
        return true;
    }
}
