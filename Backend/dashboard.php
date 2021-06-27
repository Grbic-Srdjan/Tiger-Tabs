<?php

  // Added PhP code by Srdjan Grbic

  session_start();
  include "connection.php";

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="dashboardstyle.css">
</head>

<body>
    <!--Navbar-->
    <ul>
        <li><a class="active" href="home.html" title="Dashboard">Dashboard</a></li>
        <li><a href="" title="Notifications">Notifications</a></li>
        <li><a href="" title="Rewards">Rewards</a></li>
        <!--Add sign out functionality-->
        <form method = "POST" action = "#">
          <li style="float:right"><button style = "background: rgba(10, 20, 30, 0)" name = "SignOut"><a id="signOutButton">Sign Out</a></button></li>
          <?php
            if(isset($_POST['SignOut'])){
              header('Location: logout.php');
            }
          ?>
        </from>
    </ul>


    <!--This table will only show -->
    <table class="tasksTable">
        <tr>
            <th>Active Tasks:</th>
        </tr>
        <?php
          $CurrentUser = $_SESSION['userid'];
          $ParentOrChild = $_SESSION['parentorchild'];
          if($ParentOrChild == 0){

              $TasksQuery = "SELECT * FROM taskspending WHERE ChildID = $CurrentUser";
              $TasksQueryResult = mysqli_query($Link, $TasksQuery) or die ("An error happened while trying to load up your tasks");
              $NumberOfRows = $TasksQueryResult -> num_rows;

              if($NumberOfRows > 0){
                while(($FoundedRow = mysqli_fetch_row($TasksQueryResult)) != NULL){
                  // Childrent will see this
                  echo "<tr>
                      <td>
                          <div class='flex'>
                            <form method = 'POST' action = '#'>
                              <div>'$FoundedRow[1]'</div>
                                <div>'$FoundedRow[2]'</div>
                                <div>'$FoundedRow[3]'</div>
                                <div><button name = 'AddTask'>&checkmark;</button></div>
                              </div>";
                              if(isset($_POST['AddTask'])){

                                $AddTask = "INSERT INTO `tasks`(`TaskID`, `CreatorID`, `ChildID`, `AmountOfPoints`, `TaskName`, `TaskDescription`, `CreationDate`, `Deadline`) VALUES (NULL,'$FoundedRow[4]','$FoundedRow[5]','$FoundedRow[3]','$FoundedRow[1]','$FoundedRow[2]','$FoundedRow[6]','$FoundedRow[7]')";
                                $AddTaskResult = mysqli_query($Link, $AddTask) or die ("There was an error while trying to add new task. ");

                                $DeleteQuery = "DELETE FROM `taskspending`";
                                $DeleteQueryResult = mysqli_query($Link, $DeleteQuery) or die ("There was an error, while trying to remove pending task. ");

                                header('Location: dashboard.php');

                              }
                            echo "</form>
                        </td>
                    </tr>";
                }
              }
              else{
                echo "<h4>
                  <tr>
                    <td>
                      <div class='lex'>
                          <div>You do not have any tasks going on currently..</div>
                      </div>
                    </td>
                  </tr></h4>";
              }
            }
            else{

              $TasksQuery = "SELECT * FROM taskspending WHERE CreatorID = $CurrentUser";
              $TasksQueryResult = mysqli_query($Link, $TasksQuery) or die ("An error happened while trying to load up your tasks");
              $NumberOfRows = $TasksQueryResult -> num_rows;

              // Parents will see this
              echo "<tr>
                  <td>
                      <div class='flex' >
                          <div>Task Title</div>
                          <div>Task Description</div>
                          <div>Points</div>
                          <div><button>&times;</button></div>
                      </div>
                  </td>
              </tr>";

            }
        ?>
    </table>
    <br />
    <!--This table will show the rest of the tasks not in the previous table-->
    <table class="tasksTable">
        <tr>
            <th>Tasks In Progress:</th>
        </tr>
        <?php

          $UserID = $_SESSION['userid'];
          $TasksQuery = "SELECT * FROM tasks WHERE CreatorID = $UserID OR ChildID = $UserID";
          $TasksQueryResult = mysqli_query($Link, $TasksQuery) or die ("An error happened while trying to load up your tasks");
          $NumberOfRows = $TasksQueryResult -> num_rows;

          if($NumberOfRows > 0){
            while(($FoundedRow = mysqli_fetch_row($TasksQueryResult)) != NULL){

              $ChildIDQuery = "SELECT Username FROM users WHERE UserID = '$FoundedRow[2]' ";
              $ChildIDResult = mysqli_query($Link, $ChildIDQuery) or die ("Could not load the childs name :( . Try again later on. ");
              $ChildID = mysqli_fetch_row($ChildIDResult);

              echo "<tr>
                  <td>
                      <div class='lex'>
                          <div>'$FoundedRow[4]'</div>
                          <div>'$FoundedRow[5]'</div>
                          <div>'$ChildID[0]'</div>
                          <div>'$FoundedRow[3]'</div>
                      </div>
                  </td>
              </tr> ";
            }
          }
          else{
            echo "<h4>
              <tr>
                <td>
                  <div class='lex'>
                      <div>You do not have any tasks going on currently..</div>
                  </div>
                </td>
              </tr></h4>";
          }

        ?>
    </table>
</body>

</html>
