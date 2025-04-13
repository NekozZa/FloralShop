<?php include './database.php' ?>

<?php 
    session_start();
    header('Content-Type: application/json');

    $raw = file_get_contents("php://input");
    $data = json_decode($raw, true);   
    
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($data['productID'])) {
        $productID = $data['productID'];
        $userID = $_SESSION['UserID'];

        $sql = "SELECT CartID FROM cart WHERE UserID = $userID";
        $res = mysqli_query($conn, $sql);
        $action = 'Insert';

        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $cartID = $row['CartID'];

            $sql = "
                SELECT Quantity FROM cartitem
                WHERE ProductID=$productID
            ";

            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res) > 0) {
                updateCartItem($conn, $cartID, $productID, 1);
                $action = 'Update';

            } else {
                addNewCartItem($conn, $cartID, $productID);
            }
        } else {
            createCart($conn, $userID);
            $cartID = getCart($conn, $userID);
            addNewCartItem($conn, $cartID, $productID);
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
        echo json_encode(['message' => 'Test']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($data['productID'])) {
        $productID = $data['productID'];
        $cartID = getCart($conn, $_SESSION['UserID']);
        deleteCartItem($conn, $cartID, $productID);
        echo json_encode(['message' => 'Successful']);
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
        $sql = "SELECT CartID FROM cart WHERE UserID=$userID";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
        return $row['CartID'];
    }

    function addNewCartItem($conn, $cartID, $productID) {
        $sql = "
            INSERT INTO cartitem (CartID, ProductID, Quantity)
            VALUES ($cartID, $productID, 1)
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
?>