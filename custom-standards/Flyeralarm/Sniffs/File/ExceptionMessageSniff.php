<?php

namespace Flyeralarm\CodingGuidelines\Flyeralarm\Sniffs\File;

use PHP_CodeSniffer\Exceptions\RuntimeException;
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
     * @return void
     * @throws RuntimeException
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $className = $phpcsFile->getDeclarationName($stackPtr);

        if (! $this->doesStringEndsWith($className, 'Exception')) {
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

    /**
     * @alias str_ends_with in PHP8+
     */
    public function doesStringEndsWith(string $className, string $suffix): bool
    {
        $suffixLength = strlen($suffix);
        return ($suffixLength === 0 || 0 === substr_compare($className, $suffix, - $suffixLength));
    }
}
