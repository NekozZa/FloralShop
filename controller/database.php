<?php 
    $db_server = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'online_market';
    $conn = '';

    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

    function fetch_assoc_all($response) {
        $items = [];
        while ($item = mysqli_fetch_assoc($response)) { $items[] = $item; }
        return $items;
    }
    //Interact with category
    function getCategories($conn) {
        $sql = "
            SELECT category.Name, category.CategoryID, COUNT(ProductID) as ProductCount
            FROM category
            INNER JOIN product ON product.CategoryID = category.CategoryID
            GROUP BY category.Name, category.CategoryID
        ";

        $res = mysqli_query($conn, $sql);
        return fetch_assoc_all($res);
    }
    
    //Interact with cart
    function getCartItems($conn) {
        $userID = $_SESSION['UserID'];

        $sql = "
            SELECT 
                product.ProductID,
                product.Name, 
                product.Price, 
                cartItem.Quantity, 
                product.Price * cartItem.quantity as 'Total'
            FROM account
            INNER JOIN cart ON account.UserID = cart.UserID
            INNER JOIN cartitem ON cart.CartID = cartitem.CartID
            INNER JOIN product ON product.ProductID = cartitem.ProductID
            WHERE account.UserID = $userID
        ";

        $res = mysqli_query($conn, $sql);
        return fetch_assoc_all($res);
    }

    function getCartCount($conn) {
        $userID = $_SESSION['UserID'];

        $sql = "
            SELECT COUNT(cartitem.CartItemID) as ItemCount
            FROM account
            INNER JOIN cart ON account.UserID = cart.UserID
            INNER JOIN cartitem ON cart.CartID = cartitem.CartID
            WHERE account.UserID = $userID
        ";

        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
        return $row['ItemCount'];
    }

    //Interact with order
    function getOrderItems($conn) {
        $userID = $_SESSION['UserID'];

        $sql = "
            SELECT 
                order.OrderID,
                order.Status,
                product.ProductID,
                product.Name as ProductName,
                product.Price,
                orderitem.OrderItemID,
                orderitem.Quantity,
                orderitem.Price as Total,
                shop.Name as ShopName
            FROM account
            INNER JOIN `order` ON account.UserID = `order`.UserID
            INNER JOIN orderitem ON `order`.OrderID = orderitem.OrderID
            INNER JOIN product ON orderitem.ProductID = product.ProductID
            INNER JOIN shop ON product.ShopID = shop.ShopID
            WHERE account.UserID = $userID
        ";

        $res = mysqli_query($conn, $sql);
        return fetch_assoc_all($res);
    }

    function getOrderCount($conn) {
        $userID = $_SESSION['UserID'];

        $sql = "
            SELECT COUNT(OrderItemID) as OrderCount
            FROM `order`
            INNER JOIN orderitem ON order.OrderID = orderitem.OrderID
            WHERE order.UserID = $userID
        ";

        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
        return $row['OrderCount'];
    }

    // Interact with products
    include 'database_product.php';
?>