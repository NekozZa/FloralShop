<?php 
    require_once('../model/Request.php');

    session_start();
    header('Content-Type: application/json');

    class RequestController {
        
        function create_refund_request($orderID, $customerID, $reason) {
            $request_model = new Request();
            return $request_model->create_refund_request($orderID, $customerID, $reason);
        }  
        
        public function update_refund_status($refund_id) { 
            $request_model = new Request();
            return $request_model->update_refund_status($refund_id);
        }
    }

    $request_controller = new RequestController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($_POST['reason'])) {
            response(1, 'Empty Reason');
        }

        $success = $request_controller->create_refund_request(
            $_POST['order_id'], 
            $_POST['customer_id'], 
            $_POST['reason']
        );
        
        response(0, 'Successful Request');
    } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $data = json_decode(file_get_contents("php://input"), true);
        $request_controller->update_refund_status($data['refund_id']);
        response(0, 'Update Refund Status Successfully');
    }
    function response($code, $message, $data = null) {
        die(json_encode([
            'code' => $code,
            'message' => $message,
            'return' => $data
        ]));
    }
?>