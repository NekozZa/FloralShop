<?php 
    require_once('../database.php');

    class Order { 
        public function get_orders($customer_id){
            $conn = connect();
            $sql = "
                SELECT *
                FROM `orders`
                INNER JOIN order_items ON `orders`.order_id = order_items.order_id
                INNER JOIN flowers ON order_items.flower_id = flowers.flower_id
                WHERE customer_id = ? and `orders`.status = 'pending' and `orders`.order_id NOT IN ( SELECT order_id FROM refund_requests )
            ";
            
            $stm = $conn->prepare($sql);
            $stm->bind_param("i", $customer_id);
            $stm->execute();

            $result = $stm->get_result();
            $orders = [];

            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }

            $stm->close();
            $conn->close();

            return $orders;
        }
    }
?>