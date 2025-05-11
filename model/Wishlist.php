<?php 
    require_once('../database.php');

    class Wishlist {
        public function get_wishlist($account_id) {
            $conn = connect();
            $sql = "SELECT wishlist.wishlist_id, flowers.name, flowers.price, flowers.stock_quantity, flowers.image_url, flowers.flower_id from wishlist
                    JOIN flowers on flowers.flower_id = wishlist.flower_id
                    JOIN accounts on accounts.account_id = wishlist.account_id
                    WHERE accounts.account_id = ?";

            $stm = $conn->prepare($sql);
            $stm->bind_param("i", $account_id);
            $stm->execute();
            
            $result = $stm->get_result();
    
            $wishlist = [];
            while ($row = $result->fetch_assoc()) {
                $wishlist[] = $row;
            }
            $stm->close();
            return $wishlist;
        }

        public function add_to_wishlist($user_id, $product_id) {
            $conn = connect();
            $sql = "
                SELECT * 
                FROM wishlist 
                WHERE account_id = ? AND flower_id = ?
            ";

            $stm = $conn->prepare($sql);
            $stm->bind_param("ii", $user_id, $product_id);
            $stm->execute();
            $stm->store_result();
            
            if ($stm->num_rows > 0) {
                $stm->close();
                return false;
            }
            
            $stm->close();

            $sql = "
                INSERT INTO wishlist (account_id, flower_id) 
                VALUES (?, ?)
            ";
            
            $stm = $conn->prepare($sql);
            
            $stm->bind_param("ii", $user_id, $product_id);
            $result = $stm->execute(); 
            $stm->close();
            return $result;
        }

        public function remove_wishlist_item($wishlist_id){
            $conn = connect();

            $sql = "
                DELETE FROM wishlist where wishlist_id = ?
            ";

            $stm = $conn->prepare($sql);
            $stm->bind_param('i', $wishlist_id);
            $res = $stm->execute();
            $stm->close();
            $conn->close();

            return $res;
        }
    }

?>