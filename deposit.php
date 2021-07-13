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
    $query = "SELECT account_number from Accounts where user_id = :uid LIMIT 5";

    $created = false;
    $stmt = $db->prepare($query);
    $user_id = get_user_id();
?>
    <form method="POST" style="margin: 100px;">

        <legend class="text-center header">Choose an Account to deposit into</legend>

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
                            ?> <option value="<?php echo $acct["account_number"]; ?>">
                                <?php
                            }
                                ?>
                </datalist>
            </div>
        </div>
                <legend class="text-center header">Choose an Amount to Deposit</legend>

                <div class="flex-container">
                    <div class=container>
                        <label for="amount">Amount ($): </label>
                        <input type="number" value="100" min="0" step="10" id="amount" name="amount" data-number-to-fixed="2" data-number-stepfactor="100"  />
                    </div>
                </div>

                <div class="flex-container">
                <div class=container>
                    <input type="submit" name="submit" value="Create Account" />
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
                        $destid=get_acct_info($user_id)["id"];
                        $destination = $_POST["accountdst"];
                        $amount = $_POST["amount"];
                        if(transaction(1,$destid,$amount,"deposit")){
                            flash("Your deposit has been created successfully", "success");


                    }
                    else{
                        flash("Your deposit did not complete","danger");
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