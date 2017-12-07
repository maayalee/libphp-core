<?php
namespace libphp\test;

class MockObject {
  private $returnVals;

  public function  __construct() {
    $this->returnVals = array();
  }
  public function setReturn(string $methodName, $returnVals) {
    $this->returnVals[$methodName] = $returnVals;
  }

  public function getReturn(string $methodName) {
    if (isset($this->returnVals[$methodName]))
      return $this->returnVals[$methodName];
  }
}
