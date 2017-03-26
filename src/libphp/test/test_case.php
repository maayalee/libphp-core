<?php
namespace libphp\test;

class test_case {
  private $test_method_name;
  private $result;

  public function __construct($test_method_name) {
    $this->test_method_name = $test_method_name;
  }

  public function set_up() {
  }

  public function tear_down() {
  }

  protected function assert($expression, $msg = '') {
    if (! $expression)
      throw new \Exception('test failed: ' . $msg);
  }

  protected function assert_true($expression, $msg = '') {
    if (! $expression)
      throw new \Exception('test failed: ' . $msg);
  }

  protected function assert_false($expression, $msg = '') {
    if ($expression)
      throw new \Exception('test failed: ' . $msg);
  }

  protected function assert_equal($expected, $actual, $msg = '') {
    if ($expected != $actual)
      throw new \Exception('test failed: ' . $msg);
  }

  protected function assert_not_equal($expected, $actual, $msg = '') {
    if ($expected == $actual)
      throw new \Exception('test failed: ' . $msg);
  }

  protected function assert_contains($expected_values, $actual, $msg = '') {
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
  public function generate_mock($class_name, $parent_class_name, $array_methods, $array_args) {
    $gen = new mock_object_generator();
    return $gen->get_mock($class_name, $parent_class_name, $array_methods, $array_args);
  }

  public function run($result) {
    $this->result = $result;
    $result->add_run_count();
    $this->run_method();
  }

  private function run_method() {
    $this->set_up();
    try {
      call_user_func(array($this, $this->test_method_name));
    }
    catch (\Exception $e) {
      $message = $e->getMessage();
      $stack = $e->getTraceAsString();
      $this->result->add_failed($this->test_method_name, "Exception: $message $stack");
    }
    $this->tear_down();
  }
}

?>
