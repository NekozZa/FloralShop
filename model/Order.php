<?php
    require_once('../database.php');

    class Order { 
        public function create_order($customer_id,$cart_items,$total_amount){
            $conn = connect();
            
            $sql = "INSERT INTO orders(customer_id,total_amount,order_date,status) VALUES(?,?,now(),'pending')";
            $stm = $conn->prepare($sql);
            $stm ->bind_param("ii", $customer_id,$total_amount);
            if($stm->execute()){
                $order_id = $conn->insert_id;
            } 
            else {
                $stm->close();
                $conn->close();
                return false;
            }
            $sql_item = "INSERT INTO order_items(order_id,flower_id,quantity,price_each) VALUES(?,?,?)";
            $stm_item = $conn->prepare($sql_item);
            foreach($cart_items as $item){
                $stm_item->bind_param("iiid", $order_id, $item['flower_id'], $item['quantity'], $item['price']);
                $stm_item->execute();
            }
            $conn->commit();
            $stm->close();
            $stm_item->close();
            $conn->close();
        }
    }
?>