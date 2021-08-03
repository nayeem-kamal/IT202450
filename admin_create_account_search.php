<?php
include_once "header.php";
include_once "nav.php";
include_once "functions.php";
include_once "flash.php";
if (!is_logged_in() && !is_admin()) {
    die(header("Location: index.php"));
    flash("Cannot access this page without logging in", "warning");
} else {

    $db = getDB();
    $query = "SELECT * FROM nhk6.users where concat(firstName,lastName) like :name ";

    $stmt = $db->prepare($query);
?>
    <form method="POST" style="margin: 100px;">

        <legend class="text-center header">Search for an account</legend>

        <div class="flex-container">
            <div class=container>
                <label for="accountdst">Name: </label>
                <input type="text" id="name" name="name" required />

            </div>
        </div>


        <div class="flex-container">
            <div class=container>
                <input type="submit" name="submit" value="Search" />
            </div>
        </div>


    </form>
    <?php



    //if we got here it was a success, let's exit



    if (isset($_POST["submit"])) {
        $search = "%" . $_POST["name"] . "%";
        try {
            $stmt->execute([":name" => $search]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Username</th>

                    </tr>
                </thead>
                <tbody>


                    <?php
                    foreach ($results as $result) { ?>
                        <tr>
                        <td><a href="./admin_create_account.php?id=<?php echo $result["id"]; ?>"><?php echo $result["username"];?></a></td>

                            <td><?php echo $result["firstName"] . " " . $result["lastName"] ?></td>
                            <td><?php echo $result["email"] ?></td>

                        </tr>

        <?php
                    }
                } catch (PDOException $e) {
                    flash("Search could not be completed", "danger");
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