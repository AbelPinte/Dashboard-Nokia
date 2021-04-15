<?php
  session_start();

  if(isset($_SESSION['id']) && isset($_SESSION['user_name']) && isset($_SESSION['role'])){

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Home</title>
    <link rel = "stylesheet" type = "text/css" href="homeAdmin.css">
  </head>
  <body>
    <div class = "sidenav">
      <div class = "opts">
        <a href = "#">Tickets</a>
        <a href = "#">Profile</a>
        <a href = "logout.php">Log out</a>
      </div>
    </div>

    <h1>Hello, <?php  echo $_SESSION['name']; ?></h1>

  </body>
</html>

<?php
}else{
  header("Location: index.php");
  exit();
}

 ?>
