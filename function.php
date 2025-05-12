<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isUserLoggedIn() {
    session_start();
    return isset($_SESSION['user_id']);
}
function connect() {
    $conn = mysqli_connect('localhost', 'root', '', 'floral_shop');
    if (!$conn) {
        die("Kết nối thất bại: " . mysqli_connect_error());
    }
    return $conn;
}

function sendVerificationEmail($email) {
    require 'PHPMailer/PHPMailerAutoload.php';
    
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;
    $mail->Username = 'your_email@gmail.com';
    $mail->Password = 'your_email_password'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('your_email@gmail.com', 'Floral Shop');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Xác nhận tài khoản';
    $mail->Body    = 'Cảm ơn bạn đã đăng ký tài khoản tại cửa hàng hoa của chúng tôi. Vui lòng nhấn vào link dưới đây để xác nhận tài khoản của bạn: <br><br><a href="http://yourwebsite.com/verify.php?email=' . urlencode($email) . '">Xác nhận tài khoản</a>';

    if(!$mail->send()) {
        echo 'Email không thể gửi. Lỗi: ' . $mail->ErrorInfo;
    } else {
        echo 'Email xác nhận đã được gửi!';
    }
}

function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function checkPassword($password, $hash) {
    return password_verify($password, $hash);
}

function getUserByUsernameOrEmail($usernameOrEmail) {
    $conn = connect();
    $sql = "SELECT * FROM accounts WHERE username = '$usernameOrEmail' OR email = '$usernameOrEmail'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $user;
}

function isLoggedIn() {
    session_start();
    return isset($_SESSION['user_id']);
}

function getCurrentUser() {
    session_start();
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        $conn = connect();
        $sql = "SELECT * FROM accounts WHERE account_id = '$userId'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);
        mysqli_close($conn);
        return $user;
    }
    return null;
}

function getCurrentUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];

    return $protocol . "://" . $host . $uri; 
}
?>
