<<<<<<< HEAD
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

        public function create_order($account_id,$cart_items,$total_amount,$payment_method){
            $conn = connect();
            // mapping customer id and account id
            $sql_customer = "SELECT customer_id FROM customers WHERE account_id = ?";
            $stm_customer = $conn->prepare($sql_customer);
            $stm_customer->bind_param("i", $account_id);
            $stm_customer->execute();
            $result_customer = $stm_customer->get_result();
            $customer_id = $result_customer->fetch_assoc()['customer_id'];
            $stm_customer->close();

            #create order
            $sql_order = "INSERT INTO orders(customer_id,total_amount,order_date,status) VALUES(?,?,now(),'pending')";
            $stm = $conn->prepare($sql_order);
            $stm ->bind_param("id", $customer_id,$total_amount);
            if($stm->execute()){
                $order_id = $conn->insert_id;
            } 
            else {
                $stm->close();
                $conn->close();
                return false;
            }

            #create order items
            $sql_item = "INSERT INTO order_items(order_id,flower_id,quantity,price_each) VALUES(?,?,?,?)";
            $stm_item = $conn->prepare($sql_item);
            
            foreach($cart_items as $item){
                $stm_item->bind_param("iiid", $order_id, $item->flower_id, $item->quantity, $item->price);
                $stm_item->execute();
            }

            #create payment
            $sql_payment = "INSERT INTO payments(order_id,payment_method,payment_date,amount,payment_status) VALUES(?, ?, now(), ?, 'pending')";
            $stm_payment = $conn->prepare($sql_payment);
            $stm_payment->bind_param("isd", $order_id,$payment_method,$total_amount);
            $stm_payment->execute();

            #empty cart
            $sql_empty = 'DELETE FROM cart_item WHERE cart_id = (SELECT cart_id FROM cart WHERE account_id = ?)';
            $stm_empty = $conn->prepare($sql_empty);
            $stm_empty ->bind_param("i",$account_id);
            $stm_empty->execute();

            $stm_payment->close();
            $stm_empty->close();
            $stm->close();
            $stm_item->close();
            $conn->close();
            return $order_id;
        }
    }
?>