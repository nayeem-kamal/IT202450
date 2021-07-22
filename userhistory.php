<?php
include_once "header.php";
include_once "nav.php";
include_once "functions.php";
require_once("flash.php");
if (!is_logged_in()) {
    die(header("Location: index.php"));
    flash("Cannot access this page without logging in", "warning");
} else {
    $uid=get_user_id();

    $query = "SELECT * from transactions where accountsrc in (select id from Accounts where user_id = :uid);";
    $db = getDB();
    $stmt = $db->prepare($query);
    try {
        $stmt->execute([":uid" => $uid]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$result) {
            flash("Error: We are unable to access your accounts at this time", "danger");
        } else {
            ?>

<form method="POST" style="margin: 100px;">
<legend class="text-center header">Choose a Transfer Type</legend>
<div class="flex-container">
            <div class=container>
                <label for="accountdst">Type: </label>
                <input list="Accountdst" id="accountdst" name="accountdst" required />
                <datalist id="Accountdst">
                    <option value="deposit" label="Deposit"></option>
                    <option value="withdraw" label="Withdraw"></option>
                    <option value="transfer" label="Transfer"></option>

                       
                </datalist>
            </div>
</div>

</form>

<?php

?><div class="container">
                <div class="row justify-content-center">
                    <h3>Transaction History for <?php echo get_username(); ?></h3>
                    
                </div>
            </div>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Source Account</th>
                        <th scope="col">Destination Account</th>

                        <th scope="col">Type</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Destination Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($result as $transaction) {
                        $i = 1;
                    ?>
                        <tr>
                            <th scope="row"><?php echo get_acct_info($transaction["accountdst"])["account_number"]; ?></th>
                            <th scope="row"><?php echo get_acct_info($transaction["accountsrc"])["account_number"]; ?></th>

                            <td><?php echo $transaction["transactionType"] ?></td>
                            <td>$<?php echo $transaction["balanceChange"] ?></td>
                            <td>$<?php echo $transaction["expectedTotal"] ?></td>
                        </tr>


                    <?php
                        $i += 1;
                    }

                    ?>
                </tbody>
            </table>
<?php
        }
    } catch (PDOException $e) {
        flash("Error: We are unable to access your accounts at this time", "danger");
    }
}
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>

<body>



</body>