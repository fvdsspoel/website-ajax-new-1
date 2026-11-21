<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // The tests run without Mockery (see tests/run.php).
    public $mockConsoleOutput = false;
}
