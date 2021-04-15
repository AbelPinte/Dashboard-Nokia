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
  }

  else{
    $auxSql = "select * from project.users where user_name = '$uname' and password = '$password'";

    $auxResult = mysqli_query($conn, $auxSql);

    if(mysqli_num_rows($auxResult) === 1){
      $sql = "select * from project.users where user_name = '$uname' and password = '$password' and role = '$role'";

      $result = mysqli_query($conn, $sql);

      $row = mysqli_fetch_assoc($result);

      if($row['user_name'] === $uname && $row['password'] === $password && $row['role'] === $role){
        $_SESSION['user_name'] = $row['user_name'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['role'] = $row['role'];
        header("Location: homeAdmin.php");
        exit();
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
    }else{
      header("Location: index.php?error=Incorrect username or password");
      exit();
    }
  }


}else{
  header("Location: index.php");
  exit();
}

 ?>
