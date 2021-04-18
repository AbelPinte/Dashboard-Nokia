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

    <table id ="ticketsTable">
      <tr>
        <th>Ticket number</th>
        <th>Date</th>
        <th>From</th>
        <th>Subject</th>
        <th>Priority</th>
        <th>Status</th>
      </tr>
      <?php
        $ticktetsSql = "select `id`, `date`, `from`, `subject`, `description`, `priority`, `status` from
        project.tickets";

        $sql = $conn->prepare("select `id`, `date`, `from`, `subject`, `description`, `priority`, `status` from
        project.tickets");

        $sql->execute();
        $res = $sql->get_result();

        if($res->num_rows > 0){
          $data = $res->fetch_all(MYSQLI_ASSOC);
          foreach($data as $row){
            echo "<tr class = 'table-row' data-href = 'ticketsDetails.php'><td>" . $row["id"] . "</td><td>" . $row["date"] . "</td><td>" . $row["from"] .
              "</td><td>" . $row["subject"] . "</td><td>"  . $row["priority"] . "</td><td>" . $row["status"] . "</td></tr>";
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
    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const rows = document.querySelectorAll("tr[data-href]");

        rows.forEach(row => {
          row.addEventListener("click", () => {
            window.location.href =  row.dataset.href;
          });
        });
        console.log(rows);
      });

    </script>
  </body>
</html>

<?php
}else{
  header("Location: index.php");
  exit();
}

 ?>
