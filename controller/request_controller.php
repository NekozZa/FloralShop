<?php 
    require_once('../model/Request.php');

    session_start();
    if (!isset($_SESSION['account_id'])) {
        $_SESSION['account_id'] = 1;
    }
    header('Content-Type: application/json');


    class RequestController {
        
        function create_refund_request($orderID, $customerID, $reason) {
            $request_model = new Request();
            return $request_model->create_refund_request($orderID, $customerID, $reason);
        }

        function get_all_flowers(){
            $request_model = new Request();
            return $request_model->get_flowers();
        }

        function get_filter_sorted($category, $sort, $min_price, $max_price){
            $request_model = new Request();
            return $request_model->get_filter_sorted($category, $sort,$min_price, $max_price);
        }

        function get_wishlist($account_id){
            $request_model = new Request();
            return $request_model->get_wishlist($account_id);
        }

        function get_cartlist($account_id){
            $request_model = new Request();
            return $request_model->get_cartlist($account_id);
        }

        function add_to_wishlist($user_id, $flower_id){
            $request_model = new Request();
            return $request_model->add_to_wishlist($user_id, $flower_id);
        }

        function add_to_cart($user_id, $flower_id, $quantity){
            $request_model = new Request();
            return $request_model->add_to_cart($user_id, $flower_id,$quantity);
        }

        function removeWishListRow($wishlist_id){
            $request_model = new Request();
            return $request_model->removeWishListRow($wishlist_id);
        }

        function removeCartListRow($cartitem_id, $account_id){
            $request_model = new Request();
            return $request_model->removeCartListRow($cartitem_id, $account_id);
        }
        
    }

    $request_controller = new RequestController();

    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     if (empty($_POST['reason'])) {
    //         response(1, 'Empty Reason');
    //     }

    //     $success = $request_controller->create_refund_request(
    //         $_POST['orderID'], 
    //         1, 
    //         $_POST['reason']
    //     );
        
    //     response(0, 'Successful Request');
    // }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if(isset($_GET['action']) && $_GET['action'] === 'addWishlist'){

            if (!isset($_SESSION['account_id'])) {
                response(1, 'You must be logged in to add to wishlist');
            }

            $account_id = $_SESSION['account_id'] ?? null;
            $flower_id = $_POST['flower_id'] ?? 0;

            if (!$flower_id) {
                response(1, 'Flower ID is missing');
                exit;
            }
        
            $result = $request_controller->add_to_wishlist($account_id, $flower_id);
        
            response(0, 'Added to wishlist', $result);
        }
        else if(isset($_GET['action']) && $_GET['action'] === 'addToCart'){
            
            if (!isset($_SESSION['account_id'])) {
                response(1, 'You must be logged in to add to wishlist');
            }

            $account_id = $_SESSION['account_id'];
            $flower_id = $_POST['flower_id'] ?? null;
            $quantity = 1;
            if ($flower_id && $account_id) {
                
                $result = $request_controller->add_to_cart($account_id, $flower_id, $quantity);
                response(0, 'Added to cart', $result);
            }else{
                response(1, 'Failed in adding to cart', $result);
            }
        }
        
    }
    else if($_SERVER['REQUEST_METHOD'] === 'GET'){
        if (isset($_GET['action']) && $_GET['action'] === 'getAll') {
            
            $flowers = $request_controller->get_all_flowers();
            response(0, 'Fetched Products', $flowers);
        }
        else if (isset($_GET['action']) && $_GET['action'] === 'filter') {
            
            $sort = $_GET['sort'] ?? '';
            $category_id = $_GET['category_id'] ?? ''; 
            $min_price = $_GET['min_price'] ?? 0;
            $max_price = $_GET['max_price'] ?? 100000;

            $flowers = $request_controller->get_filter_sorted($category_id, $sort, $min_price, $max_price);
            response(0, 'Filtered flowers', $flowers);
        }
        else if(isset($_GET['action']) && $_GET['action'] === 'getWishList'){

            $account_id = $_SESSION['account_id'];
            $wishlist = $request_controller->get_wishlist($account_id);
            response(0, 'Fetched WishList', $wishlist);
        }
        else if(isset($_GET['action']) && $_GET['action'] === 'getCartList'){
            
            $account_id = $_SESSION['account_id'];
            $cartlist = $request_controller->get_cartlist($account_id);
            response(0, 'Fetched CartList', $cartlist);
        }
    }
    else if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
        $data = json_decode(file_get_contents('php://input'), true);
        if(isset($_GET['action']) && $_GET['action'] === 'removeWishListRow'){
            
            if (isset($data['wishlist_id'])) {
                $wishlist_id = $data['wishlist_id'];

                $success = $request_controller->removeWishListRow($wishlist_id);

                if ($success) {
                    response(0, "Delete Successfully");
                } else {
                    response(1, "Failure in Delete");
                }
            } else {
                response(1, "Missing wishlist_id");
            }
        }
        else if (isset($_GET['action']) && $_GET['action'] === 'removeCartListRow'){
            //$data = json_decode(file_get_contents('php://input'), true);
            if (isset($data['cartitem_id'])) {
                $account_id = $_SESSION['account_id'] ?? null;
                if(!$account_id){
                    response(1, "User not logged in!");
                }

                $cartitem_id = $data['cartitem_id'];
                
                $success = $request_controller->removeCartListRow($cartitem_id, $account_id);
                if ($success) {
                    response(0, "Delete Successfully");
                } else {
                    response(1, "Failure in Delete");
                }
            } else {
                response(1, "Missing cartitem_id");
            }
        }
    }
    



    function response($code, $message, $data = null) {
        die(json_encode([
            'code' => $code,
            'message' => $message,
            'return' => $data
        ]));
    }
?>