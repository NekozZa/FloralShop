<?php include '../../database.php' ?>
<?php
session_start();

$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '../../index.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = connect();

    $sql = "
        SELECT * 
        FROM accounts
        WHERE username = ?
    ";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['account_id'] = $user['account_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        
        if (isset($_GET['redirect'])) {
            header('Location: ' . urldecode($_GET['redirect']));
        } else {
            if ($user['role'] == 'customer') {
                $sql = "
                    SELECT * 
                    FROM customers
                    WHERE account_id = ?
                ";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $user['account_id']);
                $stmt->execute();
                $res = $stmt->get_result();
                $data = $res->fetch_assoc();
                $customer_id = $data['customer_id'];

                $_SESSION['customer_id'] = $customer_id;

                header('Location: ../../index.php');
            } elseif ($user['role'] == 'admin') {
                header('Location: ../../admin.php');
            } elseif ($user['role'] == 'staff') {
                header('Location: ../../staff.php');
            }
        }
        exit;
    } else {
        $error_message = "Invalid username or password.";
    }

    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../css/acc.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Tên đăng nhập" required><br>
            <input type="password" name="password" placeholder="Mật khẩu" required><br>
    <button type="submit">Đăng nhập</button>
        </form>

        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="message">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
    </div>
</body>
</html>

