<?php

namespace Flyeralarm\CodingGuidelines\Flyeralarm\Sniffs\Variable;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Common;

class LowerCamelCaseSniff implements Sniff
{
    /**
     * @return array
     */
    public function register()
    {
        return array(T_OPEN_TAG);
    }

    /**
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $startPtr = $stackPtr;
        $tokens = $phpcsFile->getTokens();

        while ($variablePtr = $phpcsFile->findNext(T_VARIABLE, $startPtr)) {
            $startPtr = $variablePtr + 1;

            $variableName = $tokens[$variablePtr]['content'];
            $variableName = substr($variableName, 1);

            $isLowerCamelCase = Common::isCamelCaps($variableName, false, true, true);
            if ($isLowerCamelCase) {
                continue;
            }
            if (strtolower($variableName) == $variableName) {
                continue;
            }

            $phpcsFile->addError(
                'Variable names must be specified in lower camel case',
                $variablePtr,
                'CamelCase'
            );
        }
    }
}
