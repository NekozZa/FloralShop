<?php
    include './database.php';
    $conn = connect();

    $sql = "
        SELECT *
        FROM refund_requests
        INNER JOIN `orders` ON `orders`.order_id = refund_requests.order_id
        INNER JOIN order_items ON order_items.order_id = refund_requests.order_id
        INNER JOIN customers ON customers.customer_id = refund_requests.customer_id
        WHERE refund_requests.status = 'pending'
    ";

    $result = mysqli_query($conn, $sql);

    $refunds = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $refunds[] = $row;
    }
?>

<div class="container mt-5">
    <h2 class="page-title text-center">
        <span class="pending">🛒 Pending Refunds</span> - <span class="verify">Verify Panel</span>
    </h2>
    <div class="text-right">
    <a href="views/partials/logout.php" class="btn btn-danger mb-3">Log Out</a>
    </div>

    <?php if (empty($refunds)): ?>
        <p class="text-center">No pending refunds to verify.</p>
    <?php else: ?>
        <?php foreach ($refunds as $refund): ?>
            <div class="refund-card p-4 mb-4 shadow-lg rounded">
                <div class="order-header d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold text-primary">Order #<?= $refund['order_id'] ?></span>
                    <button class="btn btn-success" onclick="verifyRefund(<?= $refund['refund_id'] ?>, this)">Verify</button>
                </div>
                <p><strong>Customer:</strong> <?= $refund['full_name'] ?></p>
                <p><strong>Refund Date:</strong> <?= $refund['request_date'] ?></p>
                <p><strong>Reason:</strong></p>
                <p><?= $refund['reason'] ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    function verifyRefund(refundID, element) {
        fetch('./controller/request_controller.php', {
            method: 'PUT',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({refund_id: refundID})
        })
        .then(response => response.json())
        .then(data => {
            if (data.code == 0) {
                const refundCard = element.closest('.refund-card');
                refundCard.remove();
            } else {
                alert('Error verifying order: ' + data.error);
            }
        })
        .catch(error => {
            alert('Request failed: ' + error);
        });
    }
</script>