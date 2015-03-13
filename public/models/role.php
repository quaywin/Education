<?php
class Role extends Model{
  function getListRole($page){
    $offset = self::getOffset($page);
    $sql = 'Select r.id,c.name as "class",s.name as "subject",t.name as "teacher" From role r,subject s, teacher t, class c Where r.teacherid = t.id and r.subjectid = s.id and r.classid = c.id LIMIT ? , ?';
    $q = self::$db->prepare($sql);
    $q->execute(array($offset,self::$pageSize));
    return $q->fetchAll(PDO::FETCH_ASSOC);
  }
  function getCountListRole(){
    $sql = 'select Count(*) from role r,subject s, teacher t, class c where r.teacherid = t.id and r.subjectid = s.id and r.classid = c.id';
    $q = self::$db->prepare($sql);
    $q->execute();
    return $q->fetchColumn();
  }
  function getPageSize(){
    return self::$pageSize;
  }
  function addNewRole($teacherid,$subjectid,$classid){
    if($this->checkRoleExist($teacherid,$subjectid,$classid)===false){
      $sql = 'Insert into Role (teacherid,subjectid,classid) values (?,?,?)';
      $q = self::$db->prepare($sql);
      if($q->execute(array($teacherid,$subjectid,$classid))){
        return true;
      }
      return false;
    }
    return false;
  }
  function checkRoleExist($teacherid,$subjectid,$classid){
    $sql = 'Select * From role r,subject s, teacher t, class c Where r.teacherid = t.id and r.subjectid = s.id and r.classid = c.id and t.id = ? and s.id = ? and c.id =?';
    $q = self::$db->prepare($sql);
    $q->execute(array($teacherid,$subjectid,$classid));
    return true? $q->fetch()!=null:false;
  }
  function deleteRole($id){
    $sql = 'Delete From Role Where id = ?';
    $q = self::$db->prepare($sql);
    if($q->execute(array($id))){
      return true;
    }
    return false;
  }
}

?>  