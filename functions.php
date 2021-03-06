<?php
require_once("db.php");
$BASE_PATH = '';//This is going to be a helper for redirecting to our base project path since it's nested in another folder
function se($v, $k = null, $default = "", $isEcho = true) {
    if (is_array($v) && isset($k) && isset($v[$k])) {
        $returnValue = $v[$k];
    } else if (is_object($v) && isset($k) && isset($v->$k)) {
        $returnValue = $v->$k;
    } else {
        $returnValue = $v;
    }
    if (!isset($returnValue)) {
        $returnValue = $default;
    }
    if ($isEcho) {
        //https://www.php.net/manual/en/function.htmlspecialchars.php
        echo htmlspecialchars($returnValue, ENT_QUOTES);
    } else {
        //https://www.php.net/manual/en/function.htmlspecialchars.php
        return htmlspecialchars($returnValue, ENT_QUOTES);
    }
}
function sanitize_email($email = "") {
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}
function is_valid_email($email = "") {
    return filter_var(trim($email), FILTER_VALIDATE_EMAIL);
}
//User Helpers
function is_logged_in() {
    return isset($_SESSION["user"]); 
}
function has_role($role) {
    if (is_logged_in() && isset($_SESSION["user"]["roles"])) {
        foreach ($_SESSION["user"]["roles"] as $r) {
            if ($r["name"] === $role) {
                return true;
            }
        }
    }
    return false;
}
function is_admin() {
    if (is_logged_in() && isset($_SESSION["user"]["admin"])) {
        if($_SESSION["user"]["admin"]){
            return true;
        }
        }
    
    return false;
}
function is_deactive() {
    if (is_logged_in() && isset($_SESSION["user"]["deactivated"])) {
        if($_SESSION["user"]["deactivated"]){
            return true;
        }
        }
    
    return false;
}
function get_username() {
    if (is_logged_in()) { 
        return se($_SESSION["user"], "username", "", false);
    }
    return "";
}
function get_user_email() {
    if (is_logged_in()) { //we need to check for login first because "user" key may not exist
        return se($_SESSION["user"], "email", "", false);
    }
    return "";
}

function fname() {
    if (is_logged_in()) { //we need to check for login first because "user" key may not exist
        return $_SESSION["user"]["firstName"];
    }
    return "";
}
function lname() {
    if (is_logged_in()) { //we need to check for login first because "user" key may not exist
        return $_SESSION["user"]["lastName"];
    }
    return "";
}
function get_user_id() {
    if (is_logged_in()) { //we need to check for login first because "user" key may not exist
        return se($_SESSION["user"], "id", false, false);
    }
    return false;
}
//flash message system
function flash($msg = "", $color = "info") {
    $message = ["text" => $msg, "color" => $color];
    if (isset($_SESSION['flash'])) {
        array_push($_SESSION['flash'], $message);
    } else {
        $_SESSION['flash'] = array();
        array_push($_SESSION['flash'], $message);
    }
}

function getMessages() {
    if (isset($_SESSION['flash'])) {
        $flashes = $_SESSION['flash'];
        $_SESSION['flash'] = array();
        return $flashes;
    }
    return array();
}
//end flash message system
/**
 * Generates a unique string based on required length.
 * The length given will determine the likelihood of duplicates
 */
function get_random_str($length) {
    //https://stackoverflow.com/a/13733588
    //$bytes = random_bytes($length / 2);
    //return bin2hex($bytes);

    //https://stackoverflow.com/a/40974772
    return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 36)), 0, $length);
}
/**
 * Will fetch the account of the logged in user, or create a new one if it doesn't exist yet.
 * Exists here so it may be called on any desired page and not just login
 * Will populate/refresh $_SESSION["user"]["account"] regardless.
 * Make sure this is called after the session has been set
 */
