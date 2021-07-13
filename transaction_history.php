<?php
include_once "header.php";
include_once "nav.php";
include_once "functions.php";
require_once("flash.php");
if (!is_logged_in()) {
    die(header("Location: index.php"));
    flash("Cannot access this page without logging in", "warning");
} else {
    $id = $_GET["id"];
    $acct = $_GET["num"];

    $acctinfo = get_acct_info($id);
    $query = "SELECT * from transactions where accountsrc = :acc LIMIT 10";
    $db = getDB();
    $stmt = $db->prepare($query);
    try {
        $stmt->execute([":acc" => $id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$result) {
            flash("Error: We are unable to access your accounts at this time", "danger");
        } else {
?><h3>Transaction History for <?php echo $acct ?></h3>
            <h4>Account Type: <?php echo $acctinfo["account_type"] ?> Balance: <?php echo $acctinfo["balance"] ?> Created: <?php echo $acctinfo["created"] ?> </h4>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Account</th>
                        <th scope="col">Type</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($result as $transaction) {
                        $i = 1;
                    ?>
                        <tr>
                            <th scope="row"><?php echo $transaction["accountdst"] ?></th>
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