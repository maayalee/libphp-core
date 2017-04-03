<?php
namespace libphp\test;

class test_suite {
  public function __construct(string $suite_name) {
    $this->suite_name = $suite_name;
    $this->test_cases = array();
  }

  public function add(test_case $test_case) {
    array_push($this->test_cases, $test_case);
  }

  public function run() {
    $this->test_result = new test_result($this->suite_name);
    foreach ($this->test_cases as $test_case) {
      $test_case->run($this->test_result);
    }
  }

  public function short_summary() {
    return $this->test_result->short_summary();
  }

  public function summary() {
    return $this->test_result->summary();
  }

  private $suite_name;
  private $test_cases;
  private $test_result;

}

