<?php

  // Added PhP code by Srdjan Grbic

  include "connection.php";
  session_start();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login/Register</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="indexstyle.css">
</head>

<body>
    <div class="register main">
        <div class="header">
            <h1>New Around Here?</h1>
            <h2>Sign Up Here:</h2>
            <p><a href="javascript:void(0);" onclick="document.querySelector('.register.main').style.display = 'none'; document.querySelector('.login.main').style.display = 'block';">Already Signed Up?</a></p>
        </div>
        <div class="mainForm">
            <form method = "POST" action="#" name="registerForm" onsubmit="validateForms()">
                <div class="flex">
                    <div class="left">
                        <table>
                            <tr>
                                <th>Email:</th>
                                <td><input type="email" required name="Email" placeholder="Email..." /></td>
                            </tr>
                            <tr>
                                <th>Username:</th>
                                <td><input type="text" required name="Username" placeholder="Username..." /></td>
                            </tr>
                            <tr>
                                <th>Password:</th>
                                <td><input type="password" id="password" required name="Password" placeholder="Password..." /></td>
                            </tr>
                            <tr>
                                <th>Confirm Password:</th>
                                <td><input type="password" id="confirm_password" required name="confirmPassword" placeholder="Confirm Password..." onkeyup="check();" /></td>
                            </tr>
                            <tr>
                                <td id="errormessage"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="right">
                        <table>
                            <tr>
                                <td>
                                    <label>
                                        <input type="radio" name="ChildOrParent" value="Parent" required />
                                        Parent
                                    </label>
                                </td>
                                <td>
                                    <label>
                                        <input id="childRadio" type="radio" name="ChildOrParent" value="Child" required />
                                        Child
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td id="familyid"><strong>Family ID:</strong><input type="number" placeholder="Family ID." /></td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="file" accept="image/png, image/jpeg" onchange="preview_image(event)">
                                </td>
                                <td>
                                    <!--Preview Image-->
                                    <img id="output_image"/>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <button name = "MakeYourAccount">Make your account.. </button>
                <!-- Insert your PhP Register code here -->
            </form>
        </div>
    </div>
    <div class="login main">
        <div class="header">
            <h1>Welcome Back,</h1>
            <h2>Login Here:</h2>
            <p><a href="javascript:void(0);" onclick="document.querySelector('.login.main').style.display = 'none'; document.querySelector('.register.main').style.display = 'block';">Don't Have An Account?</a></p>
        </div>
        <div class="mainForm">
            <form method = "POST" action = "#">
                <table>
                    <tr>
                        <th>Username:</th>
                        <td><input type="text" name="uname" placeholder="Name..." required></td>
                    </tr>
                    <tr>
                        <th>Password:</th>
                        <td><input type="password" required name="Pass" placeholder="Password..." required ></td>
                    </tr>
                    <tr>
                        <td colspan="2"><button name = "LogInButton" >Login</button></td>
                    </tr>
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

                          header('Location: profile.php');

                        }
                        else{
                          echo "You entered wrong E-mail or Password! ";
                        }

                      }
                    ?>
                </table>
            </form>
        </div>
    </div>
    <script>
        var check = function() {
            var password = document.getElementById('password');
            var confirm_password = document.getElementById('confirm_password');
            var errormessage = document.getElementById('errormessage');
            var returnVal = false;
            if (password.value == confirm_password.value) {
                errormessage.style.color = 'green';
                errormessage.innerHTML = 'passwords match';
                returnVal = true;
            } else {
                errormessage.style.color = 'red';
                errormessage.innerHTML = 'passwords do not match';
            }
            return returnVal;
        };
        let familyidElem = document.getElementById('familyid');
        let childRadioElem = document.getElementById('childRadio');

        function displayFamilyID() {
            if (!childRadioElem.checked) familyidElem.style.display = "none";
            else familyidElem.style.display = "block";
        }
        document.forms["registerForm"]["parentOrChild"].forEach((radioElement) => {
            radioElement.addEventListener("click", displayFamilyID);
        });




        var pfpImage = document.querySelector("#pfpImage");
        pfpImage.addEventListener("change", () => {
            var pfpImageFileSize = pfpImage.files.item(0).size;
            if (Math.round(pfpImageFileSize / 1024) >= 5120) {
                alert("Image file is too large, must be less than 5MB"); //Exit this and try again
                return;
            } else {
                //Image is of size, proceed to canvas to get dataURL and send to server
                var previewPFP = document.querySelector("#previewPFP");
                var file = pfpImage.files[0];
                var reader = new FileReader();
                var result;
                reader.addEventListener("load", () => {
                    previewPFP.src = reader.result;
                    result = reader.result;
                }, false);
                if (file) {
                    reader.readAsDataURL(file);
                }
            }
        }, false);


        function preview_image(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('output_image');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }


        function validateForms(event) {
            event.preventDefault(); //Don't submit form

            if (!check()) {
                //Passwords don't match we are leaving
                alert("Passwords do not match, try again");
                return;
            }

            /**
             * If register form
             * make sure password and confirm password match
             * make sure image is less than 5mb
             */
        }
        //Add event listeners to both forms onsubmit
        var mainForms = document.querySelectorAll(".mainForm form");
        mainForms.forEach((mainForm) => {
            mainForm.addEventListener("submit", validateForms);
        });
    </script>
</body>

</html>
