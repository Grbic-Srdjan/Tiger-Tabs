<!DOCTYPE html>
<html>

<head>
<?php
require_once("connection.php");
session_start();

if(isset($_SESSION["UserID"])){
    $userID = $_SESSION["UserID"];
    $conn = new mysqli(SERVER, USER, PASSWORD, DATABASE);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql0 = "SELECT * FROM users WHERE UserID='$userID'";

    $result = $conn->query($sql0);

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $Email = $row["Email"];
        $FamilyID = $row["FamilyID"];
        $ParentOrChild = $row["ParentOrChild"];
        $Username = $row["Username"];
        $FamilyID = $row["FamilyID"];
        break;
      }
    }
    
}else{
    header('Location: register.php'); exit;
}
?>
    <title>Notifications</title>
    <link rel="stylesheet" href="theme.css" />
</head>

<body class="mainApp">
    <!--Navbar-->
    <ul class="nav">
        <li><a href="dashboard.html" title="Dashboard">Dashboard</a></li>
        <li><a class="active" href="" title="Notifications">Notifications</a></li>
        <li><a href="leaderboard.html" title="Leaderboard/Rewards">Leaderboard/Rewards</a></li>
        <!--Add sign out functionality-->
        <li style="float:right"><a id="signOutButton" href="#" title="Sign Out">Sign Out</a></li>
    </ul>
    <div style="margin-left: 4rem;">
        <h2>Notifications</h2>
        <p>To be approved - ONLY FOR PARENTS</p>
        <ul>
        <?php
            if($ParentOrChild == 1){
        ?>
        <li>Sample: {CHILD NAME} has completed {TASK NAME} <button class="icon" alt="Accept Task"><i class="fas fa-check"></i></button>&nbsp;<button class="icon" alt="Reject Task"><i class="fas fa-times"></i></button></li>

        <?php
            }
        ?>
            
        </ul>
        <p>Activity <button>Clear All</button></p>
        <ul>
            <li>Sample: {CHILD NAME} has accepted {TASK NAME} <button>Clear</button></li>
        </ul>
    </div>
    <img id="trippy_twisty_tabs" src="img/trippy_twisty_tabsCropped.png" />
    <img id="trash_girl" src="img/trash_girl.png" />
    <img id="moneybags_dad" src="img/moneybags_dad.png" />

</body>

</html>