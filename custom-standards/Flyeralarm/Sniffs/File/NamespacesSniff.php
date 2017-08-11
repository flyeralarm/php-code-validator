<?php

namespace Flyeralarm\CodingGuidelines\Flyeralarm\Sniffs\File;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class NamespacesSniff implements Sniff
{
    /**
     * @return array
     */
    public function register()
    {
        return array(T_CLASS, T_ABSTRACT, T_TRAIT, T_INTERFACE);
    }

    /**
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $ptr = -1;
        while($ptr = $phpcsFile->findNext(T_NS_SEPARATOR, $ptr + 1)) {
            if (strpos($tokens[$ptr + 1]['content'], '_') !== false) {
                $phpcsFile->addError(
                    'Using underscore within namespaces is discouraged',
                    $stackPtr,
                    'NamespaceDeclarationWithInvalidCapitalization'
                );
            }
            if (strpos($tokens[$ptr + 2]['content'], ';') !== false) {
                break;
            }
        }
    }
}
