<?php

if (isset($_POST["submit"])) {
    $email = se($_POST, "email", null, false);
    $password = trim(se($_POST, "password", null, false));
    $confirm = trim(se($_POST, "confirm", null, false));
    $username = trim(se($_POST, "username", null, false));

    $isValid = true;

 ?>
 <h1>success</h1>
 <?php
   
}
?>

   

<div>
    <h1>Register</h1>
    <form method="POST" onsubmit="return validate(this);">
        <div>
            <label for="email">Email: </label>
            <input type="email" id="email" name="email" required />
        </div>
        <div>
            <label for="username">Username: </label>
            <input type="text" id="username" name="username" required />
        </div>
        <div>
            <label for="pw">Password: </label>
            <input type="password" id="pw" name="password" required />
        </div>
        <div>
            <label for="cpw">Confirm Password: </label>
            <input type="password" id="cpw" name="confirm" required />
        </div>
        <div>
            <input type="submit" name="submit" value="Register" />
        </div>
    </form>
</div>
<script>
    function validate(form) {
        let email = form.email.value;
        let username = form.username.value;
        let password = form.password.value;
        let confirm = form.confirm.value;
        let isValid = true;
        if (email) {
            email = email.trim();
        }
        if(username)    {
            username = username.trim();
        }
        if (password) {
            password = password.trim();
        }
        if (confirm) {
            confirm = confirm.trim();
        }
        if(!username || username.length === 0)    {
            isValid    =    false;
            alert("Must provide a username");
        }
        if (email.indexOf("@") === -1) {
            isValid = false;
            alert("Invalid email");
        }
        if (password !== confirm) {
            isValid = false;
            alert("Passwords don't match");
        }
        if (password.length < 3) {
            isValid = false;
            alert("Password must be 3 or more characters");
        }
        return isValid;
    }
</script>