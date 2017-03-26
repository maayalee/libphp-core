<?php
namespace libphp\test;

class mock_object_generator {
  private $parent_classname;
  private $array_methods;
  private $array_args;

  public function get_mock($mockclassname, $parent_classname, $array_methods, $array_args) {
    $this->parent_classname = $parent_classname;
    $this->array_methods = $array_methods; 
    $this->array_args = $array_args;
    $classdeclare = 
            $this->getclassdeclare($mockclassname).
            "{".
            $this->get_constructor().
            $this->get_testmethods().
            $this->get_mockmethod().
            $this->get_mockvariable().  "}";
    eval($classdeclare);
    return new $mockclassname;
  }

  private function getclassdeclare($classname) {
    if ($this->parent_classname)
      return "class $classname extends $this->parent_classname";
    else
      return "class $classname";
  }

  private function get_constructor() {
    $parentconstructorstring = '';
    if ($this->parent_classname)
      //$parentconstructorstring = 'parent::__construct();';
      $parentconstructorstring = '';
    return "public function __construct(){
            \$this->mock = new libphp\\test\\mock_object();
    $parentconstructorstring }";
  }

  private function get_testmethods() {
    $methodstring = '';
    $methodindex = 0;
    foreach($this->array_methods as $method)
      {
      //$methodstring .= $this->get_method(
      //        $method, $this->array_args[$methodindex++]);
      $argstring = $this->get_method_arguments($this->array_args[$methodindex++]);
      $methodstring .= $this->get_method($method, $argstring);

      }
    return $methodstring;
  }

  private function get_method_arguments($args) {
    $argdeclare = '';
    if (is_array($args))
      {
      for ($i = 0; $i < count($args); $i++)
        {
        if ($i  < (count($args) - 1))
          $argdeclare .= "\$".$args[$i].",";
        else
          $argdeclare .= "\$".$args[$i];
        }
      }
    else
      {
      if ($args)
        $argdeclare = "\$".$args;
      }
    return $argdeclare;
  }

  private function get_method($method, $arg) {
    return "public function ".$method."(".$arg.")".
            "{ return \$this->mock->get_return(\"$method\");}";
  }

  private function get_mockmethod() {
    return 'public function set_return($methodname, $returnvals){
      $this->mock->set_return($methodname, $returnvals);
    }';
  }

  private function get_mockvariable() {
    return 'private $mock; ';
  } 
}
