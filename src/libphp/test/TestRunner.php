<?php
namespace libphp\test;

class TestRunner { 
  public function __construct() {
    $this->testSuite = array();
    $this->result  = '';
    $this->shortResult = '';
  }

  public function add(TestSuite $testSuite) {
    array_push($this->testSuite, $testSuite);
  }

  public function run() {
    foreach($this->testSuite as $testSuite) {
      $testSuite->run();
      $this->result .= ($testSuite->summary() . PHP_EOL);
      $this->shortResult .= ($testSuite->shortSummary() . PHP_EOL);
    }
  }

  public function shortSummary() {
    return trim($this->shortResult, PHP_EOL);
  }

  public function summary() {
    return trim($this->result, PHP_EOL);
  }

  private $testSuites;
  private $result;
  private $shortResult;

}

