<?php
namespace libphp\test;

class mock_object {
  private $returnVals;

  public function  __construct() {
    $this->returnVals = array();
  }
  public function set_return($methodName, $returnVals) {
    $this->returnVals[$methodName] = $returnVals;
  }

  public function get_return($methodName) {
    if (isset($this->returnVals[$methodName]))
      return $this->returnVals[$methodName];
  }
}
