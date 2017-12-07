<?php
namespace libphp\test;

class MockObjectGenerator {
  public function getMock(string $mockclassname, string $parentClassname, 
    array $arrayMethods, array $arrayArgs) {
    $this->parentClassname = $parentClassname;
    $this->arrayMethods = $arrayMethods; 
    $this->arrayArgs = $arrayArgs;
    $classdeclare = 
      $this->getclassdeclare($mockclassname).
      "{".
      $this->getConstructor().
      $this->getTestmethods().
      $this->getMockmethod().
      $this->getMockvariable().  "}";
    eval($classdeclare);
    return new $mockclassname;
  }

  private function getclassdeclare($classname) {
    if ($this->parentClassname)
      return "class $classname extends $this->parentClassname";
    else
      return "class $classname";
  }

  private function getConstructor() {
    $parentconstructorstring = '';
    return "public function __construct(){
      \$this->mock = new libphp\\test\\MockObject();
      $parentconstructorstring }";
  }

  private function getTestmethods() {
    $methodstring = '';
    $methodindex = 0;
    foreach($this->arrayMethods as $method) {
      $argstring = $this->getMethodArguments(
        $this->arrayArgs[$methodindex++]);
      $methodstring .= $this->getMethod($method, $argstring);

    }
    return $methodstring;
  }

  private function getMethodArguments($args) {
    $argdeclare = '';
    if (is_array($args)) {
      for ($i = 0; $i < count($args); $i++) {
        if ($i  < (count($args) - 1))
          $argdeclare .= "\$".$args[$i].",";
        else
          $argdeclare .= "\$".$args[$i];
      }
    }
    else {
      if ($args)
        $argdeclare = "\$".$args;
    }
    return $argdeclare;
  }

  private function getMethod($method, $arg) {
    return "public function ".$method."(".$arg.")".
      "{ return \$this->mock->getReturn(\"$method\");}";
  }

  private function getMockmethod() {
    return 'public function setReturn($methodname, $returnvals){
      $this->mock->setReturn($methodname, $returnvals);
  }';
  }

  private function getMockvariable() {
    return 'private $mock; ';
  } 

  private $parentClassname;
  private $arrayMethods;
  private $arrayArgs;
}
