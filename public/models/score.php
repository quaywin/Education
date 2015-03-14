<?php
class Score extends Model{
  function getListStudent($page,$roleid){
    $offset = self::getOffset($page);
    $sql = 'Select s.roleid,s.userid,u.firstname, u.lastname, u.studentcode, s.scoretd, s.scorecm, s.scorefinal from Score s, Users u where s.userid = u.id and s.roleid = ?  LIMIT ? , ?';
    $q = self::$db->prepare($sql);
    $q->execute(array($roleid,$offset,self::$pageSize));
    return $q->fetchAll(PDO::FETCH_ASSOC);
  }
  function getCountListStudent($roleid){
    $sql = 'Select s.roleid,s.userid, u.firstname, u.lastname, u.studentcode, s.scoretd, s.scorecm, s.scorefinal from Score s, Users u where s.userid = u.id and s.roleid = ?';
    $q = self::$db->prepare($sql);
    $q->execute();
    return $q->fetchColumn();
  }
  function initScoreWithNewRole($roleid,$classid){
    $student = new Users();
    $listStudent = $student->getListStudentWithClassId($classid);
    foreach ($listStudent as $value) {
      $sql = 'Insert into Score (userid,roleid,scorecm,scoretd,scorefinal) values (?,?,0,0,0)';
      $q = self::$db->prepare($sql);
      $q->execute(array($value->id,$roleid));
    }
  }
  function deleteScoreWithRole($roleid){
    $sql = 'Delete From Score Where roleid = ?';
    $q = self::$db->prepare($sql);
    if($q->execute(array($roleid))){
      return true;
    }
    return false;
  }
  function updateScore($item){
    $sql = 'Update Score Set scoretd = ?, scorecm = ?, scorefinal = ? Where userid = ? and roleid = ?';
    $q = self::$db->prepare($sql);
    if($q->execute(array($item->scoretd,$item->scorecm,$item->scorefinal,$item->userid,$item->roleid))){
      return true;
    }
    return false;
  }
}
?>  