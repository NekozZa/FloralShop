<?php 
    require_once('../database.php');

    class Flower {
        public function get_flowers(){
            $conn = connect();
            
            $sql = "
                SELECT * 
                FROM flowers
            ";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $flowers = [];
            
            while ($row = $result->fetch_assoc()) {
                $flowers[] = $row;
            }

            $stmt->close();
            $conn->close();

            return $flowers;
        }

        public function get_flowers_by_filer($category_id, $sort, $min_price, $max_price) {
            $conn = connect();
            $sql = "
                SELECT * 
                FROM flowers 
                WHERE 1=1
            ";

            if (!empty($category_id) && $category_id > 0) {
                $category_id = mysqli_real_escape_string($conn, $category_id);
                $sql .= " AND category_id = $category_id";
            }

            if ($min_price !== '' && $max_price !== '') {
                $sql .= " AND price BETWEEN $min_price AND $max_price";
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

        public function get_flowers_random($limit){
            $conn = connect();
            
            $sql = "
                SELECT * 
                FROM flowers
                ORDER BY RAND() 
                LIMIT $limit
            ";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $flowers = [];
            
            while ($row = $result->fetch_assoc()) {
                $flowers[] = $row;
            }

            $stmt->close();
            $conn->close();

            return $flowers;
        }
        public function delete_flower($flower_id){
            $conn = connect();

            $sql_flower = "SELECT * FROM flowers WHERE flower_id = ?";
            $stmt_flower = $conn->prepare($sql_flower);
            $stmt_flower->bind_param("i", $flower_id);
            $stmt_flower->execute();
            $delete_flower = $stmt_flower->get_result()->fetch_assoc();

            $sql = "DELETE FROM flowers WHERE flower_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $flower_id);
            $stmt->execute();


            $stmt_flower->close(); 
            $stmt->close();
            $conn->close();
            return $delete_flower;
        }
        public function update_flower($flower_id, $name, $description,$price,$stock_quantity){
            $conn = connect();
            
            $sql = "UPDATE flowers SET name = ?, description = ?, price = ?, stock_quantity = ? WHERE flower_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssiii", $name, $description,$price, $stock_quantity,$flower_id);

            $stmt->execute();
            $stmt->close();
            $conn->close();

            return $flower_id;
        }
        
        public function add_flower($name, $description, $price, $stock_quantity, $category_id, $image) {
            $conn = connect();

        
            $sql_category = "SELECT category_id FROM category WHERE category_id = ?";
            $stmt_category = $conn->prepare($sql_category);
            $stmt_category->bind_param("i", $category_id);
            $stmt_category->execute();
            if ($stmt_category->get_result()->num_rows === 0) {
                $stmt_category->close();
                $conn->close();
                return false; 
        }
            $stmt_category->close();

            $image_url = null;
            if ($image && isset($image['name']) && !empty($image['name'])) {
                $upload_dir = '../images/';

            $image_extension = pathinfo($image['name'], PATHINFO_EXTENSION);
            $unique_image_name = uniqid('flower_') . '.' . $image_extension;
            $target_path = $upload_dir . $unique_image_name;

            if (move_uploaded_file($image['tmp_name'], $target_path)) {
                $image_url = 'images/' . $unique_image_name;
            } else {
                $conn->close();
                return false; 
            }
        }

            $sql = "INSERT INTO flowers (name, description, price, stock_quantity, category_id, image_url) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdiss", $name, $description, $price, $stock_quantity, $category_id, $image_url);
            $result = $stmt->execute();
            $flower_id = $conn->insert_id;

            $stmt->close();
            $conn->close();
            return $flower_id;
        }
    }
?>