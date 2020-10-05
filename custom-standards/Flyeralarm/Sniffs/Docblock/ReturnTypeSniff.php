<?php

namespace Flyeralarm\CodingGuidelines\Flyeralarm\Sniffs\Docblock;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class ReturnTypeSniff implements Sniff
{
    /**
     * @var array
     */
    private $returnTypeScalarWhitelist = [
        'bool',
        'int',
        'string',
        'float',
        'resource',
        'array',
        'bool[]',
        'int[]',
        'string[]',
        'float[]',
        'null'
    ];

    /**
     * @var array
     */
    private $returnTypeClassWhitelist = [
        'mysqli',
        'mysqli_driver',
        'mysqli_result',
        'mysqli_stmt',
        'mysqli_sql_exception',
        'mysqli_warning',
    ];

    /**
     * @return array
     */
    public function register()
    {
        return [T_DOC_COMMENT_OPEN_TAG];
    }

    /**
     * @param File $phpcsFile
     * @param int $stackPtr
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        if (!$this->hasReturnInDoc($phpcsFile, $stackPtr)) {
            return;
        }

        $tokens = $phpcsFile->getTokens();
        $returnTypePtr = $this->getDocReturnTypePtr($phpcsFile, $stackPtr);
        $returnTypeString = $tokens[$returnTypePtr]['content'];
        $returnTypes = explode('|', $returnTypeString);

        foreach ($returnTypes as $returnType) {
            $returnType = trim($returnType);
            if (in_array($returnType, $this->returnTypeScalarWhitelist, true)) {
                continue;
            }
            if (in_array($returnType, $this->returnTypeClassWhitelist, true)) {
                continue;
            }
            if ($this->isStartingWithUppercaseLetter($returnType)) {
                continue;
            }

            $phpcsFile->addError(
                sprintf('Return type "%s" is discouraged', $returnType),
                $returnTypePtr,
                'ProhibitedReturnType'
            );
        }
    }

    /**
     * @param File $phpcsFile
     * @param $stackPtr
     * @return int
     */
    private function getDocReturnTypePtr(File $phpcsFile, $stackPtr)
    {
        $commentEndPtr = $phpcsFile->getTokens()[$stackPtr]['comment_closer'];
        $returnTokenPtr = $this->getNextDocReturnToken($phpcsFile, $stackPtr);
        $nextString = $phpcsFile->findNext(T_DOC_COMMENT_STRING, $returnTokenPtr + 1, $commentEndPtr);

        return $nextString;
    }

    /**
     * @param File $phpcsFile
     * @param $docStartPtr
     * @return int
     */
    private function getNextDocReturnToken(File $phpcsFile, $docStartPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $commentEndPtr = $tokens[$docStartPtr]['comment_closer'];
        for ($currentTokenIndex = $docStartPtr; $currentTokenIndex < $commentEndPtr; $currentTokenIndex++) {
            $currentToken = $phpcsFile->findNext(T_DOC_COMMENT_TAG, $currentTokenIndex, $commentEndPtr);
            if ($tokens[$currentToken]['content'] == '@return') {
                return $currentToken;
            }
        }

        throw new \OutOfBoundsException('Found no @return tag');
    }

    /**
     * @param File $phpcsFile
     * @param int $docStartPtr
     * @return bool
     */
    public function hasReturnInDoc(File $phpcsFile, $docStartPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $commentEnd = $tokens[$docStartPtr]['comment_closer'];
        for ($currentTokenIndex = $docStartPtr; $currentTokenIndex < $commentEnd; $currentTokenIndex++) {
            $currentToken = $phpcsFile->findNext(T_DOC_COMMENT_TAG, $currentTokenIndex, $commentEnd);
            if ($tokens[$currentToken]['content'] == '@return') {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $singleCharacter
     * @return bool
     */
    private function isStartingWithUppercaseLetter($singleCharacter)
    {
        $firstChar = substr($singleCharacter, 0, 1);
        if (strtoupper($firstChar) == $firstChar) {
            return true;
        }

        return false;
    }
}