function get_or_create_account() {
    if (is_logged_in()) {
        //let's define our data structure first
        //id is for internal references, account_number is user facing info, and balance will be a cached value of activity
        $account = ["id" => -1, "account_number" => false, "balance" => 0];
        //this should always be 0 or 1, but being safe
        $query = "SELECT id, account_number, balance from Accounts where user_id = :uid LIMIT 1";
        $db = getDB();
        $stmt = $db->prepare($query);
        try {
            $stmt->execute([":uid" => get_user_id()]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                //account doesn't exist, create it
                $created = false;
                //we're going to loop here in the off chance that there's a duplicate
                //it shouldn't be too likely to occur with a length of 12, but it's still worth handling such a scenario

                //you only need to prepare once
                $at="Checking";
                $query = "INSERT INTO Accounts (account_number, user_id) VALUES (:an, :uid)";
                $stmt = $db->prepare($query);
                $user_id = get_user_id(); //caching a reference
                $account_number = "";
                while (!$created) {
                    try {
                        $account_number = get_random_str(12);
                        $stmt->execute([":an" => $account_number, ":uid" => $user_id]);
                        $created = true; //if we got here it was a success, let's exit
                        $lastID = $db->lastInsertID();

                        if(transaction(1,$lastID,5,"transfer"," ")){
                        flash("Welcome! Your account has been created successfully", "success");
                        }else{
                            flash("Welcome! Your account was created but not funded","success");
                        }
                    } catch (PDOException $e) {
                        $code = se($e->errorInfo, 0, "00000", false);
                        //if it's a duplicate error, just let the loop happen
                        //otherwise throw the error since it's likely something looping won't resolve
                        //and we don't want to get stuck here forever
                        if (
                            $code !== "23000"
                        ) {
                            throw $e;
                        }
                    }
                }
                //loop exited, let's assign the new values
                $account["id"] = $db->lastInsertId();
                $account["account_number"] = $account_number;
            } else {
                //$account = $result; //just copy it over
                $account["id"] = $result["id"];
                $account["account_number"] = $result["account_number"];
                $account["balance"] = $result["balance"];
            }
        } catch (PDOException $e) {
            flash("Error: We are unable to create or access your account at this time", "danger");
        }
        $_SESSION["user"]["account"] = $account; //storing the account info as a key under the user session
        //Note: if there's an error it'll initialize to the "empty" definition around line 84

    } else {
        flash("You're not logged in", "danger");
    }
}
function get_account_balance() {
    if (is_logged_in() && isset($_SESSION["user"]["account"])) {
        return se($_SESSION["user"]["account"], "balance", 0, false);
    }
    return 0;
}


function transaction($src, $dst, $amt, $type,$memo){
    if (isset($src) && isset($dst)){
        $db = getDB();
        $query = "INSERT INTO transactions (accountsrc, accountdst, balanceChange, transactionType, expectedTotal, memo) VALUES (:src, :dst, :amt, :typ, :tot, :memo)";
        $stmt = $db->prepare($query);
        $srcinfo = get_acct_info($src);
        $dstinfo = get_acct_info($dst);
        if($srcinfo["balance"]>$amt || $srcinfo["id"] == 1){
            if($type == "Loan Payment"){
                $srcbal = $srcinfo["balance"]-$amt;
                $dstbal = $dstinfo["balance"]-$amt;
                $amt2 = $amt-($amt*2);
            }else{
        $srcbal = $srcinfo["balance"]-$amt;
        $dstbal = $dstinfo["balance"]+$amt;
        $amt2 = $amt-($amt*2);
            }
    }else{
        flash("Source account does not have sufficient funds","dange");
        return false;
    }

        try{
            $stmt->execute([":src" => $src, ":dst" => $dst, ":amt" => strval($amt2), ":typ" => $type, ":tot" => $srcbal, ":memo" => $memo]);
        }catch (PDOException $e) {
            error_log($e);
            flash("Error: Transaction could not be completed at this time", "danger");
            return false;
        }
        $query = "INSERT INTO transactions (accountsrc, accountdst, balanceChange, transactionType, expectedTotal, memo) VALUES (:src, :dst, :amt, :typ, :tot, :memo )";
        $stmt = $db->prepare($query);
        try{
            $stmt->execute([":src" => $dst, ":dst" => $src, ":amt" => strval($amt), ":typ" => $type, ":tot" => $dstbal, ":memo" => $memo]);

        }catch (PDOException $e) {
            flash("Error: Transaction could not be completed at this time", "danger");
            return false;
        }
        
        $query2="UPDATE Accounts SET balance = :srcbal where id = :src";
        $stmt = $db->prepare($query2);
        //update src
        try{
            $stmt->execute([":src" => $src, ":srcbal" => $srcbal]);
            
        }catch (PDOException $e) {
            flash("Error: Transaction could not be completed at this time", "danger");
            return false;
        }
        //update dst
        $query2="UPDATE Accounts SET balance = :srcbal where id = :dst";
        $stmt = $db->prepare($query2);
        try{
            $stmt->execute([":dst" => $dst, ":srcbal" => $dstbal]);
            
        }catch (PDOException $e) {
            flash("Error: Transaction could not be completed at this time", "danger");
            return false;
        }

        return true;
    }
}
// UPDATE `nhk6`.`Accounts`
// SET
// `id` = <{id: }>,
// `account_number` = <{account_number: }>,
// `user_id` = <{user_id: }>,
// `balance` = <{balance: 0}>,
// `account_type` = <{account_type: }>,
// `created` = <{created: CURRENT_TIMESTAMP}>,
// `modified` = <{modified: }>
// WHERE `id` = <{expr}>;

