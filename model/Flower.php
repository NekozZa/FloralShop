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
    }
?>