<?php
include "header.php";
include "navbar.php";
if (isset($_POST["submit"])) {
?>
<h2>submitted</h2>
<?php

    $email = se($_POST, "email", null, false);
    $password = trim(se($_POST, "password", null, false));
    $confirm = trim(se($_POST, "confirm", null, false));
    $username = trim(se($_POST, "username", null, false));

    $isValid = true;
    if (!isset($email) || !isset($password) || !isset($confirm) || !isset($username)) {
        flash("Must provide email, username, password, and confirm password","warning");
        $isValid = false;
    }
    if ($password !== $confirm) {
        flash("Passwords don't match", "warning");
        $isValid = false;
    }
    if (strlen($password) < 3) {
        flash("Password must be 3 or more characters", "warning");
        $isValid = false;
    }
    $email = sanitize_email($email);
    if (!is_valid_email($email)) {
        flash("Invalid email", "warning");
        $isValid = false;
    }
    else{
        echo $email;
    }
    //TODO add validation for username (length? disallow special chars? etc)
    if ($isValid) {
        //do our registration
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Users (email, username, password) VALUES (:email, :username, :password)");
        $hash = password_hash($password, PASSWORD_BCRYPT);
        try {
            $stmt->execute([":email" => $email, ":password" => $hash, ":username"=>$username]);
            flash("You've successfully registered, please login");
            die(header("Location: login.php"));
        } catch (PDOException $e) {
            $code = se($e->errorInfo, 0, "00000", false);
            if ($code === "23000") {
                flash("An account with this email already exists", "danger");
            } else {
                echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="customer_add_style.css">
</head>

<body>
    <form class="add_customer_form" method="post">
        <div class="flex-container-form_header">
            <h1 id="form_header">Register</h1>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>UserName :</label><br>
                <input name="username" size="30" type="text" required />
            </div>

        </div>





        <div class="flex-container">
            <div class=container>
                <label>Email:</label><br>
                <input name="email" size="30" type="text" required />
            </div>
        </div>


        <div class="flex-container">
            <div class=container>
                <label>Password :</b></label><br>
                <input name="password" size="30" type="password" required />
            </div>
        </div>
        <div class="flex-container">
            <div class=container>
                <label>Confirm Password :</b></label><br>
                <input name="confirm" size="30" type="password" required />
            </div>
        </div>


        <div class="flex-container">
            <div class="container">
                <button type="submit">Submit</button>
            </div>

            
        </div>

    </form>

    <script>
        
    function validate(form) {
        console.log("validating");
        let email = form.email.value;
        let username = form.username.value;
        let password = form.password.value;
        let confirm = form.confirm.value;
        let isValid = true;
        if (email) {
            email = email.trim();
        }
        if(username)    {
            username = username.trim();
        }
        if (password) {
            password = password.trim();
        }
        if (confirm) {
            confirm = confirm.trim();
        }
        if(!username || username.length === 0)    {
            isValid    =    false;
            alert("Must provide a username");
        }
        if (email.indexOf("@") === -1) {
            isValid = false;
            alert("Invalid email");
        }
        if (password !== confirm) {
            isValid = false;
            alert("Passwords don't match");
        }
        if (password.length < 3) {
            isValid = false;
            alert("Password must be 3 or more characters");
        }
        console.log(isValid);
        return isValid;
    }
</script>

</body>

</html>