<?php
include_once "header.php";
include_once "nav.php";
include_once "functions.php";
include_once "flash.php";
if (!is_logged_in()) {
    die(header("Location: index.php"));
    flash("Cannot access this page without logging in", "warning");
} else {

    $db = getDB();
    $id = $_GET["id"];
    $name = $_GET["name"];
 
?>
    <form method="POST" style="margin: 100px;">

        <legend class="text-center header">Confirm Deactivating User: <?php echo $name; ?></legend>
        
               
                <div class="flex-container">
                <div class=container>
                    <input type="submit" name="submit" value="Deactivate Account" />
                </div>
            </div>


    </form>
<?php



                            //if we got here it was a success, let's exit

             

                    
                    if (isset($_POST["submit"])) {
                        
                        if(deactivate_user($id)){
                            flash("Your user has been deactivated successfully", "success");
                            die(header("Location: ./admindash.php"));


                    }
                    else{
                        flash("Your account deactivation did not complete","danger");
                        die(header("Location: ./admindash.php"));

                    }
                }
            }

?>

<head>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="customer_add_style.css">
</head>