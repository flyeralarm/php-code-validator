<?php
// @expectedError Exclamationmarks are not allowed in Exceptionmessages

class ExclamationException
{
    public function foobar()
    {
        echo 'Hi';
        echo 'Wrong!';
        echo 'Bye';
        echo "Hola";
    }
}
