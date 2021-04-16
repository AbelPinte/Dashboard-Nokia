<?php
  session_start();
  include "db_conn.php";
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
        <a href = "#" onclick = "displayTableTickets()">Tickets</a>
        <a href = "#">Profile</a>
        <a href = "logout.php">Log out</a>
      </div>
    </div>


    <table >
      <tr>
        <td>Ticket number</td>
        <td>Date</td>
        <td>From</td>
        <td>Subject</td>
        <td>Description</td>
        <td>Priority</td>
        <td>Status</td>
        <td>RCA</td>
      </tr>
      <?php
        $ticktetsSql = "select `id`, `date`, `from`, `subject`, `description`, `priority`, `status` from
        project.tickets";

        $sql = $conn->prepare("select `id`, `date`, `from`, `subject`, `description`, `priority`, `status` from
        project.tickets");

        $sql->execute();
        $res = $sql->get_result();

        $result = mysqli_query($conn, $ticktetsSql);

        if($res->num_rows > 0){
          $data = $res->fetch_all(MYSQLI_ASSOC);
          foreach($data as $row){
            echo "<tr><td>" . $row["id"] . "</td><td>" . $row["date"] . "</td><td>" . $row["from"] .
              "</td><td>" . $row["subject"] . "</td><td>" . $row["description"] .
                "</td><td>" . $row["priority"] . "</td><td>" . $row["status"] . "</td></tr>";
          }

        }else{
          echo "No tickets";
        }

       ?>
    </table>
    <form action="addTicket.php" method = "post">
      <div class ="addTicketButton">
        <button  type = "submit">Add Ticket</button>
      </div>
    </form>
  </body>
</html>

<?php
}else{
  header("Location: index.php");
  exit();
}

 ?>
