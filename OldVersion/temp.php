<?php

  // Added PhP code by Srdjan Grbic

  include "connection.php";
  session_start();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Welcome back.</h2>
    <h3>Log in here</h3>
    <div class="login">
    <form method = "POST" action = "#">
        <label for="uname"><b>Username</b></label>
        <input type="text" name="uname" placeholder="Enter Username" required>
        <br><br>
        <label for="pass"><b>Password</b></label>
        <input type="Password" name="Pass" placeholder="Enter Password">
        <br><br>
        <button name = "LogInButton" type="submit">Log In</button>
        <?php
          if(isset($_POST['LogInButton'])){

            $Username = $_POST['uname'];
            $Password = $_POST['Pass'];

            $Query = "SELECT * FROM users WHERE username = '$Username' and password = '$Password'";
            $Result = mysqli_query($Link, $Query) or die ("There was an error while trying to log you in, here :( . Plase try again later on. )");

            $RowNumber = $Result -> num_rows;

            if($RowNumber > 0){

              $Row = mysqli_fetch_row($Result);

              $UserID = $Row[0];
              $FamilyID = $Row[1];
              $ParentOrChild = $Row[2];
              $Email = $Row[3];
              $UsernameOfUser = $Row[4];
              $PasswordOfUser = $Row[5];
              $UserLogo = $Row[6];

              $_SESSION['userid'] = $UserID;
              $_SESSION['familyid'] = $FamilyID;
              $_SESSION['parentorchild'] = $ParentOrChild;
              $_SESSION['email'] = $Email;
              $_SESSION['username'] = $UsernameOfUser;
              $_SESSION['password'] = $Password;
              $_SESSION['userlogo'] = $UserLogo;

              header("Location: profile.php");

            }
            else{
              echo "You entered wrong E-mail or Password! ";
            }

          }
        ?>
    </form>
    </div>
</body>
</html>
