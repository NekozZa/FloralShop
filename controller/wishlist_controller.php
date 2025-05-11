<?php 
    require_once('../model/Wishlist.php');

    session_start();
    header('Content-Type: application/json');

    class WishlistController {
        function get_wishlist($account_id){
            $wishlsit_model = new Wishlist();
            return $wishlsit_model->get_wishlist($account_id);
        }

        function add_to_wishlist($user_id, $flower_id){
            $wishlist_model = new Wishlist();
            return $wishlist_model->add_to_wishlist($user_id, $flower_id);
        }

        function remove_wishlist_item($wishlist_id){
            $wishlist_model = new Wishlist();
            return $wishlist_model->remove_wishlist_item($wishlist_id);
        }
    }

    $wishlist_controller = new WishlistController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_SESSION['account_id'])) {
            response(1, 'You must be logged in to add to wishlist');
        }

        $account_id = $_SESSION['account_id'] ?? null;
        $flower_id = $_POST['flower_id'] ?? 0;

        if (!$flower_id) {
            response(1, 'Flower ID is missing');
            exit;
        }
    
        $result = $wishlist_controller->add_to_wishlist($account_id, $flower_id);
        response(0, 'Added to wishlist', $result);
    }

    if( $_SERVER['REQUEST_METHOD'] === 'GET') {
        $account_id = $_SESSION['account_id'];
        $wishlist = $wishlist_controller->get_wishlist($account_id);
        response(0, 'Fetched WishList', $wishlist);
    }

    if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['wishlist_id'])) {
            $wishlist_id = $data['wishlist_id'];
            $success = $wishlist_controller->remove_wishlist_item($wishlist_id);

            if ($success) {
                response(0, "Delete Successfully");
            } else {
                response(1, "Failure in Delete");
            }
        } else {
            response(1, "Missing wishlist_id");
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