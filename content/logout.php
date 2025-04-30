<?php
session_start(); //Resumes session to be able to clear it.
$_SESSION = []; //Clears the session variables.
session_destroy(); //Ends the session completely.

header("Location: login.php"); //Redirects the user to login page after logging out.
exit;   
?>