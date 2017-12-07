<?php
namespace libphp\tests\test;

use libphp\test\TestCase;
use libphp\test\TestRunner;
use libphp\test\TestSuite;
use libphp\tests\test\WasRun;

class TestRunnerTest extends TestCase {
  public function __construct($method_name) {
    parent::__construct($method_name);
  }

  public function testRunner() {
    $runner = new TestRunner();
    $runner->add(WasRun::createSuite());
    $runner->run();

    $summary = $runner->shortSummary();
    $this->assert($summary == 'WasRun: 1 run, 0 failed', 'test runner summary');
  } 

  public static function createSuite() {
    $suite = new TestSuite('TestRunnerTest');
    $suite->add(new TestRunnerTest('testRunner'));
    return $suite;
  }
}
