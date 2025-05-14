<?php 
    require_once('../database.php');

    class Staff {
        public function get_staff(){
            $conn = connect();
            
            $sql = "
                SELECT * 
                FROM staff
                INNER JOIN accounts ON staff.account_id = accounts.account_id 
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

        public function remove_staff($staff_id) {
            $conn = connect();

            $sql = "
                DELETE FROM staff
                WHERE staff_id = ?
            ";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $staff_id);
            $stmt->execute();
        }
    }
?>