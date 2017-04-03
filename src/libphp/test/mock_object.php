<?php
namespace libphp\test;

class mock_object {
  private $returnVals;

  public function  __construct() {
    $this->returnVals = array();
  }
  public function set_return(string $methodName, $returnVals) {
    $this->returnVals[$methodName] = $returnVals;
  }

  public function get_return(string $methodName) {
    if (isset($this->returnVals[$methodName]))
      return $this->returnVals[$methodName];
  }
}
