<?php 
    require_once('../database.php');

    class Staff {
        public function get_staff(){
            $conn = connect();
            
            $sql = "
                SELECT * 
                FROM accounts
                WHERE role = 'staff'
            ";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $staff = [];
            
            while ($row = $result->fetch_assoc()) {
                $staff[] = $row;
            }

            $stmt->close();
            $conn->close();

            return $staff;
        }
    }
?>