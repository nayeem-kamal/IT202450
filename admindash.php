<?php
include_once "header.php";
include_once "nav.php";
include_once "functions.php";
require_once("flash.php");
if (!is_logged_in() && !is_admin()) {
  die(header("Location: index.php"));
  flash("Cannot access this page without logging in", "warning");
}
?>

<head>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>


  <div class="row">

    <div class="col-sm-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Search Account</h5>
          <p class="card-text">Use this page to Search Accounts at NJIT Bank</p>
          <a href="./add_account.php" class="btn btn-primary">Search</a>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Search Users</h5>
            <p class="card-text">Use this page to search for users</p>
            <a href="./close_account.php" class="btn btn-primary">Search</a>
          </div>
        </div>
      </div>
    <div class="col-sm-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Freeze Accounts</h5>
          <p class="card-text">Use this page to freeze accounts</p>
          <a href="./view_accounts.php" class="btn btn-primary">Freeze accounts</a>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Disable users</h5>
          <p class="card-text">Use this page to Disable users</p>
          <a href="./deposit.php" class="btn btn-primary">Disable</a>
        </div>
      </div>
    </div>


    </div>

   



    <!-- deposit withdraw/transfer profile -->
  </div>
</body>