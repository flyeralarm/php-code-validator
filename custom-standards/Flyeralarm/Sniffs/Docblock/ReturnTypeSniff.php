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
        return array(T_DOC_COMMENT_OPEN_TAG);
    }

    /**
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        if (!$this->hasReturnInDoc($phpcsFile, $stackPtr)) {
            return;
        }

        $tokens = $phpcsFile->getTokens();
        $returnTypePtr = $this->getDocReturnTypePtr($phpcsFile, $stackPtr);
        $returnTypeString = $tokens[$returnTypePtr]['content'];

        try {
            $this->checkReturnTypeShape($returnTypeString);
        }
        catch (\InvalidArgumentException $exception) {
            $phpcsFile->addError(
                $exception->getMessage(),
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

    /**
     * @param string $subject The return type string to check.
     * @return void
     */
    private function checkReturnTypeShape(string $subject)
    {
        $matched = preg_match_all('#(?<separator>\s*\|\s*)?(?<atom>[^<>\|]+)(?<generic><(?<nested>.*)>)?#', $subject, $matches);

        if (!$matched || implode('', $matches[0]) !== $subject) {
            throw new \InvalidArgumentException('Invalid structure in return type "' . $subject . '"');
        }

        if (strpos($matches['separator'][0], '|') !== false) {
            throw new \InvalidArgumentException('Missing return type in first alternative of type "' . $subject . '"');
        }

        foreach ($matches['nested'] as $index => $match) {
            if (!empty($matches['generic'][$index])) {
                if (trim($matches['atom'][$index]) !== 'array') {
                    throw new \InvalidArgumentException('Unexpected generic specification in type "' . $matches[0][$index] . '"');
                }

                $match = trim($match);
                if (strpos($match, 'int,') === 0) {
                    // Allow numeric indexing in generics, e.g. `array<int, string>`
                    $match = substr($match, 4);
                }

                if ($match === '') {
                    throw new \InvalidArgumentException('Generic specification may not be empty in type "' . $matches[0][$index] . '"');
                }

                $this->checkReturnTypeShape($match);
            }

            // Check if atom is in whitelist.
            $returnType = trim($matches['atom'][$index]);
            if (in_array($returnType, $this->returnTypeScalarWhitelist, true)) {
                continue;
            }
            if (in_array($returnType, $this->returnTypeClassWhitelist, true)) {
                continue;
            }
            if ($this->isStartingWithUppercaseLetter($returnType)) {
                continue;
            }

            throw new \InvalidArgumentException('Return type "' . $returnType . '" is discouraged');
        }
    }
}
