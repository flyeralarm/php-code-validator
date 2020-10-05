<?php

namespace Flyeralarm\CodingGuidelines\Flyeralarm\Sniffs\File;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class NoClassKindSuffixSniff implements Sniff
{
    /**
     * @return array
     */
    public function register()
    {
        return [T_INTERFACE, T_CLASS, T_TRAIT];
    }

    /**
     * @param File $phpcsFile
     * @param int $stackPtr
     * @throws \PHP_CodeSniffer\Exceptions\RuntimeException
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $interfaceName = $phpcsFile->getDeclarationName($stackPtr);

        if (preg_match('/(Interface|Abstract|Trait)$/i', $interfaceName, $kind) === 1) {
            $kind = $kind[1];
            $phpcsFile->addError('Suffix "' . $kind . '" is not allowed', $stackPtr, 'InvalidInterfaceName');
        }
    }
}
