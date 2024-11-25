<?php

namespace Flyeralarm\CodingGuidelines\Flyeralarm\Sniffs\ControlStructures;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class YodaSniff implements Sniff
{
    /**
     * @return array
     */
    public function register()
    {
        return [T_IF, T_ELSEIF, T_WHILE];
    }


    /**
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $startOfConditionPtr = $stackPtr;
        if (array_key_exists('scope_opener', $tokens[$startOfConditionPtr])) {
            $endPtr = $tokens[$startOfConditionPtr]['scope_opener'] + 1;
        }

        $logicalOperatorTokenIds = [T_BOOLEAN_AND, T_BOOLEAN_OR, T_LOGICAL_AND, T_LOGICAL_OR, T_LOGICAL_XOR];
        $scopeOpenerTokenIds = [T_OPEN_CURLY_BRACKET];
        $tokenIdsToFindAllConditions = array_merge($logicalOperatorTokenIds, $scopeOpenerTokenIds);

        while ($endOfConditionPtr = $phpcsFile->findNext($tokenIdsToFindAllConditions, $startOfConditionPtr, $endPtr)) {
            $this->checkConditionalOrderForArithmeticExpression($phpcsFile, $startOfConditionPtr, $endOfConditionPtr);
            $startOfConditionPtr = $endOfConditionPtr + 1;
        }
    }


    /**
     * @param File $phpcsFile
     * @param $startOfConditionPtr
     * @param $endOfConditionPtr
     */
    private function checkConditionalOrderForArithmeticExpression(
        File $phpcsFile,
        $startOfConditionPtr,
        $endOfConditionPtr
    ) {
        $tokens = $phpcsFile->getTokens();
        $logicalOperatorPtr = $phpcsFile->findNext(
            [
                T_IS_NOT_IDENTICAL,
                T_IS_IDENTICAL,
                T_IS_NOT_EQUAL,
                T_IS_EQUAL,
                T_IS_GREATER_OR_EQUAL,
                T_IS_SMALLER_OR_EQUAL,
                T_LESS_THAN,
                T_GREATER_THAN,
            ],
            $startOfConditionPtr,
            $endOfConditionPtr
        );

        // e.g. if ($foo)
        if (!$logicalOperatorPtr) {
            return;
        }

        $languageTypeTokenIds = [T_NULL, T_TRUE, T_FALSE, T_ARRAY, T_CONSTANT_ENCAPSED_STRING, T_LNUMBER];
        $functionAndVariableTokenIds = [T_STRING, T_VARIABLE]; // T_STRING matches count() for example
        $operandTokenIds = array_merge($languageTypeTokenIds, $functionAndVariableTokenIds);

        $leftOperandPtr = $phpcsFile->findNext($operandTokenIds, $startOfConditionPtr, $logicalOperatorPtr);
        if (!$leftOperandPtr) {
            return;
        }

        $rightOperandPtr = $phpcsFile->findNext($operandTokenIds, $logicalOperatorPtr, $endOfConditionPtr);
        if (!$rightOperandPtr) {
            return;
        }

        $leftOperandTokenId = $tokens[$leftOperandPtr]['code'];
        $rightOperandTokenId = $tokens[$rightOperandPtr]['code'];

        // e.g. if ($foo = true)
        // e.g. if ($foo = 'bar')
        if (
            in_array($leftOperandTokenId, $functionAndVariableTokenIds)
            && in_array($rightOperandTokenId, $languageTypeTokenIds)
        ) {
            return;
        }
        // e.g. if (count(..) > $test)
        // e.g. if ($foo == $bar)
        if (
            in_array($leftOperandTokenId, $functionAndVariableTokenIds)
            && in_array($rightOperandTokenId, $functionAndVariableTokenIds)
        ) {
            return;
        }
        // e.g. if ('foo' == 'bar')
        if (
            in_array($leftOperandTokenId, $languageTypeTokenIds)
            && in_array($rightOperandTokenId, $languageTypeTokenIds)
        ) {
            return;
        }

        $phpcsFile->addError(
            'YODA is discouraged',
            $leftOperandPtr,
            'ConditionalOrder'
        );
    }
}
