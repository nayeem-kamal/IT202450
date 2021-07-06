<?php

$ini = @parse_ini_file(".env");
if($ini && isset($ini["DB_URL"])){
    //load local .env file
    $db_url = parse_url($ini["DB_URL"]);
}
else{
    //load from heroku env variables
    $db_url      = parse_url(getenv("DB_URL"));
}
$dbhost   = "db.ethereallab.app";
$dbuser = "nhk6";
$dbpass = "r5fQzsyOzYsN";
$dbdatabase       = "nhk6";
?>
