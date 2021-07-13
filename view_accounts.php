<?php
include_once "header.php";
include_once "nav.php";
include_once "functions.php";
require_once("flash.php");
if (!is_logged_in()) {
    die(header("Location: index.php"));
    flash("Cannot access this page without logging in", "warning");
} else {
    $query = "SELECT * from Accounts where user_id = :uid LIMIT 5";
    $db = getDB();
    $stmt = $db->prepare($query);
    try {
        $stmt->execute([":uid" => get_user_id()]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$result) {
            flash("Error: We are unable to access your accounts at this time", "danger");
        } else {
?><h3>View Accounts</h3>
            table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Account</th>
                    <th scope="col">Type</th>
                    <th scope="col">Balance</th>
                </tr>
            </thead>
            <tbody>

                <?php
                foreach ($result as $acctinfo) {
                    $i = 1;
                ?>
                    <tr>
                        <th scope="row"><?php echo $acctinfo["account_number"] ?></th>
                        <td><?php echo $acctinfo["account_type"] ?></td>
                        <td>$<?php echo $acctinfo["balance"] ?></td>
                    </tr>
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <a href="./transaction_history.php?id=<?php echo $acctinfo["id"]; ?>&num=<?php echo $acctinfo["account_number"] ?>"> <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $i; ?>">
                                            <?php echo $acctinfo["account_type"] . " : " . $acctinfo["account_number"] . "        Balance:" .  $acctinfo["balance"]; ?>
                                        </button></a>
                                </h5>
                            </div>

                            <div id="collapse<?php echo $i; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    <?php echo $acctinfo["balance"]; ?> </div>
                            </div>
                        </div>

                    </div>

    <?php
                    $i += 1;
                }
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