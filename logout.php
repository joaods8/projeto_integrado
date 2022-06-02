<?php
session_start();

session_destroy(); 
session_unset(); 

echo "<script>top.location.href='index.php';</script>";
?>