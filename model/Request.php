<?php 
    require_once('../database.php');

    class Request {

        public function get_payment_requests () {

        }

        public function create_refund_request($orderID, $customerID, $reason) {
            $conn = connect();

            $sql = "
                INSERT INTO refund_requests (order_id, customer_id, reason)
                VALUES (?, ?, ?)
            ";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('iis', $orderID, $customerID, $reason);
            $res = $stmt->execute();
            $stmt->close();
            $conn->close();

            return $res;
        }
    }  
?>