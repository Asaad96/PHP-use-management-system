<?php
session_start();

// Delete all data 
session_unset();
session_destroy();

header("Location:  login.php?logged_out=1");
exit;
