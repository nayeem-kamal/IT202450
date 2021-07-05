<?php
include "header.php";
include "navbar.php";
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="customer_add_style.css">
</head>

<body>
    <form class="add_customer_form" action="customer_add_action.php" method="post">
        <div class="flex-container-form_header">
            <h1 id="form_header">Register</h1>
        </div>

        <div class="flex-container">
            <div class=container>
                <label>UserName :</label><br>
                <input name="uname" size="30" type="text" required />
            </div>

        </div>





        <div class="flex-container">
            <div class=container>
                <label>Email:</label><br>
                <input name="email" size="30" type="text" required />
            </div>
        </div>


        <div class="flex-container">
            <div class=container>
                <label>Password :</b></label><br>
                <input name="pwd" size="30" type="text" required />
            </div>
        </div>
        <div class="flex-container">
            <div class=container>
                <label>Confirm Password :</b></label><br>
                <input name="confpwd" size="30" type="text" required />
            </div>
        </div>


        <div class="flex-container">
            <div class="container">
                <button type="submit">Submit</button>
            </div>

            <div class="container">
                <button type="reset" class="reset" onclick="return confirmReset();">Reset</button>
            </div>
        </div>

    </form>

    <script>
        function confirmReset() {
            return confirm('Do you really want to reset?')
        }
    </script>

</body>

</html>