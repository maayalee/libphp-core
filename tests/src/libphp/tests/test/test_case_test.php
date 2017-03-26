<?php
namespace libphp\tests\test;

use libphp\test\test_case;
use libphp\test\test_result;
use libphp\test\test_suite;
use libphp\tests\test\was_run;

class test_case_test extends test_case {
  public function __construct($method_name) {
    parent::__construct($method_name);
  }

  public function test_run() {
    $result = new test_result('test_result');

    $was_run = new was_run('test_run');
    $was_run->run($result);
    $this->assert(0 == strcmp('set_up test_run tear_down ', $was_run->log), 'test case run');
  } 

  public function test_summary() {
    $result = new test_result('test_result');
    $was_run = new was_run('test_run');

    $was_run->run($result);
    $this->assert(0 == strcmp('test_result: 1 run, 0 failed', $result->short_summary()), 'test result summary');
  }

  public function test_mock_libs() {
    $test = new test_class();
    $this->assert('foo' == $test->foo(), 'original value is foo');
    $this->assert('bar(1)' == $test->bar(1), 'original value is bar(1)');
    $mock = $this->generate_mock('mock_test_class', 
                                 'libphp\tests\test\test_class', 
                                 array('foo', 'bar'), 
                                 array(null, 'param'));
    $mock->set_return('foo', 'mock_foo');
    $mock->set_return('bar', 'mock_bar(2)');
    $this->assert('mock_foo' == $mock->foo(), 'mock value is mock_foo');
    $this->assert('mock_bar(2)' == $mock->bar(1), 'mock value is mock_bar(2)');
  }

  public static function create_suite() {
    $suite = new test_suite('test_case_test');
    $suite->add(new test_case_test('test_run'));
    $suite->add(new test_case_test('test_summary'));
    $suite->add(new test_case_test('test_mock_libs'));
    return $suite;
  }
}
