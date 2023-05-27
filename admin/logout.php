<?php
session_start(); // start the session 

unset($_SESSION['admin_name']);
session_destroy($_SESSION['admin_name']);

unset($_SESSION['role']);
session_destroy($_SESSION['role']);

unset($_SESSION['admin_id']);
session_destroy($_SESSION['admin_id']);

header("location: index.php ");

exit();
