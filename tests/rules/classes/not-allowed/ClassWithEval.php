<?php
// @expectedError EVAL is not allowed

class ClassWithEval
{
    public function foo()
    {
        eval(1 + 1);
    }
}
