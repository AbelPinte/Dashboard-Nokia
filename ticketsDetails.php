<?php
  session_start();
  include "db_conn.php";
  include "utilities.php";
  if(isset($_SESSION['id']) && isset($_SESSION['user_name']) && isset($_SESSION['role'])){

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Home</title>
    <link rel = "stylesheet" type = "text/css" href="ticketsDetails.css">
  </head>
  <body>
    <div class = "sidenav">
      <div class = "opts">
        <a href = "homeAdmin.php">Tickets</a>
        <a href = "#">Profile</a>
        <a href = "logout.php">Log out</a>
      </div>
    </div>

    <?php

    if(isset($_GET["id"])){
      $_SESSION["currentTicketId"] = $_GET["id"];
      $currentTicketId = $_SESSION["currentTicketId"];
      $currentTicket = array();
      $stmt = $conn->prepare("select `id`, `date`, `from`, `subject`, `description`, `priority`, `status`,
        `RCA` from project.tickets where id = ?");

      $stmt->bind_param("i", $currentTicketId);

      $stmt->execute();

      $stmt->store_result();

      if($stmt->num_rows === 1){
        $stmt->bind_result($currentTicket["id"], $currentTicket["date"], $currentTicket["from"], $currentTicket["subject"],
        $currentTicket["description"], $currentTicket["priority"], $currentTicket["status"], $currentTicket["RCA"]);
        $stmt->fetch();
      }

      


    }
     ?>

  </body>
</html>

<?php
}else{
  header("Location: index.php");
  exit();
}

 ?>
