<?php 
    require_once('../model/Payment.php');

    session_start();
    header('Content-Type: application/json');

    class PaymentController {
        function get_revenue(){
            $payment_model = new Payment();
            return $payment_model->get_revenue();
        }

        function get_flowers_most_revenue() {
            $payment_model = new Payment();
            return $payment_model->get_flowers_most_revenue();
        }

        function get_months_revenue() {
            $payment_model = new Payment();
            return $payment_model->get_months_revenue();
        }
    }

    $payment_controller = new PaymentController();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['type']) && $_GET['type'] === 'months') {
            $months_revenue = $payment_controller->get_months_revenue();
            response(0, 'Get Months Revenue', $months_revenue);
        } if (isset($_GET['type']) && $_GET['type'] === 'flowers') {
            $flowers = $payment_controller->get_flowers_most_revenue();
            response(0, 'Get Flowers Most Revenue', $flowers);
        } else {
            $revenue = $payment_controller->get_revenue();
            response(0, 'Get Revnue Successfully', $revenue);
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