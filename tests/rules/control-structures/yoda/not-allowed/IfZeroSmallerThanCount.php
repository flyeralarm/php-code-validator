<?php

// @expectedError YODA is discouraged

$foo = ['bar'];
if (0 < count($foo)) {
}
