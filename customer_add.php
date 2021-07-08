<?php
include_once "header.php";
include_once "nav.php";
if (isset($_POST["submit"])) {
    $email = se($_POST, "email", null, false);
    $password = trim(se($_POST, "password", null, false));
    $confirm = trim(se($_POST, "confirm", null, false));
    $username = trim(se($_POST, "username", null, false));

    $isValid = true;
    if (!isset($email) || !isset($password) || !isset($confirm) || !isset($username)) {
        flash("Must provide email, username, password, and confirm password", "warning");
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
        flash("Email must be formatted as email@email.com", "warning");
        $isValid = false;
    }

    if ($isValid) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");
        $hash = password_hash($password, PASSWORD_BCRYPT);
        try {
            $stmt->execute([":email" => $email, ":password" => $hash, ":username" => $username]);
            flash("You've successfully registered, please login");
            die(header("Location: index.php"));
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

<head>
    <link rel="stylesheet" href="customer_add_style.css">
</head>

<body>
    <div>

        <form method="POST" >
            <div class="flex-container-form_header">
                <h1 id="form_header">Register</h1>
            </div>
            <div class="flex-container">
                <div class=container>
                    <label for="email">Email: </label>
                    <input type="text" id="email" name="email" required />
                </div>
            </div>
            <div class="flex-container">
                <div class=container>
                    <label for="username">Username: </label>
                    <input type="text" id="username" name="username" required />
                </div>
            </div>
            <div class="flex-container">
                <div class=container>
                    <label for="pw">Password: </label>
                    <input type="password" id="pw" name="password" required />
                </div>
            </div>
            <div class="flex-container">
                <div class=container>
                    <label for="cpw">Confirm Password: </label>
                    <input type="password" id="cpw" name="confirm" required />
                </div>
            </div>
            <div class="flex-container">
                <div class=container>
                    <input type="submit" name="submit" value="Register" />
                </div>
            </div>

        </form>
    </div>
</body>

<?php
include_once("flash.php");
?>