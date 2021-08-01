<?php
include_once "header.php";
include_once "nav.php";
include_once "functions.php";
require_once("flash.php");
if (!is_logged_in()) {
    die(header("Location: index.php"));
    flash("Cannot access this page without logging in","warning");
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
  
  <div class="col-sm">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Create Account</h5>
        <p class="card-text">Use this page to create a new Account at NJIT Bank</p>
        <a href="./add_account.php" class="btn btn-primary">Get Started Now</a>
      </div>
    </div>
  </div>
  <div class="col-sm">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">My Accounts</h5>
        <p class="card-text">Use this page to view your accounts</p>
        <a href="./view_accounts.php" class="btn btn-primary">View Accounts</a>
      </div>
    </div>
  </div>
  <div class="col-sm">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Deposit</h5>
        <p class="card-text">Use this page to make a deposit</p>
        <a href="./deposit.php" class="btn btn-primary">Make a Deposit</a>
      </div>
    </div>
  </div>
  <div class="col-sm">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Transfer/Withdraw</h5>
        <p class="card-text">Use this page to withdraw or transfer money from your account</p>
        <a href="#" class="btn btn-primary">Make a Transfer/Withdrawal</a>
      </div>
    </div>
  </div>
  <div class="col-sm">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Transfer</h5>
        <p class="card-text">Use this page to transfer money between your account</p>
        <a href="./transfer.php" class="btn btn-primary">Make a Transfer</a>
      </div>
    </div>
  </div>
  <div class="col-sm">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">My Profile</h5>
        <p class="card-text">Use this page to view your profile and change your password</p>
        <a href="./profile.php" class="btn btn-primary">View Profile</a>
      </div>
    </div>

    
    <div class="col-sm">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">My Profile</h5>
        <p class="card-text">Use this page to view your profile and change your password</p>
        <a href="./userhistory.php" class="btn btn-primary">View Profile</a>
      </div>
    </div>
    </div>
    
    <div class="col-sm">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Loan application</h5>
        <p class="card-text">Use this page to take out a loan</p>
        <a href="./add_loan.php" class="btn btn-primary">Get a Loan</a>
      </div>
    </div>
    </div>

  </div>

  <div class="col-sm">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">My Profile</h5>
        <p class="card-text">Use this page to view your profile and change your password</p>
        <a href="./userhistory.php" class="btn btn-primary">View Profile</a>
      </div>
    </div>
  </div>
    
    <div class="col-sm">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Loan application</h5>
        <p class="card-text">Use this page to take out a loan</p>
        <a href="./add_loan.php" class="btn btn-primary">Get a Loan</a>
      </div>
    </div>
    </div>
  
  <!-- deposit withdraw/transfer profile -->
</div>
</body>