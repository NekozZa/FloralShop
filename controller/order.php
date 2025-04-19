<?php
    include './database.php';
    include './mapbox.php';

    session_start();
    header('Content-Type: application/json');

    $raw = file_get_contents("php://input");
    $data = json_decode($raw, true);   

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['UserID'])) {
        if (isset($data['address']) && isset($data['totalAmount']) &&
            isset($data['paymentMethod']) && isset($data['shippingType'])) {

            $userAddressCoordinates = getAddressCoordinates($data['address']);

            createNewOrder($conn, $data['address'], $data['totalAmount'], $data['paymentMethod'], $data['shippingType']);
            $orderID = mysqli_insert_id($conn);
            $orderItems = getOrderItems($conn);
            addOrderItems($conn, $orderID, $orderItems, $userAddressCoordinates);

            echo json_encode([
                'message' => 'Successful',
                'coord' => $userAddressCoordinates 
            ]);
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

    function addOrderItems($conn, $orderID, $orderItems, $userAddressCoordinates) {
        while ($orderItem = mysqli_fetch_assoc($orderItems)) {
            $price = $orderItem['Price'];
            $quantity = $orderItem['Quantity'];
            $productID = $orderItem['ProductID'];
            $shopAddress = getShopAddressByProductID($conn, $productID); 

            $shopAddressCoordinates = getAddressCoordinates($shopAddress);
            $route = "$shopAddressCoordinates;$userAddressCoordinates";
            
            $sql = "
                INSERT INTO orderitem (OrderID, ProductID, Price, Quantity, Route)
                VALUES ($orderID, $productID, $price, $quantity, '$route')
            ";

            mysqli_query($conn, $sql);
        }
    }

    function getShopAddressByProductID($conn, $productID) {
        $sql = "
            SELECT Address
            FROM product
            INNER JOIN shop ON product.ShopID = shop.ShopID 
            WHERE ProductID = $productID 
        ";

        $res = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($res);

        return $data['Address'];
    }
?>