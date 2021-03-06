<?php
include_once "header.php";
include_once "nav.php";
include_once "functions.php";
require_once("flash.php");
if (!is_logged_in()) {
    die(header("Location: index.php"));
    flash("Cannot access this page without logging in", "warning");
} else {
?>
<div class="row justify-content-center">
                    <h3>Transaction History for <?php echo get_username(); ?></h3>

                </div>
    <form method="POST" style="margin: 100px;">
        <div class="flex-container">
            <div class=container>
                <label for="accountdst">Transfer Type: </label>
                <!-- <input id="transferType" name="transferType"  /> -->
                <select id="transferType" name="transferType">
                     <option value="all">All</option>

                    <option value="deposit">Deposit </option>
                    <option value="withdraw">Withdraw</option>
                    <option value="transfer">Transfer</option>


                </select>
            
            </div>
        </div>


        <div class="flex-container">
            <div class=container>
                <label for="start">Start date:</label>

                <input type="date" id="start" name="start" value="2018-07-22" min="2018-01-01" max="2022-12-31">

            </div>
        </div>

        <div class="flex-container">
            <div class=container>
                <label for="end">End date:</label>

                <input type="date" id="end" name="end" value="2021-09-22" min="2018-01-01" max="2022-12-31">

            </div>
        </div>

        <div class="flex-container">
            <div class=container>
                <input type="submit" name="submit" value="Filter" />
            </div>
        </div>

    </form>

    <?php
    $uid = get_user_id();
    $filter = " ";
    if (isset($_POST["submit"])) {
        $transferType= $_POST["transferType"];
        $start= $_POST["start"];
        $end= $_POST["end"];

        if (isset($transferType) && $transferType != "all"){

            $filter = $filter . " and transactionType = \"" . $transferType . "\"";
        }
        if (isset($start) && isset($end)){
            $filter = $filter . " and date(created) between \"" . $start . "\" and \"" . $end . "\"";
        }



    }
    $filter = $filter . ";";

    $query = "SELECT * from transactions where accountsrc in (select id from Accounts where user_id = :uid)" . $filter;
    $db = getDB();
    $stmt = $db->prepare($query);
    try {
        $stmt->execute([":uid" => $uid]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$result) {
            flash("No results at this time", "danger");
        } else {


    ?><div class="container">
                
            </div>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Source Account</th>
                        <th scope="col">Destination Account</th>
                        <th scope="col">Date</th>

                        <th scope="col">Type</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Destination Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($result as $transaction) {
                        $i = 1;
                        $datetime = date_create($transaction["created"]);
                        $date = date_format($datetime, "Y/m/d");
                    ?>
                        <tr>
                            <th scope="row"><?php echo get_acct_info($transaction["accountdst"])["account_number"]; ?></th>
                            <th scope="row"><?php echo get_acct_info($transaction["accountsrc"])["account_number"]; ?></th>
                            <th scope="row"><?php echo $date; ?></th>

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
        flash("Error: We are unable to access your accounts at this time" . $e, "danger");
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