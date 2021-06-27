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
} else {
    header('Location: register.php'); exit;
}
?>
    <meta charset="utf-8">
    <title>Leaderboard/Rewards</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="theme.css" />
</head>

<body class="mainApp">
    <!--Navbar-->
    <ul class="nav">
        <li><a href="dashboard.html" title="Dashboard">Dashboard</a></li>
        <li><a href="notifications.html" title="Notifications">Notifications</a></li>
        <li><a href="" class="active" title="Leaderboard/Rewards">Leaderboard/Rewards</a></li>
        <!--Add sign out functionality-->
        <li style="float:right"><a id="signOutButton" href="#" title="Sign Out">Sign Out</a></li>
    </ul>

    <div class="container">
        <section class="a">
            <h1>Leaderboard:</h1>
            <table>
                <tr>
                    <th class="nametitle">Name"</th>
                    <th>Score</th>
                </tr>
                <tr>
                <?php
                    if($FamilyID != null){
                        $sql2 = "SELECT * FROM users WHERE FamilyID='$FamilyID' AND ParentOrChild=0";

                        $result = $conn->query($sql2);

                        if ($result->num_rows > 0) {

                            while($row = $result->fetch_assoc()) {
                                $childID = $row["UserID"];
                                $Username = $row["Username"];
                                
                                break;
                            }
                        }

                        $sql3 = "SELECT * FROM points WHERE UserID='$childID'";

                        $result = $conn->query($sql3);
                        $child_count = 0;
                        if ($result->num_rows > 0) {
                            $child_count = 1;
                            while($row = $result->fetch_assoc()) {
                                ?>
                                <td><?= $Username; ?>&ensp;&ensp;</td>
                                <td class="score"><?= $row["AmountOfPoints"] ?></td>
                                <?php
                                break;
                            }
                        }

                    }
                ?>
                </tr>
            </table>
        </section>
        <?php
        if($FamilyID != null){
        ?>
        <section class="b">
            <h1>Rewards:</h1><br />
            
            <!--[BEGIN]PARENTS ONLY-->
            <button id="createNewRewardButtonForModal"><span><i class="far fa-edit"></i> Add Reward</span></button>
            <div id="createNewRewardModal" class="modal-background">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <div class="mainForm">
                        <form action="" name="createNewRewardForm">
                            <table>
                                <tr>
                                    <th>Reward Name:</th>
                                    <td><input type="text" name="rewardName" placeholder="Reward Name..." /></td>
                                </tr>
                                <tr>
                                    <th>Reward Description:</th>
                                    <td><textarea name="rewardDescription" placeholder="Reward Description...."></textarea></td>
                                </tr>
                                <tr>
                                    <th>Price:</th>
                                    <td><input type="number" name="pointValue" placeholder="Points..." /></td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;" colspan="2"><button class="button" type="submit"><span>Add Reward</span></button></td>
                                    <!--BACKEND: Once reward is added, close modal-->
                                </tr>
                            </table>
                        </form>
                        <?php
                                    if(isset($_POST["rewardName"]) && isset($_POST["rewardDescription"]) && isset($_POST["pointValue"])){
                                            if($child_count > 0){
                                                // $childID

                                            }else{
                                                echo "Unable to add reward. Please add a child first.";
                                            }
                                    }


                            ?>
                    </div>
                </div>
            </div>
            <script>
                var createNewRewardButtonForModal = document.querySelector("#createNewRewardButtonForModal");
                var createNewRewardModal = document.querySelector("#createNewRewardModal");
                var closeButton = document.querySelector(".close");
                createNewRewardButtonForModal.onclick = () => {
                    createNewRewardModal.style.display = "block";
                };
                closeButton.onclick = () => {
                    createNewRewardModal.style.display = "none";
                };
            </script>
            <!--[END]PARENTS ONLY-->

            <div class="flexpool">
                <!--Dump all prize cards here, sort from lowest price (top) to highest price (bottom)-->
                <?php

                        $sql1 = "SELECT * FROM tasks WHERE FamilyID='$FamilyID'";

                        $result = $conn->query($sql1);

                        if ($result->num_rows > 0) {

                            while($row = $result->fetch_assoc()) {
                                $AmountOfPoints = $row["AmountOfPoints"];
                                $TaskName = $row["TaskName"];
                                $TaskDescription = $row["TaskDescription"];
                                $Deadline = $row["Deadline"];

                                ?>
                                <div class="card">
                                    <h2><?= $TaskName; ?></h2>
                                    <p><?= $TaskDescription; ?></p>
                                </div>
                                <?php  
                            }
                        }else{
                            echo "No reward created.";
                        }
    
                        ?>

            </div>
        </section>
        <?php
        }else{
?>

            <section class="b">
                <h1>Please generate a Family ID</h1><br />  
            </section>

        <?php
        }
        ?>
    </div>
    <img id="trippy_twisty_tabs" src="img/trippy_twisty_tabsCropped.png" />
    <img id="trash_girl" src="img/trash_girl.png" />
    <img id="moneybags_dad" src="img/moneybags_dad.png" />

</body>

</html>