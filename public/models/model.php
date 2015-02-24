<?php
abstract class Model {
  public static $db;
  public function __construct( ) {
    self::$db = new PDO('sqlite:db.sqlite3');
  }
  function array_to_obj($array, &$obj)
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
  function arrayToObject($array)
  {
   $object= new stdClass();
   return $this->array_to_obj($array,$object);
  }
}
?>