function get_acct_info($acctnum){
    if(isset($acctnum)){

    $query = "SELECT * from Accounts where id = :acct LIMIT 1";
    $db = getDB();
    $stmt = $db->prepare($query);
    try {
        $stmt->execute([":acct" => $acctnum]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }catch(PDOException $e){
        flash("failed to get acct info", "warning");
        return false;
    }
    
}
return false;
}

function get_acct_id($acctnum){
    if(isset($acctnum)){

    $query = "SELECT id from Accounts where account_number = :acct LIMIT 1";
    $db = getDB();
    $stmt = $db->prepare($query);
    try {
        $stmt->execute([":acct" => $acctnum]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }catch(PDOException $e){
        flash("failed to get acct info", "warning");
        return false;
    }
    
}
return false;
}

function get_savings_apy(){
   

    $query = "SELECT value from sysprop where property = \"savingsAPY\"";
    $db = getDB();
    $stmt = $db->prepare($query);
    try {
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["value"];
    }catch(PDOException $e){
        flash("failed to get acct info", "warning");
        return false;
    }
    

return false;
}

function get_loan_apy(){
   

    $query = "SELECT value from sysprop where property = \"loanAPY\"";
    $db = getDB();
    $stmt = $db->prepare($query);
    try {
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["value"];
    }catch(PDOException $e){
        flash("failed to get acct info", "warning");
        return false;
    }
    

return false;
}

function close_account($acctno){

 $query = "UPDATE Accounts SET closed = 1 WHERE account_number = :acct";
    $db = getDB();
    $stmt = $db->prepare($query);
    try {
        $stmt->execute([":acct" => $acctno]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return true;
    }catch(PDOException $e){
        flash("Account couldn't be closed at this time", "warning");
        die(header("Location: ./dashboard.php"));
        return false;
    }
    

return false;

}

function freeze_account($acctno){

    $query = "UPDATE Accounts SET freeze = 1 WHERE account_number = :acct";
       $db = getDB();
       $stmt = $db->prepare($query);
       try {
           $stmt->execute([":acct" => $acctno]);
           $result = $stmt->fetch(PDO::FETCH_ASSOC);
           return true;
       }catch(PDOException $e){
           flash("Account couldn't be frozen at this time", "warning");
           die(header("Location: ./dashboard.php"));
           return false;
       }
       
   
   return false;
   
   }

   function deactivate_user($id){

    $query = "UPDATE users SET deactivated = 1 WHERE id = :id";
       $db = getDB();
       $stmt = $db->prepare($query);
       try {
           $stmt->execute([":id" => $id]);
           $result = $stmt->fetch(PDO::FETCH_ASSOC);
           return true;
       }catch(PDOException $e){
           flash("Account couldn't be frozen at this time", "warning");
           die(header("Location: ./dashboard.php"));
           return false;
       }
       
   
   return false;
   
   }