<?php 
    require_once('../model/Flower.php');

    session_start();
    header('Content-Type: application/json');

    class StorageController {

        function get_all_flowers(){
            $flower_model = new Flower();
            return $flower_model->get_flowers();
        }

        function get_flowers_by_filter($category_id, $sort, $min_price, $max_price) {
            $flower_model = new Flower();
            return $flower_model->get_flowers_by_filer($category_id, $sort, $min_price, $max_price);
        }
    }

    $storage_controller = new StorageController();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['action']) && $_GET['action'] === 'filter') {
            $sort = $_GET['sort'] ?? '';
            $category_id = $_GET['category_id'] ?? ''; 
            $min_price = $_GET['min_price'] ?? 0;
            $max_price = $_GET['max_price'] ?? 100000;

            $flowers = $storage_controller->get_flowers_by_filter($category_id, $sort, $min_price, $max_price);
            response(0, 'Filtered flowers', $flowers);
        } else {
            $flowers = $storage_controller->get_all_flowers();
            response(0, 'Fetched Products', $flowers);
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