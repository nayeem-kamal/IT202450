<?php
require_once("nav.php");
if (!is_logged_in()) {
    //die(header("Location: index.php"));
    ?>
        <h1><?php echo "<pre>" . var_export($_SESSION, true) . "</pre>";
?></h1>
    <?php
}else{
?>
<h1>Home</h1>
<h5>Welcome, <?php se(get_username()); ?>!</h5>
<?php
}
require_once("flash.php");
?>