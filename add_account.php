<?php
include_once "header.php";
include_once "nav.php";
include_once "functions.php";
require_once("flash.php");
if (!is_logged_in()) {
    die(header("Location: index.php"));
    flash("Cannot access this page without logging in", "warning");
}

if (isset($_POST["submit"])) {
    $type = se($_POST, "accountType", null, false);
    $created = false;
    $query = "INSERT INTO Accounts (account_number, user_id, account_type) VALUES (:an, :uid, :at)";
    $stmt = $db->prepare($query);
    $user_id = get_user_id();
    $account_number = "";
    
        while (!$created) {
        try {
            $account_number = get_random_str(12);
            $stmt->execute([":an" => $account_number, ":uid" => $user_id, ":at" => $type]);
            $created = true; //if we got here it was a success, let's exit
            flash("Your account has been created successfully", "success");
        } catch (PDOException $e) {
            $code = se($e->errorInfo, 0, "00000", false);
            if (
                $code !== "23000"
            ) {
                flash("Error: We are unable to create or access your account at this time", "danger");
            
        }
            }
        }
    }





?>

<head>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="customer_add_style.css">
</head>


<body>
    <div>

        <form method="POST">
            <div class="flex-container-form_header">
                <h1 id="form_header">Create an account</h1>
            </div>
            <div class="flex-container">
                <div class=container>
                    <label for="email">Account Type: </label>
                    <input list="AccountType" id="accountType" name="accountType" required />
                    <datalist id="AccountType">
                        <option value="Checking">
                        <option value="Savings">
                        
                    </datalist>
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