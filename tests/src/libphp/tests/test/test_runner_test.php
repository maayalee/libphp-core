<?php
namespace libphp\tests\test;

use libphp\test\test_case;
use libphp\test\test_runner;
use libphp\test\test_suite;
use libphp\tests\test\was_run;

class test_runner_test extends test_case {
  public function __construct($method_name) {
    parent::__construct($method_name);
  }

  public function test_runner() {
    $runner = new test_runner();
    $runner->add(was_run::create_suite());
    $runner->run();

    $summary = $runner->short_summary();
    $this->assert($summary == 'was_run: 1 run, 0 failed', 'test runner summary');
  } 

  public static function create_suite() {
    $suite = new test_suite('test_runner_test');
    $suite->add(new test_runner_test('test_runner'));
    return $suite;
  }
}
