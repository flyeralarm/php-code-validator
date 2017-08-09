<?php

namespace Flyeralarm\CodingGuidelines\Flyeralarm\Sniffs\File;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class ForbiddenKeywordsSniff implements Sniff
{
    /**
     * @return array
     */
    public function register()
    {
        return array(T_CLASS, T_ABSTRACT, T_TRAIT);
    }

    /**
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        if ($phpcsFile->findNext(T_GOTO, 0)) {
            $phpcsFile->addError(
                'GOTO is not allowed',
                $stackPtr,
                'ForbiddenKeyword'
            );
        }

        if ($phpcsFile->findNext(T_EVAL, 0)) {
            $phpcsFile->addError(
                'EVAL is not allowed',
                $stackPtr,
                'ForbiddenKeyword'
            );
        }
    }
}
