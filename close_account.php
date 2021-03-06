<?php
include_once "header.php";
include_once "nav.php";
include_once "functions.php";
include_once "flash.php";
if (!is_logged_in()) {
    die(header("Location: index.php"));
    flash("Cannot access this page without logging in", "warning");
} else {

    $db = getDB();
    $query = "SELECT * from Accounts where user_id = :uid and balance = 0 and closed = 0 and freeze = 0";

    $created = false;
    $stmt = $db->prepare($query);
    $user_id = get_user_id();
?>
    <form method="POST" style="margin: 100px;">

        <legend class="text-center header">Choose an Account to Close</legend>
        <h4>Accounts must be empty before closing. Loan accounts must be fully paid off in order to close. </h4>
        <div class="flex-container">
            <div class=container>
                <label for="accountdst">Account: </label>
                <input list="Accountdst" id="accountdst" name="accountdst" required />
                <datalist id="Accountdst">
                    <?php
                    while (!$created) {
                        try {
                            $stmt->execute([":uid" => $user_id]);
                            $accountnumbers =  $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                            <?php
                            foreach ($accountnumbers as $acct) {
                            ?> <option value="<?php echo $acct["account_number"]; ?>" label="<?php echo $acct["account_type"]; ?>">
                                <?php
                            }
                                ?>
                </datalist>
            </div>
        </div>
               
                <div class="flex-container">
                <div class=container>
                    <input type="submit" name="submit" value="Close Account" />
                </div>
            </div>


    </form>
<?php



                            //if we got here it was a success, let's exit

                            $created = true;
                        } catch (PDOException $e) {

                            flash("Error: We are unable to create or access your account at this time" . $e, "danger");
                        }

                    }
                    if (isset($_POST["submit"])) {
                        $destination = $_POST["accountdst"];
                        
                        if(close_account($destination)){
                            flash("Your account has been closed successfully", "success");
                            die(header("Location: ./view_accounts.php"));


                    }
                    else{
                        flash("Your account closure did not complete","danger");
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