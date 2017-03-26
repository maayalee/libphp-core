<?php
namespace libphp\tests\test;

use libphp\test\test_case;
use libphp\test\test_suite;

class was_run extends test_case {
  public $log = '';

  public function __construct($method_name) {
    parent::__construct($method_name);
  }

  public function set_up() {
    $this->log .= 'set_up ';
  }

  public function tear_down() {
    $this->log .= 'tear_down ';
  }

  public function test_run() {
    $this->log .= 'test_run ';
  }

  public static function create_suite() {
    $result = new test_suite('was_run');
    $result->add(new was_run('test_run'));
    return $result;
  }
}
