<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit; // Đảm bảo không tiếp tục thực thi sau khi chuyển hướng
    }

    // Check role and redirect accordingly
    if ($_SESSION['role'] == 'customer') {
        header('Location: index.php');
        exit;
    } elseif ($_SESSION['role'] == 'staff') {
        header('Location: staff.php');
        exit;
    } elseif ($_SESSION['role'] == 'admin') {
        header('Location: admin.php');
        exit;
    }
?>
