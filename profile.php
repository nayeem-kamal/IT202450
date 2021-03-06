<?php
require_once("header.php");
require_once("nav.php");

if (!is_logged_in()) {
    die(header("Location: index.php"));
}
?>
<?php
if (isset($_POST["save"])) {
    $email = se($_POST, "email", null, false);
    $username = se($_POST, "username", null, false);
    $firstName = $_POST["firstName"];

    $lastName = $_POST["lastName"];
    if($_POST["visibility"] == "Public"){
        $public = 1;
    }else{
        $public = 0;
        
    }
    $_SESSION["user"]["firstName"] = $firstName;
    $_SESSION["user"]["lastName"] = $lastName;


    $params = ["fname" => $firstName, "lname" => $lastName, ":email" => $email, ":username" => $username, ":id" => get_user_id(), ":public" => $public];
    $db = getDB();
    $stmt = $db->prepare("UPDATE users set firstName = :fname, lastName = :lname, email = :email, username = :username, Public = :public where id = :id");
    try {
        $stmt->execute($params);
    } catch (Exception $e) {
        if ($e->errorInfo[1] === 1062) {
            //https://www.php.net/manual/en/function.preg-match.php
            preg_match("/users.(\w+)/", $e->errorInfo[2], $matches);
            if (isset($matches[1])) {
                flash("The chosen " . $matches[1] . " is not available.", "warning");
            } else {
                //TODO come up with a nice error message
                echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
            }
        } else {
            //TODO come up with a nice error message
            echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
        }
    }
    $stmt = $db->prepare("SELECT id, email, IFNULL(username, email) as `username` from users where id = :id LIMIT 1");
    try {
        $stmt->execute([":id" => get_user_id()]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $_SESSION["user"]["email"] = $user["email"];
            $_SESSION["user"]["username"] = $user["username"];
        } else {
            flash("User Could Not Be Found", "danger");
        }
    } catch (Exception $e) {
        flash("An unexpected error occurred, please try again", "danger");
        //echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
    }


    $current_password = se($_POST, "currentPassword", null, false);
    $new_password = se($_POST, "newPassword", null, false);
    $confirm_password = se($_POST, "confirmPassword", null, false);
    if (isset($current_password) && isset($new_password) && isset($confirm_password)) {
        if ($new_password === $confirm_password) {
            //TODO validate current
            $stmt = $db->prepare("SELECT password from users where id = :id");
            try {
                $stmt->execute([":id" => get_user_id()]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if (isset($result["password"])) {
                    if (password_verify($current_password, $result["password"])) {
                        $query = "UPDATE users set password = :password where id = :id";
                        $stmt = $db->prepare($query);
                        $stmt->execute([
                            ":id" => get_user_id(),
                            ":password" => password_hash($new_password, PASSWORD_BCRYPT)
                        ]);

                        flash("Password reset", "success");
                    } else {
                        flash("Current password is invalid", "warning");
                    }
                }
            } catch (Exception $e) {
                echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
            }
        } else {
            flash("New passwords don't match", "warning");
        }
    }
}
?>

<?php
$email = get_user_email();
$username = get_username();
$fname = fname();
$lname = lname();
?>

<head>
    <link rel="stylesheet" href="customer_add_style.css">
</head>
<form method="POST" onsubmit="return validate(this);">
    <div class="flex-container-form_header">
        <h1 id="form_header">Profile Page</h1>
    </div>
    <div class="flex-container">
        <div class=container>
            <label for="email">First Name</label>
            <input type="text" name="firstName" id="firstName" value="<?php se($fname); ?>" />
        </div>
    </div>
    <div class="flex-container">
        <div class=container>
            <label for="email">Last Name</label>
            <input type="text" name="lastName" id="lastName" value="<?php se($lname); ?>" />
        </div>
    </div>
    <div class="flex-container">
        <div class=container>
            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="<?php se($email); ?>" />
        </div>
    </div>
    <div class="flex-container">
        <div class=container>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php se($username); ?>" />
        </div>
    </div>
    <div class="flex-container">
        <div class=container>
        <label for="Profile Visibility">Profile Visibility</label>

            <select list="visibility" id="visibility" name="visibility"  >
                    <option value="Public" selected>Public</option>
                    <option value="Private">Private</option>

            </select>
            
        </div>
    </div>
    <div class="flex-container">
        <div class=container>
            <h2>Password Reset</h2>
        </div>
    </div>
    <div class="flex-container">
        <div class=container>
            <label for="cp">Current Password</label>
            <input type="password" name="currentPassword" id="cp" />
        </div>
    </div>
    <div class="flex-container">
        <div class=container>
            <label for="np">New Password</label>
            <input type="password" name="newPassword" id="np" />
        </div>
    </div>
    <div class="flex-container">
        <div class=container>
            <label for="conp">Confirm Password</label>
            <input type="password" name="confirmPassword" id="conp" />
        </div>

    </div>
    <div class="flex-container">
        <div class=container>
            <input type="submit" value="Update Profile" name="save" />
        </div>
    </div>
</form>

<script>
    function validate(form) {
        let pw = form.newPassword.value;
        let con = form.confirmPassword.value;
        let isValid = true;
        //TODO add other client side validation....

        //example of using flash via javascript
        //find the flash container, create a new element, appendChild
        if (pw !== con) {
            //find the container
            let flash = document.getElementById("flash");
            //create a div (or whatever wrapper we want)
            let outerDiv = document.createElement("div");
            outerDiv.className = "row justify-content-center";
            let innerDiv = document.createElement("div");

            //apply the CSS (these are bootstrap classes which we'll learn later)
            innerDiv.className = "alert alert-warning";
            //set the content
            innerDiv.innerText = "New Password and Confirm password must match";

            outerDiv.appendChild(innerDiv);
            //add the element to the DOM (if we don't it merely exists in memory)
            flash.appendChild(outerDiv);
            isValid = false;
        }
        return isValid;
    }
</script>
<?php
require_once("flash.php");
?>