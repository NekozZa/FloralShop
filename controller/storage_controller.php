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

        function get_flowers_random ($limit) {
            $flower_model = new Flower();
            return $flower_model->get_flowers_random($limit);
        }
        function delete_one_flower($flower_id){
            $flower_model = new Flower();
            return $flower_model->delete_flower($flower_id);
        }
        function update_flower($flower_id, $name, $description, $price, $stock_quantity){
            $flower_model = new Flower();
            return $flower_model->update_flower($flower_id, $name, $description, $price, $stock_quantity);
        }
        function add_one_flower($name, $description, $price, $stock_quantity, $category_id,$image){
            $flower_model = new Flower();
            return $flower_model->add_flower($name, $description, $price, $stock_quantity, $category_id,$image);
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
        } else if (isset($_GET['action']) && $_GET['action'] === 'random') {
            $flowers = $storage_controller->get_flowers_random(4);
            response(0, 'Random flowers', $flowers);
        } else{
            $flowers = $storage_controller->get_all_flowers();
            response(0, 'All Flowers', $flowers);
        }
    }
    if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
        $flower_id = $_GET['flower_id'] ?? '';
        $flower_id = intval($flower_id);
        if(empty($flower_id)){
            response(1, 'Flower ID not found');
        }

        $result = $storage_controller->delete_one_flower($flower_id);
        if($result){
            response(0, 'Delete flower successfully', $result);
        }
        else{
            response(1, 'Delete flower failed');
        }
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'update'){
        
        $flower_id = $_GET['flower_id'] ?? '';
        $flower_id = intval($flower_id);
        if(empty($flower_id)){
            response(1, 'Flower ID not found');
        }

        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? '';
        $stock_quantity = $_POST['stock_quantity'] ?? '';


        $result = $storage_controller->update_flower($flower_id, $name, $description, $price, $stock_quantity);
        
        if($result){
            response(0, 'Update flower successfully', $result);
        }
        else{
            response(1, 'Update flower failed');
        }
    }


    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'add'){
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? '';
        $stock_quantity = $_POST['stock_quantity'] ?? '';
        $category_id = $_POST['category_id'] ?? '';

        if(empty($name) || empty($description) || empty($price) || empty($stock_quantity) || empty($category_id)){
            response(1, 'Missing required fields');
        }

        
        if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = $_FILES['image'];
        }
        $result = $storage_controller->add_one_flower($name, $description, $price, $stock_quantity, $category_id,$image);
        
        if($result){
            response(0, 'Add flower successfully', $result);
        }
        else{
            response(1, 'Add flower failed');
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