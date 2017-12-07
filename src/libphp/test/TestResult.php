<?php
namespace libphp\test;

class TestResult { 
  public function __construct(string $testCaseName) {
    $this->testCaseName = $testCaseName;
    $this->runCount = 0;
    $this->failedCount = 0;
    $this->failedMessages = array();
  }

  public function addRunCount() {
    $this->runCount += 1;
  }

  public function addFailed(string $method_name, string $message) {
    $this->failedCount += 1;
    $this->failedMessages[$method_name] = $message;
  }

  public function summary() {
    $result = $this->testCaseName. ': '.  $this->runCount.' run, '.$this->failedCount.' failed';
    if ($this->failedCount > 0) {
      $result .= PHP_EOL;
      $result .= $this->getFailedMessage();
    }
    return $result;
  }

  private function getFailedMessage() {
    $result = '';
    foreach ($this->failedMessages as $method=>$message) {
      $result .= (">Method: $method". PHP_EOL . $message . PHP_EOL);
    }
    return $result;
  }

  public function shortSummary() {
    $result = $this->testCaseName. ': '.  $this->runCount.' run, '.$this->failedCount.' failed';
    if ($this->failedCount > 0) {
      $result .= PHP_EOL;
      $result .= $this->getShortFailedMessage();
    }
    return $result;
  }

  private function getShortFailedMessage() {
    $result = '';
    foreach ($this->failedMessages as $method=>$message) {
      $result .= (">Method: $method". PHP_EOL);
    }
    return $result;
  }

  private $testCaseName;
  private $runCount;
  private $failedCount;
  private $failedMessages;

}
?>
