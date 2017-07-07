<?php
// @expectedError Full stops are not allowed in Exceptionmessages

class FullStopException
{
    public function foobar()
    {
        echo 'Hi';
        echo 'Bye';
        echo "Hola";
        echo "Ciao.";
    }
}
