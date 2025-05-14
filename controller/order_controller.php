<?php 
    require_once('../model/Order.php');

    session_start();
    header('Content-Type: application/json');

    class OrderController {
        function get_orders($customer_id) {
            $oder_model = new Order();
            return $oder_model->get_orders($customer_id);
        }

        public function place_order($account_id,$cart_items,$total_amount,$payment_method){
            $order_model = new Order();
            return $order_model->create_order($account_id,$cart_items,$total_amount,$payment_method);
        }
    }

    $order_controller = new OrderController();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $orders = $order_controller->get_orders($_GET['customer_id']);
        response(0, 'Get Orders Successfully', $orders);
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_SESSION['account_id'])) {
            response(1, 'You must be logged in to place an order');
        }
        $input = json_decode(file_get_contents('php://input',true));
        $account_id = $_SESSION['account_id'];
        $cart_items = $input->cart_items ?? null;
        $total_amount = $input->total_amount ?? null;
        $payment_method = $input->payment_method ?? null;
        
        if($cart_items === null || $total_amount === null){
            response(1, 'Cart is empty');
        }
        $result = $order_controller->place_order($account_id, $cart_items, $total_amount,$payment_method);
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