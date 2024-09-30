<?php
include('config.php');
$ID= $_GET['id'];
mysqli_query($connect_database, "DELETE  FROM addcard WHERE id=$ID");
header('location:card.php');
?>