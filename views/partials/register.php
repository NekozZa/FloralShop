<?php
    include '../../database.php';
    session_start();

    $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '../../index.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $full_name = $_POST['full_name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $conn = connect();

        $check_user_query = "SELECT * FROM accounts WHERE username = ?";
        $stmt = $conn->prepare($check_user_query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Tên đăng nhập đã tồn tại!";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $role = 'customer';
            $created_at = date('Y-m-d H:i:s');

            $insert_query = "INSERT INTO accounts (username, password_hash, email, role, created_at)
                            VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param('sssss', $username, $password_hash, $email, $role, $created_at);

            if ($stmt->execute()) {
                $account_id = $stmt->insert_id;

                $insert_customer_query = "INSERT INTO customers (account_id, full_name, phone, address)
                                        VALUES (?, ?, ?, ?)";
                $stmt_customer = $conn->prepare($insert_customer_query);
                $stmt_customer->bind_param('isss', $account_id, $full_name, $phone, $address);

                if ($stmt_customer->execute()) {
                    $_SESSION['user_id'] = $account_id;
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $role;

                    header("Location: " . urldecode($redirect));
                    exit();
                } else {
                    $error_message = "Lỗi khi lưu thông tin khách hàng.";
                }
                $stmt_customer->close();
            } else {
                $error_message = "Lỗi khi tạo tài khoản.";
            }
        }

        $stmt->close();
        $conn->close();
    }
    ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="../../css/acc.css">
</head>
<body>
    <div class="container">
        <h2>Đăng ký tài khoản</h2>
        <form method="POST" action="register.php<?php echo isset($_GET['redirect']) ? '?redirect=' . urlencode($_GET['redirect']) : ''; ?>">
            <input type="text" name="username" placeholder="Tên đăng nhập" required><br>
            <input type="password" name="password" placeholder="Mật khẩu" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="text" name="full_name" placeholder="Họ và tên" required><br>
            <input type="text" name="phone" placeholder="Số điện thoại" required><br>
            <input type="text" name="address" placeholder="Địa chỉ" required><br>
            <button type="submit">Đăng ký</button>
        </form>

        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="message">
            Đã có tài khoản? 
            <a href="login.php<?php echo isset($_GET['redirect']) ? '?redirect=' . urlencode($_GET['redirect']) : ''; ?>">
                Đăng nhập tại đây
            </a>
        </div>
    </div>
</body>
</html>
