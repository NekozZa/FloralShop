<?php
    require_once '../model/Order.php';
    session_start();
    header('Content-Type: application/json');

    class OrderController {
        public function place_order($account_id,$cart_items,$total_amount){
            $order_model = new Order();
            return $order_model->create_order($account_id,$cart_items,$total_amount);
        }
    }

    $cart_controller = new OrderController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_SESSION['account_id'])) {
            response(1, 'You must be logged in to place an order');
        }
        $account_id = $_SESSION['account_id'];
        $cart_items = $_POST['cart_items'] ?? null;
        $total_amount = $_POST['total_amount'] ?? null;

        if($cart_items === null || $total_amount === null){
            response(1, 'Cart is empty');
        }
        $result = $order_controller->place_order($account_id, $cart_items, $total_amount);
        if($result){
            response(0, 'Order placed successfully', $result);
        } else {
            response(1, 'Failed to place order');
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