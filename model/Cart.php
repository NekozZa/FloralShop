<?php 
    require_once('../database.php');

    class Cart { 
        public function get_cartlist($account_id){
            $conn = connect();
            $sql = "
                SELECT *
                FROM cart_item 
                Join flowers on flowers.flower_id = cart_item.flower_id
                Join cart on cart.cart_id = cart_item.cart_id
                WHERE cart.account_id = ?
            ";
            
            $stm = $conn->prepare($sql);
            $stm->bind_param("i", $account_id);
            $stm->execute();

            $result = $stm->get_result();
            $cartitemlist = [];

            while ($row = $result->fetch_assoc()) {
                $cartitemlist[] = $row;
            }

            $stm->close();
            $conn->close();

            return $cartitemlist;
        }

        public function add_to_cart($account_id, $flower_id, $quantity) {
            $conn = connect();
            $sql = "
                SELECT cart_id FROM cart WHERE account_id = ?
            ";
            
            $checkStmt = $conn->prepare($sql);
            $checkStmt->bind_param("i", $account_id);
            $checkStmt->execute();
            $result = $checkStmt->get_result();
            $row = $result->fetch_assoc();
            
            if (!empty($row)) {
                $cart_id = $row['cart_id'];
            } else {
                $createStmt = $conn->prepare("INSERT INTO cart (account_id) VALUES (?)");
                $createStmt->bind_param("i", $account_id);
                $createStmt->execute();
                $cart_id = $conn->insert_id;
                $createStmt->close();
            }

            $sql = "
                SELECT quantity FROM cart_item WHERE cart_id = ? AND flower_id = ?
            ";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $cart_id, $flower_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if (!empty($row)) {
                $new_quantity = $row['quantity'] + $quantity;
                $update = $conn->prepare("UPDATE cart_item SET quantity = ? WHERE cart_id = ? AND flower_id = ?");
                $update->bind_param("iii", $new_quantity, $cart_id, $flower_id);
                return $update->execute();
            } else {
                $insert = $conn->prepare("INSERT INTO cart_item (cart_id, flower_id, quantity) VALUES (?, ?, ?)");
                $insert->bind_param("iii", $cart_id, $flower_id, $quantity);
                return $insert->execute();
            }
        }

        public function remove_cart_item($cartitem_id, $account_id){
            $conn = connect();

            $sql = "
                DELETE FROM cart_item where cartitemId = ?
            ";

            $stm = $conn->prepare($sql);
            $stm->bind_param('i', $cartitem_id);
            $res = $stm->execute();
            $stm->close();

            $sql = "
                SELECT * FROM cart_item 
                JOIN cart on cart.cart_id = cart_item.cart_id
                where cart.account_id = ?
            ";

            $check = $conn->prepare($sql);
            $check->bind_param('i', $account_id);
            $check->execute();
            $checkExist = $check->get_result();

            if($checkExist->num_rows == 0){
                $sql = "
                    DELETE FROM cart where account_id = ?
                ";
                
                $final = $conn->prepare($sql);
                $final->bind_param('i', $account_id);
                $final->execute();
            }

            $conn->close();
            return $res;
        }
    }
?>