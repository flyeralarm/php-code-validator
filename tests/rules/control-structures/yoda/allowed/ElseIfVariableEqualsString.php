<?php

// @expectedPass

$foo = 'bar';
$bar = 'foo';


if (true) {
} elseif ($foo == 'bar') {
} elseif ($foo == 'bar' && $bar == 'foo') {
}
