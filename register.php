<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login/Register</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="theme.css" />
</head>

<body class="radialBackground">
    <div class="register main">
        <div class="header">
            <h1>New Around Here?</h1>
            <h2>Sign Up Here:</h2>
            <p><a href="javascript:void(0);" onclick="document.querySelector('.register.main').style.display = 'none'; document.querySelector('.login.main').style.display = 'block';">Already Signed Up?</a></p>
        </div>
        <div class="mainForm">
            <form action="" name="registerForm" onsubmit="validateForms()">
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
                        <div style="text-align: left;">
                            <p style="margin-bottom: 0;">Are you a parent or a child?</p>
                            <label>
                                <input type="radio" name="parentOrChild" value="parent" required />
                                Parent
                            </label> &emsp;
                            <label>
                                <input id="childRadio" type="radio" name="parentOrChild" value="child" required />
                                Child
                            </label>
                            <div id="familyid">
                                <strong style="font-size: 1.5rem;">Family ID:</strong><input type="number" placeholder="Family ID." />
                            </div>
                            <input type="file" accept="image/png, image/jpeg" onchange="preview_image(event)" />
                        </div>
                        <!--Preview Image-->
                        <img id="output_image" src="a.a" alt="Select an image" />
                    </div>
                </div>
                <button type="submit" class="button"><span>Register Now!</span></button>
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
                        <td><input type="password" required name="password" placeholder="Password..." /></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" class="button"><span>Login</span></button>
                        </td>
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
        /*pfpImage.addEventListener("change", () => {
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
*/

        function preview_image(event) {
            var output = document.getElementById('output_image');
            output.setAttribute("alt", "Loading...");
            var pfpImageFileSize = event.target.files.item(0).size;
            if (Math.round(pfpImageFileSize / 1024) >= 5120) {
                alert("Image file is too large, must be less than 5MB"); //Exit this and try again
                return;
            } else {
                //Image is of size
                var reader = new FileReader();
                reader.onload = function() {
                    output.src = reader.result;
                    output.setAttribute("alt", "Profile Picture");
                }
                reader.readAsDataURL(event.target.files[0]);
            }
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
    <img id="trippy_twisty_tabs" src="img/trippy_twisty_tabsCropped.png" />
    <img id="trash_girl" src="img/trash_girl.png" />
    <img id="moneybags_dad" src="img/moneybags_dad.png" />
</body>

</html>