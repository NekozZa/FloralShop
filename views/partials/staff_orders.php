<?php 
    include './database.php';
    $conn = connect();

    if (!isset($_SESSION['username'])) {
        header("Location: ../../view/account/login.php"); 
        exit();
    }

    $sql = "
        SELECT 
            o.order_id,
            o.order_date,
            o.status,
            c.customer_id AS cus_id,
            c.full_name AS customer_name,
            f.name AS flower_name,
            oi.quantity
        FROM orders o
        JOIN order_items oi ON o.order_id = oi.order_id
        JOIN flowers f ON oi.flower_id = f.flower_id
        JOIN customers c ON o.customer_id = c.customer_id
        WHERE o.status = 'pending'
        ORDER BY o.order_id DESC, oi.order_item_id ASC
    ";

    $result = mysqli_query($conn, $sql);

    $orders = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['order_id'];
        if (!isset($orders[$id])) {
            $orders[$id] = [
                'order_id' => $id,
                'date' => $row['order_date'],
                'customer' => $row['customer_name'],
                'products' => []
            ];
        }
        $orders[$id]['products'][] = [
            'name' => $row['flower_name'],
            'quantity' => $row['quantity']
        ];
    }
?>

<div class="container mt-5">
    <h2 class="page-title text-center">
        <span class="pending">🛒 Pending Orders</span> - <span class="verify">Verify Panel</span>
    </h2>
    <div class="text-right">
    <a href="views/partials/logout.php" class="btn btn-danger mb-3">Log Out</a>
    </div>

    <?php if (empty($orders)): ?>
        <p class="text-center">No pending orders to verify.</p>
    <?php else: ?>
        <?php foreach ($orders as $order): ?>
            <div class="order-card p-4 mb-4 shadow-lg rounded">
                <div class="order-header d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold text-primary">Order #<?= $order['order_id'] ?></span>
                    <button class="btn btn-success" onclick="verifyOrder(<?= $order['order_id'] ?>, this)">Verify</button>
                </div>
                <p><strong>Customer:</strong> <?= htmlspecialchars($order['customer']) ?></p>
                <p><strong>Ordered Date:</strong> <?= $order['date'] ?></p>
                <p><strong>Products:</strong></p>
                <ul class="product-list pl-3">
                    <?php foreach ($order['products'] as $product): ?>
                        <li><?= htmlspecialchars($product['name']) ?> - Quantity: <?= $product['quantity'] ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    function verifyOrder(orderId, element) {
        fetch('verify_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'order_id=' + orderId
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const orderCard = element.closest('.order-card');
                orderCard.remove();
            } else {
                alert('Error verifying order: ' + data.error);
            }
        })
        .catch(error => {
            alert('Request failed: ' + error);
        });
    }
</script>