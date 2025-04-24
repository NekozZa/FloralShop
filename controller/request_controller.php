<?php 
    require_once('../model/Request.php');

    session_start();
    header('Content-Type: application/json');

    class RequestController {
        
        function create_refund_request($orderID, $customerID, $reason) {
            $request_model = new Request();
            return $request_model->create_refund_request($orderID, $customerID, $reason);
        } 
    }

    $request_controller = new RequestController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($_POST['reason'])) {
            response(1, 'Empty Reason');
        }

        $success = $request_controller->create_refund_request(
            $_POST['orderID'], 
            1, 
            $_POST['reason']
        );
        
        response(0, 'Successful Request');
    }

    function response($code, $message, $data = null) {
        die(json_encode([
            'message' => $message,
            'return' => $data
        ]));
    }
?>