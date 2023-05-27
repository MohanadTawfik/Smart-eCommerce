<?php
session_start(); // start the session 

unset($_SESSION['user_name']);
session_destroy($_SESSION['user_name']);

unset($_SESSION['ID']);
session_destroy($_SESSION['ID']);

unset($_SESSION['userCart']);
session_destroy($_SESSION['userCart']);

header("location: index.php ");

exit();
