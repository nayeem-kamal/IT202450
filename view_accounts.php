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
            foreach ($result as $acctinfo) {
?>
                <h4><?php echo $acctinfo["account_number"]; ?> </h4>
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <?php echo $acctinfo["account_number"]; ?>
                                </button>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                            <?php echo $acctinfo["balance"]; ?>                            </div>
                        </div>
                    </div>

                </div>
<?php
            }
        }
    } catch (PDOException $e) {
        flash("Error: We are unable to access your accounts at this time", "danger");
    }
}
?>

<head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>


</body>