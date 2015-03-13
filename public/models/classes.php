<?php
class Classes extends Model{
  function getListClass($page){
    $offset = self::getOffset($page);
    $sql = 'Select id,name from Class LIMIT ? , ?';
    $q = self::$db->prepare($sql);
    $q->execute(array($offset,self::$pageSize));
    return $q->fetchAll(PDO::FETCH_ASSOC);
  }
  function getAllListClass(){
    $sql = 'Select id,name from Class';
    $q = self::$db->prepare($sql);
    $q->execute();
    return $q->fetchAll(PDO::FETCH_ASSOC);
  }
  function getCountListClass(){
    $sql = 'Select COUNT(*) from Class';
    $q = self::$db->prepare($sql);
    $q->execute();
    return $q->fetchColumn();
  }
  function getPageSize(){
    return self::$pageSize;
  }
  // function getPages($count){
  //   $pages = (int)($count / (self::$pageSize))+1;
  //   return $pages;
  // }
  function addNewClass($name){
    $sql = 'Insert into Class (name) values (?)';
    $q = self::$db->prepare($sql);
    if($q->execute(array($name))){
      return true;
    }
    return false;
  }
  function deleteClass($id){
    $sql = 'Delete From Class Where id = ?';
    $q = self::$db->prepare($sql);
    if($q->execute(array($id))){
      return true;
    }
    return false;
  }
}

?>  