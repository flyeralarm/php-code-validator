<?php
// @expectedError GOTO is not allowed

class ClassWithGoto
{
    public function foo()
    {
        goto foo;

        foo:
        return;
    }
}