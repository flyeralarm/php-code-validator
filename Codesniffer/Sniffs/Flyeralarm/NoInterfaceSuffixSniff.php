<?php

namespace flyeralarm\CodingGuidelines;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class NoInterfaceSuffixSniff implements Sniff
{
    /**
     * @return array
     */
    public function register()
    {
        return array(T_INTERFACE);
    }

    /**
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $interfaceName = $phpcsFile->getDeclarationName($stackPtr);

        if (preg_match('/Interface$/i', $interfaceName) === 1) {
            $phpcsFile->addError('Suffix "Interface" is not allowed', $stackPtr, 'InvalidInterfaceName');
        }
    }
}
