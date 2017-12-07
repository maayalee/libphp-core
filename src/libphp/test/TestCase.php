<?php
namespace libphp\test;

class TestCase {
  private $testMethodName;
  private $result;

  public function __construct(string $testMethodName) {
    $this->testMethodName = $testMethodName;
  }

  public function setUp() {
  }

  public function tearDown() {
  }

  protected function assert(bool $expression, string $msg = '') {
    if (! $expression)
      throw new \Exception('test failed: ' . $msg);
  }

  protected function assertTrue(bool $expression, string $msg = '') {
    if (! $expression)
      throw new \Exception('test failed: ' . $msg);
  }

  protected function assertFalse(bool $expression, string $msg = '') {
    if ($expression)
      throw new \Exception('test failed: ' . $msg);
  }

  protected function assertEqual($expected, $actual, string $msg = '') {
    if ($expected != $actual)
      throw new \Exception('test failed: ' . $msg);
  }

  protected function assertNotEqual($expected, $actual, string $msg = '') {
    if ($expected == $actual)
      throw new \Exception('test failed: ' . $msg);
  }

  protected function assertContainsl($expected_values, $actual, 
    string $msg = '') {
    if (! is_array($expected_values))
      $expected_values = array($expected_values);
    
    $contain = false;
    foreach ($expected_values as $expected) {
      if ($expected == $actual)
        $contain = true;
    }
    if (false == $contain)
      throw new \Exception('test failed: ' . $msg);
  }

  /**
   * 내가 원하는 메서드를 가지는 목업 오브젝트를 생성한다.
   *
   * @param class_name string 생성하려는 클래스명
   * @param parent_class_name string 생성하려는 클래스의 부모 클래스 명
   * @param array_methods array(string) 생성 클래스가 가지는 메서드 리스트
   * @param array_args array(libs), array(array(libs)) 생성 클래스가 가지는 메서드 파라미터 리스트
   */
  public function generateMock(string $class_name, string $parent_class_name, 
    array $array_methods, array $array_args) {
    $gen = new MockObjectGenerator();
    return $gen->getMock($class_name, $parent_class_name, $array_methods, $array_args);
  }

  public function run(TestResult $result) {
    $this->result = $result;
    $result->addRunCount();
    $this->runMethod();
  }

  private function runMethod() {
    $this->setUp();
    try {
      call_user_func(array($this, $this->testMethodName));
    }
    catch (\Exception $e) {
      $message = $e->getMessage();
      $stack = $e->getTraceAsString();
      $this->result->addFailed($this->testMethodName, "Exception: $message $stack");
    }
    $this->tearDown();
  }
}

?>
