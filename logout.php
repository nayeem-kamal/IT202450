
<?php
include_once "flash.php";
session_start();
session_unset();
session_destroy();
require_once("nav.php");
flash("You have been logged out", "success");
die(header("Location: index.php"));
?>