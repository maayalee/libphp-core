<?php
namespace libphp\test;

class TestSuite {
  public function __construct(string $suiteName) {
    $this->suiteName = $suiteName;
    $this->testCases = array();
  }

  public function add(TestCase $test_case) {
    array_push($this->testCases, $test_case);
  }

  public function run() {
    $this->test_result = new TestResult($this->suiteName);
    foreach ($this->testCases as $test_case) {
      $test_case->run($this->test_result);
    }
  }

  public function shortSummary() {
    return $this->test_result->shortSummary();
  }

  public function summary() {
    return $this->test_result->summary();
  }

  private $suiteName;
  private $testCases;
  private $test_result;

}

