<?php
session_start();

$dbservername = "group5-admin.cwcul3ylqcmq.ap-southeast-1.rds.amazonaws.com";
$dbusername = "admin";
$dbname = "UserAccounts";
$dbpassword = "ilovecookies696969";

$memberuser = $_SESSION['username'];
$memberID = $_SESSION['UserID'];
$newPassword = $_POST['newPassword'] ?? "";
$oldPassword = $_POST['oldPassword'] ?? "";

$newFirstname = $_POST['fname'] ?? "";
$newLastname = $_POST['lname'] ?? "";

$hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);

if (isset($_SESSION["username"])) {

    try {
        //Database connection
       $dbcon = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
       // set the PDO error mode to exception
       $dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       //Check if the password is match
       if ($oldPassword == $newPassword) {

        //SQL Update
        $statement = "UPDATE Members SET FNAME ='$newFirstname', LNAME = '$newLastname', PASSWORD ='$hashed_password' WHERE ID ='$memberID'";
        $dbcon->exec($statement);

        $_SESSION['StatusSuccess'] = "Information Change, Please Login Again";
        session_unset();
        session_destroy();
        header("location: ../Pages/login.php");

           } else {

            $_SESSION['StatusError'] = "Password not Match.";
            header("location: ../Pages/change-pass.php");

           }

       } catch(PDOException $e) {
       //Database Error
       echo "Connection failed: " . $e->getMessage();
     }
       //Close DB
       $dbcon = null;
 
} else {
    header("location: ../Pages/login.html");
}


?>