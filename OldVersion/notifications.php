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

<body>
    <h2>Notifications</h2><button>Clear All</button>
    <p>To be approved - ONLY FOR PARENTS</p>
    <ul>

        <?php
            if($ParentOrChild == 1){
        ?>
        <li>Sample: {CHILD NAME} has completed {TASK NAME} <button>Approve</button><button>Reject</button><button>Clear</button></li>

        <?php
            }
        ?>


    </ul>
    <p>Activity (List of Tasks)</p>

<?php
    if($FamilyID != null){

        $sql1 = "SELECT * FROM tasks WHERE FamilyID='$FamilyID'";

        $result = $conn->query($sql1);

        if ($result->num_rows > 0) {
        ?>
        <ul>
        <?php
            while($row = $result->fetch_assoc()) {
                $AmountOfPoints = $row["AmountOfPoints"];
                $TaskName = $row["TaskName"];
                $TaskDescription = $row["TaskDescription"];
                $Deadline = $row["Deadline"];

        ?>
            <li>
        <?php
            echo "Task name : $TaskName | Points : $AmountOfPoints | Deadline : $Deadline";
            echo "<br/>Description : $TaskDescription";
            echo "<br/>";
            }
        ?>
            </li>
        </ul>
        <?php
        }
    }else{
        echo "Please create a Family ID.";
    }
?>
</body>

</html>
