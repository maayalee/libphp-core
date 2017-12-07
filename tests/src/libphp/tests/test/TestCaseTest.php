<?php
namespace libphp\tests\test;

use libphp\test\TestCase;
use libphp\test\TestResult;
use libphp\test\TestSuite;
use libphp\tests\test\WasRun;

class TestCaseTest extends TestCase {
  public function __construct($methodName) {
    parent::__construct($methodName);
  }

  public function testRun() {
    $result = new TestResult('TestResult');

    $wasRun = new WasRun('testRun');
    $wasRun->run($result);
    $this->assert(0 == strcmp('setUp testRun tearDown ', $wasRun->log), 'test case run');
  } 

  public function testSummary() {
    $result = new TestResult('TestResult');
    $wasRun = new WasRun('testRun');

    $wasRun->run($result);
    $this->assert(0 == strcmp('TestResult: 1 run, 0 failed', $result->shortSummary()), 'test result summary');
  }

  public function testMockLibs() {
    $test = new TestClass();
    $this->assert('foo' == $test->foo(), 'original value is foo');
    $this->assert('bar(1)' == $test->bar(1), 'original value is bar(1)');
    $mock = $this->generateMock('MockTestClass', 
                                 'libphp\tests\test\TestClass', 
                                 array('foo', 'bar'), 
                                 array(null, 'param'));
    $mock->setReturn('foo', 'mock_foo');
    $mock->setReturn('bar', 'mock_bar(2)');
    $this->assert('mock_foo' == $mock->foo(), 'mock value is mock_foo');
    $this->assert('mock_bar(2)' == $mock->bar(1), 'mock value is mock_bar(2)');
  }

  public static function createSuite() {
    $suite = new TestSuite('TestCaseTest');
    $suite->add(new TestCaseTest('testRun'));
    $suite->add(new TestCaseTest('testSummary'));
    $suite->add(new TestCaseTest('testMockLibs'));
    return $suite;
  }
}
