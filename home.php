<?php
require_once("nav.php");
if (!is_logged_in()) {
    die(header("Location: login.php"));
}
?>
<h1>Home</h1>
<h5>Welcome, <?php se(get_username()); ?>!</h5>
<?php
require_once("flash.php");
?>