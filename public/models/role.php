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
    $sql = 'Select Count(*) from role r,subject s, teacher t, class c where r.teacherid = t.id and r.subjectid = s.id and r.classid = c.id';
    $q = self::$db->prepare($sql);
    $q->execute();
    return $q->fetchColumn();
  }
  function getPageSize(){
    return self::$pageSize;
  }
  function addNewRole($teacherid,$subjectid,$classid){
    if($this->checkRoleExist($subjectid,$classid)===false){
      $sql = 'Insert into Role (teacherid,subjectid,classid) values (?,?,?)';
      $q = self::$db->prepare($sql);
      if($q->execute(array($teacherid,$subjectid,$classid))){
        $roleid = self::$db->lastInsertId();
        $score = new Score();
        $score->initScoreWithNewRole($roleid,$classid);
        return true;
      }
      return false;
    }
    return false;
  }
  function getRoleId($subjectid,$classid){
    $sql = 'Select r.id From role r,subject s, teacher t, class c Where r.teacherid = t.id and r.subjectid = s.id and r.classid = c.id and s.id = ? and c.id =?';
    $q = self::$db->prepare($sql);
    $q->execute(array($subjectid,$classid));
    return $q->fetch()['id'];
  }
  function checkRoleExist($subjectid,$classid){
    return true? $this->getRoleId($subjectid,$classid)!=null:false;
  }
  function deleteRole($id){
    $sql = 'Delete From Role Where id = ?';
    $q = self::$db->prepare($sql);
    if($q->execute(array($id))){
      $score = new Score();
      return $score->deleteScoreWithRole($id);
    }
    return false;
  }
}
?>  