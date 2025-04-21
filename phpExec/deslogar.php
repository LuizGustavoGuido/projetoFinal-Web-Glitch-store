<?php
session_start();
session_destroy();
header("Location: ../site/home.php")
?>