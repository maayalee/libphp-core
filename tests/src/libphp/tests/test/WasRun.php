<?php
namespace libphp\tests\test;

use libphp\test\TestCase;
use libphp\test\TestSuite;

class WasRun extends TestCase {
  public $log = '';

  public function __construct($method_name) {
    parent::__construct($method_name);
  }

  public function setUp() {
    $this->log .= 'setUp ';
  }

  public function tearDown() {
    $this->log .= 'tearDown ';
  }

  public function testRun() {
    $this->log .= 'testRun ';
  }

  public static function createSuite() {
    $result = new TestSuite('WasRun');
    $result->add(new WasRun('testRun'));
    return $result;
  }
}
