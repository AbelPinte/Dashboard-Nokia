<?php
session_start();
include "db_conn.php";

if(isset($_POST['uname']) && isset($_POST['password']) && isset($_POST['role'])) {

  function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $uname = validate($_POST['uname']);
  $password = validate($_POST['password']);
  $role = validate($_POST['role']);

  if(empty($uname)){
    header("Location: index.php?error=Username is required");
    exit();
  }else if(empty($password)){
    header("Location: index.php?error=Password is required");
    exit();
  }else if($role === "noSelection"){
    header("Location: index.php?error=Role is required");
    exit();
  }else{
    $stmt1= $conn->prepare("select id, user_name, password, name, role from project.users where user_name = ? and password = ?");

    $stmt1->bind_param("ss", $uname, $password);

    $stmt1->execute();

    $stmt1->store_result();

    if($stmt1->num_rows === 1){
      $stmt= $conn->prepare("select id, user_name, password, name, role from project.users where user_name = ? and password = ? and role = ?");

      $stmt->bind_param("sss", $uname, $password, $role);

      $stmt->execute();

      $stmt->store_result();

      if($stmt->num_rows === 1){
        $stmt->bind_result($idAux, $unameAux, $passwordAux, $nameAux, $roleAux);

        $stmt->fetch();
        if($unameAux === $uname && $passwordAux === $password && $roleAux === $role){
          $_SESSION["id"] = $idAux;
          $_SESSION["user_name"] = $unameAux;
          $_SESSION["password"] = $passwordAux;
          $_SESSION["name"] = $nameAux;
          $_SESSION["role"] = $roleAux;
          header("Location: homeAdmin.php");
          exit();
        }
       }else{
       switch($role){
            case "admin":
              header("Location: index.php?error=You can't log in as admin");
              exit();
              break;
            case "employee":
              header("Location: index.php?error=You can't log in as employee");
              exit();
              break;
            case "user":
              header("Location: index.php?error=You can't log in as user");
              exit();
              break;
          }
        }
      }
      else{
        header("Location: index.php?error=Incorrect username or password");
        exit();
      }
    }
}
 ?>
