<?php  

session_start();

unset($_SESSION['nameCustomer']);
unset($_SESSION['statusCustomer']);

header('location: ../index.php');

?>