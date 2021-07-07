<?php
include "header.php";
include "nav.php";
include_once "functions.php";
if (isset($_POST["submit"])) {
    $email = se($_POST, "email", null, false);
    $password = trim(se($_POST, "password", null, false));

    $isValid = true;
    if (!isset($email) || !isset($password)) {
        flash("Must provide email and password", "warning");
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
    if ($isValid) {
        //do our registration
        $db = getDB();
        //$stmt = $db->prepare("INSERT INTO Users (email, password) VALUES (:email, :password)");
        //$hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $db->prepare("SELECT id, email, IFNULL(username, email) as `username`, password from users where email = :email or username = :email LIMIT 1");
        try {
            $stmt->execute([":email" => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                $upass = $user["password"];
                if (password_verify($password, $upass)) {
                    flash("Login successful", "success");
                    unset($user["password"]);
                    //save user info
                    $_SESSION["user"] = $user;
                    //lookup roles assigned to this user
                    // $stmt = $db->prepare("SELECT Roles.name FROM Roles 
                    // JOIN UserRoles on Roles.id = UserRoles.role_id 
                    // where UserRoles.user_id = :user_id and Roles.is_active = 1 and UserRoles.is_active = 1");
                    // $stmt->execute([":user_id" => $user["id"]]);
                    // $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    // //save roles or empty array
                    // if ($roles) {
                    //     $_SESSION["user"]["roles"] = $roles;
                    // } else {
                    //     $_SESSION["user"]["roles"] = [];
                    // }
                    //echo "<pre>" . var_export($_SESSION, true) . "</pre>";

                    //fetch account info, or create an account if the user existed before this feature was added
                    //in my project, a user will have only 1 account associated with them so it's a 1:1 relationship
                    get_or_create_account();//applies directly to the session, make sure it's called after the session is set
                    die(header("Location: header.php"));
                } else {
                    se("Passwords don't match");
                }
            } else {
                se("User doesn't exist");
            }
        } catch (Exception $e) {
            echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="home_style.css">
</head>

<body>
    <!--  -->

        <div class="flex-container">
            <div class="flex-item-1">
                <form method="POST" onsubmit="return validate(this);">
                    <div class="flex-item-login">
                        <h2>Welcome</h2>
                    </div>

                    <div class="flex-item">
                        <input type="text" name="email" id="email" placeholder="Enter your Email" required>
                    </div>

                    <div class="flex-item">
                        <input type="password" name="password" id="pw" placeholder="Enter your Password" required>
                    </div>

                    <div class="flex-item">
                        <button type="submit" name="submit">Login</button>
                    </div>
                    <div class="flex-item">
                        <!-- <a href="./customer_add.php">New Users Click Here To Register</a> -->
                        <a href="./customer_add.php">New Users Click Here To Register</a>

                </form>
            </div>
        </div>

    </div>

</body>
</html>

<script>
    function validate(form) {
        let email = form.email.value;
        let password = form.password.value;
        let isValid = true;
        if (email) {
            email = email.trim();
        }
        if (password) {
            password = password.trim();
        }
        if (email.indexOf("@") === -1) {
            isValid = false;
            alert("Invalid email");
        }
        if (password.length < 3) {
            isValid = false;
            alert("Password must be 3 or more characters");
        }
        return isValid;
    }
</script>
<?php
require_once("flash.php");
?>