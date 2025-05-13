<?php
session_start();
session_unset();
session_destroy();

if (strpos($_SERVER['HTTP_REFERER'], 'staff') !== false) {
    header("Location: login.php");
} else {
    header("Location: ../../index.php");
}
exit;
?>
