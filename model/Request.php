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

            $stm = $conn->prepare($sql);
            $stm->bind_param('iis', $orderID, $customerID, $reason);
            $res = $stm->execute();
            $stm->close();
            $conn->close();

            return $res;
        }

        public function get_flowers(){
            $conn = connect();
            $sql = "SELECT * FROM flowers";

            
            $result = mysqli_query($conn, $sql);
            $flowers = [];

            while ($row = mysqli_fetch_assoc($result)) {
                $flowers[] = $row;
            }

            return $flowers;
        }

        public function get_filter_sorted($category, $sort, $minPrice, $maxPrice) {
            $conn = connect();
            $sql = "SELECT * FROM flowers WHERE 1=1";

            if (!empty($category) && $category > 0) {
                $category = mysqli_real_escape_string($conn, $category);
                $sql .= " AND category_id = $category";
            }

            if ($minPrice !== '' && $maxPrice !== '') {
                $sql .= " AND price BETWEEN $minPrice AND $maxPrice";
            }
    
            if ($sort === 'price_asc') {
                $sql .= " ORDER BY price ASC";
            } elseif ($sort === 'price_desc') {
                $sql .= " ORDER BY price DESC";
            }
    
            $result = mysqli_query($conn, $sql);
            $flowers = [];
    
            while ($row = mysqli_fetch_assoc($result)) {
                $flowers[] = $row;
            }
    
            return $flowers;
        }

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

        public function get_cartlist($account_id){
            $conn = connect();
            $sql = "SELECT * FROM cart_item 
                    Join flowers on flowers.flower_id = cart_item.flower_id
                    Join cart on cart.cart_id = cart_item.cart_id
                    WHERE cart.account_id = ?";
            
            $stm = $conn->prepare($sql);
            $stm->bind_param("i", $account_id);
            $stm->execute();

            $result = $stm->get_result();
    
            $cartitemlist = [];
            while ($row = $result->fetch_assoc()) {
                $cartitemlist[] = $row;
            }
            $stm->close();
            return $cartitemlist;
        }

        public function add_to_wishlist($user_id, $product_id) {
            $conn = connect();

            $stm = $conn->prepare("SELECT * FROM wishlist WHERE account_id = ? AND flower_id = ?");
            
            $stm->bind_param("ii", $user_id, $product_id);
            $stm->execute();
            $stm->store_result();
            
            if ($stm->num_rows > 0) {
                $stm->close();
                return false;
            }
            $stm->close();

            $sql = "INSERT INTO wishlist (account_id, flower_id) VALUES (?, ?)";
            
            $stm = $conn->prepare($sql);
            
            $stm->bind_param("ii", $user_id, $product_id);
            $result = $stm->execute(); 
            $stm->close();
            return $result;
        }
    
        

        public function add_to_cart($account_id, $flower_id, $quantity) {

            $conn = connect();
            $sql = "SELECT cart_id FROM cart WHERE account_id = ?";
            $checkStm = $conn->prepare($sql);

            $checkStm->bind_param("i", $account_id);
            $checkStm->execute();
            $result = $checkStm->get_result();

            $row = $result->fetch_assoc();
            if (!empty($row)) {
                $cart_id = $row['cart_id'];
            } else {
                //$checkStm->close();

                $CreateStm = $conn->prepare("INSERT INTO cart (account_id) VALUES (?)");
                $CreateStm->bind_param("i", $account_id);
                $CreateStm->execute();
                $cart_id = $conn->insert_id;
                $CreateStm->close();
            }
            //$checkStm->close();

            $sql = "SELECT quantity FROM cart_item WHERE cart_id = ? AND flower_id = ?";
            $stm = $conn->prepare($sql);
            $stm->bind_param("ii", $cart_id, $flower_id);
            $stm->execute();
            $result = $stm->get_result();

            $row = $result->fetch_assoc();
            if (!empty($row)) {
                //$stm->close();
                
                $new_quantity = $row['quantity'] + $quantity;
                $update = $conn->prepare("UPDATE cart_item SET quantity = ? WHERE cart_id = ? AND flower_id = ?");
                $update->bind_param("iii", $new_quantity, $cart_id, $flower_id);

                
                return $update->execute();
            } else {
                //$stm->close();
                
                $insert = $conn->prepare("INSERT INTO cart_item (cart_id, flower_id, quantity) VALUES (?, ?, ?)");
                $insert->bind_param("iii", $cart_id, $flower_id, $quantity);
                //$insert->close();
                return $insert->execute();
            }
        }


        public function removeWishListRow($wishlist_id){
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

        public function removeCartListRow($cartitem_id, $account_id){
            $conn = connect();

            $sql = "
                DELETE FROM cart_item where cartitemId = ?
            ";

            $stm = $conn->prepare($sql);
            $stm->bind_param('i', $cartitem_id);
            $res = $stm->execute();
            $stm->close();

            $sql = "SELECT * FROM cart_item 
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