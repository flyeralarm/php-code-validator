<?php

require __DIR__ . '/TestRunner.php';

(new \Flyeralarm\Sniffer\Tests\TestRunner())->processDir(__DIR__ . '/rules/');
