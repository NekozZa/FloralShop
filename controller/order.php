<?php include './database.php' ?>

<?php 
    session_start();
    header('Content-Type: application/json');

    $raw = file_get_contents("php://input");
    $data = json_decode($raw, true);   

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['UserID'])) {
        if (isset($data['address']) && isset($data['totalAmount']) &&
            isset($data['paymentMethod']) && isset($data['shippingType'])) {

            createNewOrder($conn, $data['address'], $data['totalAmount'], $data['paymentMethod'], $data['shippingType']);
            $orderID = mysqli_insert_id($conn);
            $orderItems = getOrderItems($conn);
            addOrderItems($conn, $orderID, $orderItems);
        }
    }
?>

<?php
    function createNewOrder($conn, $address, $totalAmount, $paymentMethod, $shippingType) {
        $userID = $_SESSION['UserID'];

        $sql = "
            INSERT INTO `order` (UserID, TotalAmount, Address, PaymentMethod, ShippingType)
            VALUES ($userID, $totalAmount, '$address', '$paymentMethod', '$shippingType' )
        ";

        mysqli_query($conn, $sql);
    }

    function getOrderItems($conn) {
        $userID = $_SESSION['UserID'];

        $sql = "
            SELECT cartitem.Quantity, cartitem.ProductID, product.Price
            FROM cart
            INNER JOIN cartitem ON cart.CartID = cartitem.CartID
            INNER JOIN product ON cartitem.ProductID = product.ProductID
            WHERE UserID = $userID
        ";

        return mysqli_query($conn, $sql);
    }

    function addOrderItems($conn, $orderID, $orderItems) {
        while ($orderItem = mysqli_fetch_assoc($orderItems)) {
            $price = $orderItem['Price'];
            $quantity = $orderItem['Quantity'];
            $productID = $orderItem['ProductID'];

            $sql = "
                INSERT INTO orderitem (OrderID, ProductID, Price, Quantity)
                VALUES ($orderID, $productID, $price, $quantity)
            ";

            mysqli_query($conn, $sql);
        }
    }
?>