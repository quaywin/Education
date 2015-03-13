<?php
abstract class Model {
  public static $db;
  public static $pageSize = 10;
  public function __construct( ) {
    self::$db = new PDO('sqlite:db.sqlite3');
  }

  public function array_to_obj($array, &$obj)
  {
    foreach ($array as $key => $value)
    {
      if (is_array($value))
      {
      $obj->$key = new stdClass();
      array_to_obj($value, $obj->$key);
      }
      else
      {
        $obj->$key = $value;
      }
    }
  return $obj;
  }

  public function getOffset($page){
    return ($page-1)*self::$pageSize;
  }

  public function arrayToObject($array)
  {
   $object= new stdClass();
   return $this->array_to_obj($array,$object);
  }
  public static function getPages($count){
    if(($count % self::$pageSize)>0){
      $pages = (int)($count / self::$pageSize)+1;
    }else{
      $pages = (int)($count / self::$pageSize);
    }
    
    return $pages;
  }
}
?>