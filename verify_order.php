<?php
include './database.php';
$conn = connect();

// Kiểm tra nếu có dữ liệu POST gửi đến
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);

    // Cập nhật status = 'completed' cho đơn hàng
    $sql = "UPDATE orders SET status = 'completed' WHERE order_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $order_id);
    $success = mysqli_stmt_execute($stmt);

    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Unable to update order.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request.']);
}
?>
