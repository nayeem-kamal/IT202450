<?php
include_once "header.php";
include_once "nav.php";
include_once "functions.php";
include_once "flash.php";
if (!is_logged_in()) {
    die(header("Location: index.php"));
    flash("Cannot access this page without logging in", "warning");
} else {
?>

    <body>
        <div>

            <form method="POST" style="margin: 100px;">
                <!-- <div class="flex-container-form_header">
                <h1 id="form_header">Create an account</h1>
            </div> -->
                <!-- <h1 id="form_header" >Create an Account</h1> -->
                <legend class="text-center header">Take out a Loan</legend>
                <div class="flex-container">
                    <div class=container>
                        <label for="accountdst">Account: </label>
                        <input list="Accountdst" id="accountdst" name="accountdst" required />
                        <datalist id="Accountdst">
                            <?php
                            $db = getDB();
                            $user_id = get_user_id();
                            $query2 = "SELECT * from Accounts where user_id = :uid";
                            $stmt = $db->prepare($query2);
                            $created = false;
                            ?>
                        <?php


                        if (isset($_POST["submit"])) {

                            $type = "Loan";
                            $balance = $_POST["balance"];
                            $query = "INSERT INTO Accounts (account_number, user_id, account_type,apy) VALUES (:an, :uid, :at,:apy)";
                            $stmt = $db->prepare($query);
                            $account_number = "";
                            while (!$created) {
                                try {
                                    $apy = get_loan_apy();

                                    $account_number = get_random_str(12);
                                    $stmt->execute([":an" => $account_number, ":uid" => $user_id, ":at" => $type, ":apy" => $apy]);
                                    $lastID = $db->lastInsertID();
                                    //if we got here it was a success, let's exit
                                    flash("Your account has been created successfully", "success");
                                    if (transaction(1, $lastID, intval($balance), "Loan", " ")) {

                                        $created = true;
                                        die(header("Location: view_accounts.php"));
                                    } else {
                                        flash("Error: We are unable to fund your account at this time", "danger");
                                        die(header("Location: dashboard.php"));

                                        $created = true;
                                    }
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
                    }

                        ?>

                        <head>
                            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
                            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
                            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
                            <link rel="stylesheet" href="customer_add_style.css">
                        </head>

                        <?php
                        while (!$created) {
                            try {
                                $stmt->execute([":uid" => $user_id]);
                                $accountnumbers =  $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($accountnumbers as $acct) {
                        ?> <option value="<?php echo $acct["id"]; ?>" label="<?php echo $acct["account_number"]; ?>">
                                    <?php
                                }
                                    ?>
                        </datalist>
                    </div>
                </div>
        <?php



                                //if we got here it was a success, let's exit

                                $created = true;
                            } catch (PDOException $e) {

                                flash("Error: We are unable to create or access your account at this time" . $e, "danger");
                            }
                        }
        ?>

        <div class="flex-container">
            <div class=container>
                <label for="email">Loan Balance: </label>
                <input type="number" value="100" min="500" step="10" id="balance" name="balance" data-number-to-fixed="2" data-number-stepfactor="100" />

            </div>
        </div>

        <div class="flex-container">
            <div class=container>
                <input type="submit" name="submit" value="Create Account" />
            </div>
        </div>

            </form>
        </div>
    </body>