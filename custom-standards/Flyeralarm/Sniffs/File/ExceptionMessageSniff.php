<?php

namespace Flyeralarm\CodingGuidelines\Flyeralarm\Sniffs\File;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class ExceptionMessageSniff implements Sniff
{
    /**
     * @return array
     */
    public function register()
    {
        return [T_CLASS];
    }

    /**
     * @param File $phpcsFile
     * @param int $stackPtr
     * @throws \PHP_CodeSniffer\Exceptions\RuntimeException
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $className = $phpcsFile->getDeclarationName($stackPtr);

        if (strpos($className, 'Exception') === false) {
            return;
        }

        $tokens = $phpcsFile->getTokens();
        $ptr = -1;
        while ($ptr = $phpcsFile->findNext(T_CONSTANT_ENCAPSED_STRING, $ptr + 1)) {
            if (strpos($tokens[$ptr]['content'], '!') !== false) {
                $phpcsFile->addError(
                    'Exclamationmarks are not allowed in Exceptionmessages',
                    $stackPtr,
                    'ExceptionMessageWithInvalidCharacter'
                );
            }

            if (strpos($tokens[$ptr]['content'], '.') !== false) {
                $phpcsFile->addError(
                    'Full stops are not allowed in Exceptionmessages',
                    $stackPtr,
                    'ExceptionMessageWithInvalidCharacter'
                );
            }
        }
    }
}
