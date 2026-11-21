<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // The tests run without Mockery (see tests/run.php).
    public $mockConsoleOutput = false;

    protected function setUp(): void
    {
        parent::setUp();
        \App\Support\SiteTexts::forget();            // the texts cache lives in files: start every test clean
    }
}
