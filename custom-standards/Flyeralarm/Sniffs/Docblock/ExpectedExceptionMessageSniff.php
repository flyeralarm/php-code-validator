<?php

namespace Flyeralarm\CodingGuidelines\Flyeralarm\Sniffs\Docblock;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class ExpectedExceptionMessageSniff implements Sniff
{
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
        if (!$this->hasAnnotationInDoc($phpcsFile, $stackPtr, '@expectedException')) {
            return;
        }
        if (
            $this->hasAnnotationInDoc($phpcsFile, $stackPtr, '@expectedExceptionMessage')
            || $this->hasAnnotationInDoc($phpcsFile, $stackPtr, '@expectedExceptionMessageRegExp')
        ) {
            return;
        }

        $expectedExceptionPtr = $this->getAnnotationPtr($phpcsFile, $stackPtr, '@expectedException');

        $phpcsFile->addError(
            'Annotation @expectedExceptionMessage missing',
            $expectedExceptionPtr,
            'AnnotationMissing'
        );
    }

    /**
     * @param File $phpcsFile
     * @param $docStartPtr
     * @return int
     */
    private function getAnnotationPtr(File $phpcsFile, $docStartPtr, $annotation)
    {
        $tokens = $phpcsFile->getTokens();
        $commentEndPtr = $tokens[$docStartPtr]['comment_closer'];
        for ($currentTokenIndex = $docStartPtr; $currentTokenIndex < $commentEndPtr; $currentTokenIndex++) {
            $currentToken = $phpcsFile->findNext(T_DOC_COMMENT_TAG, $currentTokenIndex, $commentEndPtr);
            if ($tokens[$currentToken]['content'] == $annotation) {
                return $currentToken;
            }
        }

        throw new \OutOfBoundsException('Found no @return tag');
    }

    /**
     * @param File $phpcsFile
     * @param int $docStartPtr
     * @param string $annotation
     * @return bool
     */
    public function hasAnnotationInDoc(File $phpcsFile, $docStartPtr, $annotation)
    {
        $tokens = $phpcsFile->getTokens();
        $commentEnd = $tokens[$docStartPtr]['comment_closer'];
        for ($currentTokenIndex = $docStartPtr; $currentTokenIndex < $commentEnd; $currentTokenIndex++) {
            $currentToken = $phpcsFile->findNext(T_DOC_COMMENT_TAG, $currentTokenIndex, $commentEnd);
            if ($tokens[$currentToken]['content'] == $annotation) {
                return true;
            }
        }

        return false;
    }
}
