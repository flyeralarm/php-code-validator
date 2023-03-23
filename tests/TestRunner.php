<?php

declare(strict_types=1);

namespace Flyeralarm\Sniffer\Tests;

class TestRunner
{
    /**
     * @param string $dirPath
     */
    public function processDir(string $dirPath)
    {
        $hasError = $this->recursiveDirProcess($dirPath);
        if ($hasError) {
            exit(1);
        }
        exit(0);
    }

    public function recursiveDirProcess(string $dirPath, bool $hasError = false): bool
    {
        $dir = opendir($dirPath);
        while (($file = readdir($dir)) !== false) {
            if (strpos($file, '.') === 0) {
                continue;
            }
            if (is_dir($dirPath . $file)) {
                $hasError = $this->recursiveDirProcess($dirPath . $file . '/', $hasError);
                continue;
            }

            $fileContent = file_get_contents($dirPath . $file);
            $snifferOutput = shell_exec(
                sprintf(
                    "%s -w -p -s --report-width=120 --standard=%s %s",
                    escapeshellcmd(__DIR__ . '/../vendor/bin/phpcs'),
                    escapeshellarg(__DIR__ . '/ruleset.xml'),
                    escapeshellarg($dirPath . $file)
                )
            );

            // expectedPass
            if (preg_match('|//\s@expectedPass$|m', $fileContent)) {
                if (preg_match('|^FOUND.*AFFECTING.*LINE|m', $snifferOutput) === 0) {
                    echo 'OK - [' . $dirPath . $file . ']' . PHP_EOL;
                    continue;
                }

                $hasError = true;
                echo "ERROR - [" . $dirPath . $file . "]:'
                . ' Test was expected to fully pass. Result: " . PHP_EOL . $snifferOutput . PHP_EOL;
                continue;
            }

            // expectedError
            preg_match('|//\s@expectedError\s(.*)$|m', $fileContent, $expectedMatch);
            if (count($expectedMatch) !== 2) {
                echo 'WARNING - [' . $dirPath . $file . ']:'
                    . ' File must contain exactly one "@expectedError <EXPECTATION MESSAGE>"'
                    . ' or "@expectedPass" comment' . PHP_EOL;
                continue;
            }
            $expected = $expectedMatch[1];
            if (preg_match('/ERROR\s\|\s?[\[\]x\s]*\s' . preg_quote($expected, '/') . '/', $snifferOutput) === 0) {
                $hasError = true;
                echo 'ERROR - [' . $dirPath . $file . ']:'
                    . ' Expectation <<' . $expected . '>>'
                    . ' not found in result: ' . PHP_EOL . $snifferOutput . PHP_EOL;
            } else {
                echo 'OK - [' . $dirPath . $file . ']' . PHP_EOL;
            }
        }
        return $hasError;
    }
}
