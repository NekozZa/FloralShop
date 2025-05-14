<?php 
    require_once('../model/Order.php');

    session_start();
    header('Content-Type: application/json');

    class OrderController {
        function get_orders($customer_id){
            $oder_model = new Order();
            return $oder_model->get_orders($customer_id);
        }
    }

    $order_controller = new OrderController();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $orders = $order_controller->get_orders($_GET['customer_id']);
        response(0, 'Get Orders Successfully', $orders);
    }

    function response($code, $message, $data = null) {
        die(json_encode([
            'code' => $code,
            'message' => $message,
            'return' => $data
        ]));
    }
?>