<?php 
    require_once('../database.php');

    class Request {

        public function create_refund_request($order_id, $customer_id, $reason) {
            $conn = connect();

            $sql = "
                INSERT INTO refund_requests (order_id, customer_id, reason)
                VALUES (?, ?, ?)
            ";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('iis', $order_id, $customer_id, $reason);
            $res = $stmt->execute();
            $stmt->close();
            $conn->close();

            return $res;
        }

        public function update_refund_status($refund_id) {
            $conn = connect();

            $sql = "
                UPDATE refund_requests
                SET status = 'approved'
                WHERE refund_id = ?
            ";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $refund_id);
            $res = $stmt->execute();
            $stmt->close();
            $conn->close();

            return $res;
        }
    }  
?>