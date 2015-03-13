<?php
class Teacher extends Model{
  function getListTeacher($page){
    $offset = self::getOffset($page);
    $sql = 'Select id,name from Teacher LIMIT ? , ?';
    $q = self::$db->prepare($sql);
    $q->execute(array($offset,self::$pageSize));
    return $q->fetchAll(PDO::FETCH_ASSOC);
  }
  function getAllListTeacher(){
    $sql = 'Select id,name from Teacher';
    $q = self::$db->prepare($sql);
    $q->execute();
    return $q->fetchAll(PDO::FETCH_ASSOC);
  }
  function getCountListTeacher(){
    $sql = 'Select COUNT(*) from Teacher';
    $q = self::$db->prepare($sql);
    $q->execute();
    return $q->fetchColumn();
  }
  function addNewTeacher($name){
    $sql = 'Insert into Teacher (name) values (?)';
    $q = self::$db->prepare($sql);
    if($q->execute(array($name))){
      return true;
    }
    return false;
  }
  function deleteTeacher($id){
    $sql = 'Delete From Teacher Where id = ?';
    $q = self::$db->prepare($sql);
    if($q->execute(array($id))){
      return true;
    }
    return false;
  }
}

?>  