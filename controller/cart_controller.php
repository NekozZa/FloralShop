<?php 
    require_once('../model/Cart.php');

    session_start();
    header('Content-Type: application/json');

    class CartController {
        function get_cartlist($account_id){
            $cart_model = new Cart();
            return $cart_model->get_cartlist($account_id);
        }

        function add_to_cart($user_id, $flower_id, $quantity){
            $cart_model = new Cart();
            return $cart_model->add_to_cart($user_id, $flower_id,$quantity);
        }

        function remove_cart_item($cartitem_id, $account_id){
            $cart_model = new Cart();
            return $cart_model->remove_cart_item($cartitem_id, $account_id);
        }
    }

    $cart_controller = new CartController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_SESSION['account_id'])) {
            response(1, 'You must be logged in to add to wishlist');
        }

        $account_id = $_SESSION['account_id'];
        $flower_id = $_POST['flower_id'] ?? null;
        $quantity = 1;
        if ($flower_id && $account_id) {
            
            $result = $cart_controller->add_to_cart($account_id, $flower_id, $quantity);
            response(0, 'Added to cart', $result);
        }else{
            response(1, 'Failed in adding to cart', $result);
        }
    }   

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        $account_id = $_SESSION['account_id'];
        $cartlist = $cart_controller->get_cartlist($account_id);
        response(0, 'Fetched CartList', $cartlist);
    }

    if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['cartitem_id'])) {
            $account_id = $_SESSION['account_id'] ?? null;
            if(!$account_id){
                response(1, "User not logged in!");
            }

            $cartitem_id = $data['cartitem_id'];
            
            $success = $cart_controller->remove_cart_item($cartitem_id, $account_id);
            if ($success) {
                response(0, "Delete Successfully");
            } else {
                response(1, "Failure in Delete");
            }
        } else {
            response(1, "Missing cartitem_id");
        }
    }

    function response($code, $message, $data = null) {
        die(json_encode([
            'code' => $code,
            'message' => $message,
            'return' => $data
        ]));
    }
?>