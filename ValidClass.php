<?php

namespace flyeralarm\CodingGuidelines;

class ValidClass
{
    /**
     * @var string
     */
    private $string;

    /**
     * @param string $string
     */
    public function __construct($string)
    {
        $this->string = $string;
    }

    /**
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * @param string $string
     */
    public function setString($string)
    {
        if (mb_strlen($string) == 0) {
            throw new \InvalidArgumentException("An exception");
        }

        $this->string = $string;
    }
}
