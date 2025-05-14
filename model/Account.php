<?php 
    require_once('../database.php');

    class Account {
        public function remove_account($account_id) {
            $conn = connect();

            $sql = "
                DELETE FROM accounts
                WHERE account_id = ?
            ";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $account_id);
            $stmt->execute();
        }
    }
?>