<?php

namespace Flyeralarm\CodingGuidelines\Flyeralarm\Sniffs\Classes;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use RuntimeException;

class FullyQualifiedSniff implements Sniff
{
    /**
     * @return array
     */
    public function register()
    {
        return [T_DOUBLE_COLON, T_NEW, T_EXTENDS, T_IMPLEMENTS];
    }

    /**
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $classCall = $this->getClassCall($phpcsFile, $stackPtr);

        if (strpos($classCall, '\\') === false) {
            return;
        }

        $phpcsFile->addError(
            'Qualifier should be replaced with an import: "%s"',
            $stackPtr,
            'Found',
            [$classCall]
        );
    }

    private function getClassCall(File $phpcsFile, $stackPtr): string
    {
        $tokens = $phpcsFile->getTokens();

        switch ($tokens[$stackPtr]['code']) {
            case T_NEW:
                $tokensAsString = $phpcsFile->getTokensAsString(
                    $stackPtr,
                    $phpcsFile->findEndOfStatement($stackPtr) - $stackPtr
                );

                return substr(
                    $tokensAsString,
                    0,
                    strpos($tokensAsString, '(')
                );

            case T_DOUBLE_COLON:
                $classCallStart = $phpcsFile->findStartOfStatement($stackPtr);

                return $phpcsFile->getTokensAsString(
                    $classCallStart,
                    $stackPtr - $classCallStart
                );

            case T_EXTENDS:
            case T_IMPLEMENTS:
                $tokensAsString = $phpcsFile->getTokensAsString(
                    $stackPtr,
                    $phpcsFile->findEndOfStatement($stackPtr) - $stackPtr
                );

                return trim(substr(
                    $tokensAsString,
                    0,
                    strpos($tokensAsString, '{')
                ));
        }

        throw new RuntimeException(sprintf(
            'Unknown token type: "%s"',
            $tokens[$stackPtr]['type']
        ));
    }
}
