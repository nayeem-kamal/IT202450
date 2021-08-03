<?php

$domain = $_SERVER["HTTP_HOST"];
if (strpos($domain, ":")) {
    $domain = explode(":", $domain)[0];
}
session_set_cookie_params([
    "lifetime" => 60 * 60,
    "path" => "",
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


<div class="nav-wrapper">
    <div class="topnav" id="theTopNav">

        <?php if (!is_logged_in()) : ?>

            <div class="nav-wrapper">
                <div class="topnav" id="theTopNav">
                    <a href="./index.php">Login</a>

                </div>
            </div>

        <?php endif; ?>
        <!-- <?php if (is_admin()) : ?>
         <a href="./admindash.php">Admin</a>


        <?php endif; ?> -->
        <?php if (is_logged_in()) : ?>

            <a href="./profile.php">Profile</a>
            <a href="./logout.php">Logout</a>
            <a href="./dashboard.php">Dashboard</a>


    </div>
</div>

</div> <?php endif; ?>

<!-- </nav> -->