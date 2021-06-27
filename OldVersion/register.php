<!DOCTYPE html>
<html>

<head>
<?php
require_once("connection.php");
$msg = "";
if( isset($_POST['parentOrChild'])  &&
    isset($_POST['email'])  &&
    isset($_POST['username'])  &&
    isset($_POST['password']) ){

    $ParentOrChild = $_POST['parentOrChild'];
    $Email = $_POST['email'];
    $Username = $_POST['username'];
    $Password = $_POST['password'];

    // Create connection
    $conn = new mysqli(SERVER, USER, PASSWORD, DATABASE);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $target_dir = "uploads/";
    $time = time();
    $target_file = $target_dir . $time.basename($_FILES["pfpImage"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


    //Check if email already exists
    $sql0 = "SELECT UserID FROM users WHERE Email='$Email'";
    $result = $conn->query($sql0);

    if ($result->num_rows > 0) {
        $msg = "Email ID already exists. Try different email ID.";
    }else{
        $familyID = 0;

        $check = getimagesize($_FILES["pfpImage"]["tmp_name"]);
        if($check !== false) {
            if (move_uploaded_file($_FILES["pfpImage"]["tmp_name"], $target_file)) {
                $pfpImage = $time.htmlspecialchars( basename( $_FILES["pfpImage"]["name"]));

                $sql1 = "INSERT INTO users (ParentOrChild, Email, Username, Password, UserLogo)
                VALUES ('$ParentOrChild', '$Email', '$Username', '$Password', '$pfpImage')";

                if ($conn->query($sql1) === TRUE) {
                    $UserID = mysqli_insert_id($conn);

                    if($ParentOrChild == 0){
                        $sql2 = "INSERT INTO points (UserID, AmountOfPoints)  VALUES ('$UserID', 0)";

                        if($conn->query($sql2) === TRUE){
                            $msg = "New record created successfully";
                        }else{
                            $msg = "Child created but Unable to add points";
                        }
                    }else{
                        $msg = "New record created successfully";
                    }
                } else {
                    $msg = "Server Error: Unable to add new record".$sql . "<br>" . $conn->error;
                }
            }

        } else {
            $msg = "File is not an image.";
        }
    }
}
?>
    <meta charset="utf-8">
    <title>Login/Register</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="" />
    <style>
        .register.main,
        .register.main .header,
        .login.main,
        .login.main .header {
            text-align: center;
        }

        .register.main,
        #familyid {
            display: none;
        }

        .flex {
            display: flex;
        }

        #previewPFP {
            border-radius: 50%;
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <div class="register main">
        <div class="header">
            <h1>New Around Here?</h1>
            <h2>Sign Up Here:</h2>
            <p><a href="javascript:void(0);" onclick="document.querySelector('.register.main').style.display = 'none'; document.querySelector('.login.main').style.display = 'block';">Already Signed Up?</a></p>
        </div>
        <div class="mainForm">
            <form method = "POST"  action="/web/Hackathon/register.php" name="registerForm" enctype="multipart/form-data" onsubmit="validateForms()">
                <div class="flex">
                    <div class="left">
                        <table>
                            <tr>
                                <th>Name:</th>
                                <td><input type="text" required name="name" placeholder="Name..." /></td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td><input type="email" required name="email" placeholder="Email..." /></td>
                            </tr>
                            <tr>
                                <th>Username:</th>
                                <td><input type="text" required name="username" placeholder="Username..." /></td>
                            </tr>
                            <tr>
                                <th>Password:</th>
                                <td><input type="password" id="password" required name="password" placeholder="Password..." /></td>
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
                                        <input type="radio" name="parentOrChild" value="1" required />
                                        Parent
                                    </label>
                                </td>
                                <td>
                                    <label>
                                        <input id="childRadio" type="radio" name="parentOrChild" value="0" required />
                                        Child
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td id="familyid"><strong>Family ID:</strong><input type="number" placeholder="Family ID." /></td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="file" id="pfpImage" name="pfpImage" accept="image/png, image/jpeg" />
                                    <input type="hidden" id="pfpImageData" name="pfpImageData" />
                                </td>
                                <td>
                                    <!--Preview Image-->
                                    <div id="previewPFP"></div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <button name = "MakeYourAccount">Make your account.. </button>
                <h2><?php echo $msg; ?></h2>


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
            <form action="" name="loginForm">
                <table>
                    <tr>
                        <th>Username:</th>
                        <td><input type="text" required name="name" placeholder="Name..." /></td>
                    </tr>
                    <tr>
                        <th>Password:</th>
                        <td><input type="email" required name="email" placeholder="Email..." /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><button>Login</button></td>
                    </tr>
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





        function validateForms(event) {
            // event.preventDefault(); //Don't submit form

            if (!check()) {
                //Passwords don't match we are leaving
                alert("Passwords do not match, try again");
                return false;
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
