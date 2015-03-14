<?php
class Subject extends Model{
  function getListSubject($page){
    $offset = self::getOffset($page);
    $sql = 'Select id,name,code from Subject LIMIT ? , ?';
    $q = self::$db->prepare($sql);
    $q->execute(array($offset,self::$pageSize));
    return $q->fetchAll(PDO::FETCH_ASSOC);
  }
  function getAllListSubject(){
    $sql = 'Select id,name,code from Subject';
    $q = self::$db->prepare($sql);
    $q->execute();
    return $q->fetchAll(PDO::FETCH_ASSOC);
  }
  function getAllListSubjectByClass($classid){
    $sql = 'Select s.id,s.name,s.code from Subject s,Role r where s.id = r.subjectid and r.classid = ?';
    $q = self::$db->prepare($sql);
    $q->execute(array($classid));
    return $q->fetchAll(PDO::FETCH_ASSOC);
  }
  function getCountListSubject(){
    $sql = 'Select COUNT(*) from Subject';
    $q = self::$db->prepare($sql);
    $q->execute();
    return $q->fetchColumn();
  }
  function addNewSubject($name,$code){
    $sql = 'Insert into Subject (name,code) values (?,?)';
    $q = self::$db->prepare($sql);
    if($q->execute(array($name,$code))){
      return true;
    }
    return false;
  }
  function deleteSubject($id){
    $sql = 'Delete From Subject Where id = ?';
    $q = self::$db->prepare($sql);
    if($q->execute(array($id))){
      return true;
    }
    return false;
  }
}

?>  