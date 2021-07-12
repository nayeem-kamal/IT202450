<?php
include_once "header.php";
include_once "nav.php";
include_once "functions.php";
require_once("flash.php");
if (!is_logged_in()) {
    die(header("Location: index.php"));
    flash("Cannot access this page without logging in", "warning");
}else{
    $query = "SELECT * from Accounts where user_id = :uid LIMIT 5";
        $db = getDB();
        $stmt = $db->prepare($query);
        try {
            $stmt->execute([":uid" => get_user_id()]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$result) {
                flash("Error: We are unable to access your accounts at this time", "danger");
            }else{
                foreach($result as $acctinfo){
                    ?>
                    <h4><?php echo $acctinfo["account_number"];?> </h4>
                    <?php
                }
            }

        }catch (PDOException $e) {
            flash("Error: We are unable to access your accounts at this time", "danger");
        }
}
?>



<body>


</body>