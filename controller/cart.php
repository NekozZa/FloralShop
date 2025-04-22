<?php include './database.php' ?>

<?php 
    session_start();
    header('Content-Type: application/json');

    $raw = file_get_contents("php://input");
    $data = json_decode($raw, true);   
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && 
        isset($data['productID']) &&
        isset($data['quantity'])) {

        $productID = $data['productID'];
        $quantity = $data['quantity'];
        $userID = $_SESSION['UserID'];

        $sql = "SELECT CartID FROM cart WHERE UserID = $userID";
        $res = mysqli_query($conn, $sql);
        $action = 'Insert';

        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $cartID = $row['CartID'];

            $sql = "
                SELECT Quantity FROM cartitem
                WHERE ProductID=$productID and CartID=$cartID
            ";

            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res) > 0) {
                updateCartItem($conn, $cartID, $productID, $quantity);
                $action = 'Update';

            } else {
                addNewCartItem($conn, $cartID, $productID, $quantity);
            }
        } else {
            createCart($conn, $userID);
            $cartID = getCart($conn, $userID);
            addNewCartItem($conn, $cartID, $productID, $quantity);
        }

        $response = [
            'action' => $action
        ];

        echo json_encode($response);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($data['productID']) && isset($data['offset'])) {
        $productID = $data['productID'];
        $offset = $data['offset'];
        $cartID = getCart($conn, $_SESSION['UserID']);
        updateCartItem($conn, $cartID, $productID, $offset);
        echo json_encode(['message' => 'Successful']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $cartID = getCart($conn, $_SESSION['UserID']);
        $message = '';
        $info = '';

        if (isset($data['productID'])) {
            deleteCartItem($conn, $cartID, $data['productID']);
            $info = 'Delete cartitem with id: ' . $data['productID'];
            $message = 'Successful';
        } else {
            deleteCartItems($conn, $cartID);
            $info = 'Delete all cartitems';
            $message = 'Successful';
        }
        
        echo json_encode([
            'message' => $message,
            'id' => $cartID
        ]);
    }
?>

<?php 
    function createCart($conn, $userID) {
        $sql = "
            INSERT INTO cart (UserID)
            VALUES ($userID)
        ";

        mysqli_query($conn, $sql);
    }

    function getCart($conn, $userID) {
        $sql = "
            SELECT CartID FROM cart WHERE UserID=$userID
        ";

        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
        return $row['CartID'];
    }

    function addNewCartItem($conn, $cartID, $productID, $quantity) {
        $sql = "
            INSERT INTO cartitem (CartID, ProductID, Quantity)
            VALUES ($cartID, $productID, $quantity)
        ";

        mysqli_query($conn, $sql);
    }

    function updateCartItem($conn, $cartID, $productID, $offset) {
        $sql = "
            UPDATE cartitem
            SET Quantity = Quantity + $offset
            WHERE ProductID=$productID and CartID=$cartID
        ";

        mysqli_query($conn, $sql);
    }

    function deleteCartItem($conn, $cartID, $productID) {
        $sql= "
            DELETE FROM cartitem
            WHERE ProductID=$productID and CartID=$cartID
        ";

        mysqli_query($conn, $sql);
    }

    function deleteCartItems($conn, $cartID) {
        $sql= "
            DELETE FROM cartitem
            WHERE CartID=$cartID
        ";

        mysqli_query($conn, $sql);
    }
    
?>