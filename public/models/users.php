<?php
/**
* 
*/
class User
{
  public $id,$username,$firstname,$lastname,$gender,$address,$phone,$classid,$type,$studentcode,$displayname,$genderName;
  public function __construct(){
    $this->displayname = "{$this->firstname} {$this->lastname}";
    if($this->gender == 0){
      $this->genderName = "Male";
    }else{
      $this->genderName = "Female";
    }
    
  }
}
class Users extends Model {
  
  function getUserLogin($username,$password){
    $sql = 'Select id,username,type from Users where username = ? and password =? limit 1';
    $q = self::$db->prepare($sql);
    $q->execute(array($username,$password));
    return $q->fetch();
  }
  function getUserByUserName($username){
    $sql = 'Select id from Users where username = ? limit 1';
    $q = self::$db->prepare($sql);
    $q->execute(array($username));
    return true? $q->fetch()!=null:false;
  }
  function getUserById($id){
    $sql = 'Select id,username,firstname,lastname from Users where id = ? limit 1';
    $q = self::$db->prepare($sql);
    
    $q->execute(array($id));
    $q->setFetchMode(PDO::FETCH_CLASS,'User');
    return $q->fetch();
  }
  function getAllUser(){
    $sql = 'Select * from Users';
    $q = self::$db->prepare($sql);
    $q->execute();
    $q->setFetchMode(PDO::FETCH_CLASS,'User');
    return $q->fetchAll();
  }
  function addNewUser($firstname,$lastname,$username,$password){
    $sql = 'Insert into Users (username,password,firstname,lastname) values (?,?,?,?)';
    $q = self::$db->prepare($sql);
    if($q->execute(array($username,$password,$firstname,$lastname))){
      return $this->getUserLogin($username,$password);
    }
    return null;
  }
  function addNewStudent($firstname,$lastname,$username,$password,$bod,$gender,$address,$phone,$classid,$studentcode){
    $sql = 'Insert into Users (username,password,firstname,lastname,bod,gender,address,phone,classid,studentcode) values (?,?,?,?,?,?,?,?,?,?)';
    $q = self::$db->prepare($sql);
    if($q->execute(array($username,$password,$firstname,$lastname,$bod,$gender,$address,$phone,$classid,$studentcode))){
      return true;
    }
    return false;
  }
  function validSingIn($username,$password){
    $valid = array();
    //check user name
    if($username==""){
      array_push($valid,"Username is required");
    }
    //check password
    if($password==""){
      array_push($valid,"Password is required");
    }
    if($username!="" && $password!=""){
      $results = $this->getUserLogin($username,$password);
      if($results==null){
        array_push($valid,"The password or username you enter is incorrect");
      }else{
        return array("status"=>true,"data"=>$results[0],"type"=>$results[2]);
      }
    }
    return array("status"=>false,"data"=>$valid);
  }
  function validSignUp($firstname,$lastname,$username,$password,$repassword){
    $valid = new stdClass();
    //check first name
    if(trim($firstname)==""){
      $valid->FirstName = "First name is required";
    }
    //check last name
    if(trim($lastname)==""){
      $valid->LastName = "Last name is required";
    }
    //check user name
    if(trim($username)==""){
      $valid->Email = "Email is required";
    }else{
      if (!filter_var(trim($username), FILTER_VALIDATE_EMAIL)) {
        $valid->Email = "Invalid email format";
      }else{
        if($this->getUserByUserName(trim($username))){
          $valid->Email = "Email is exists";
        }
      }
    }
    //check password
    if($password==""){
      $valid->Password = "Password is required";
    }
    if($repassword==""){
      $valid->RePassword = "Re-password is required";
    }
    if(!isset($valid->Password) and !isset($valid->RePassword)){
      if($password!=$repassword){
        $valid->RePassword = "Re-password and password is not matched";
      }
    }
    if(isset($valid->FirstName) || isset($valid->LastName) || isset($valid->Email) || isset($valid->Password) || isset($valid->RePassword))
      return $valid;
    else
      return null;
  }
}
?>