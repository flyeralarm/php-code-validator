<?php

// @expectedError YODA is discouraged

$foo = 'bar';
$bar = true;

if (true) {
} elseif ($foo == 'bar' && true == $bar) {
}
