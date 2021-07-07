<?php

//Note: this is to resolve cookie issues with port numbers
$domain = $_SERVER["HTTP_HOST"];
if (strpos($domain, ":")) {
    $domain = explode(":", $domain)[0];
}
session_set_cookie_params([
    "lifetime" => 60 * 60,
    "path" => "",
    //"domain" => $_SERVER["HTTP_HOST"] || "localhost",
    "domain" => $domain,
    "secure" => true,
    "httponly" => true,
    "samesite" => "lax"
]);
session_start();
require_once("functions.php");

?>
<!-- CSS only -->
<link rel="stylesheet" href="navbar_style.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light"> -->



        <!-- <?php if (is_logged_in()) : ?>
                <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
            <?php endif; ?> -->
        <?php if (!is_logged_in()) : ?>
           
            <div class="nav-wrapper">
                <div class="topnav" id="theTopNav">
                    <a href="./index.php">Login</a>

                </div>
            </div>

            <!-- </div>                <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li> -->
        <?php endif; ?>
        <!-- <?php if (has_role("Admin")) : ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Admin
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="add_item.php">Add Item</a></li>
                    <li><a class="dropdown-item" href="add_score.php">Add Score</a></li>
                    <li><a class="dropdown-item" href="view_user_accounts.php">View Accounts</a></li>
                </ul>
            </li>
        <?php endif; ?> -->
        <?php if (is_logged_in()) : ?>
            <div class="nav-wrapper">
                <div class="topnav" id="theTopNav">
                    <a href="./profile.php">Profile</a>

                </div>
            </div>
            <div class="nav-wrapper">
                <div class="topnav" id="theTopNav">
                    <a href="./logout.php">Logout</a>

                </div>
            </div>        <?php endif; ?>

<!-- </nav> -->