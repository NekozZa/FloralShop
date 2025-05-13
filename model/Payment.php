<?php 
    require_once('../database.php');

    class Payment {
        public function get_revenue(){
            $conn = connect();
            
            $sql = "
                SELECT sum(total_amount) as total_revenue
                FROM payments
                INNER JOIN `orders` ON payments.order_id = `orders`.order_id
                WHERE payment_status = 'completed'
            ";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
            $stmt->close();
            $conn->close();

            return $data['total_revenue'];
        }

        public function get_months_revenue() {
            $conn = connect();
            
            $sql = "
                SELECT
                    MONTH(payment_date) as month_number,
                    DATE_FORMAT(payment_date, '%M') AS month_name,
                    SUM(amount) as month_sale
                FROM `payments`
                GROUP BY month_number
                ORDER BY month_number
            ";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $months_revenue = [];
            
            while ($row = $result->fetch_assoc()) {
                $months_revenue[] = $row;
            }

            $stmt->close();
            $conn->close();

            return $months_revenue;
        }

        public function get_flowers_most_revenue() {
            $conn = connect();
            
            $sql = "
                SELECT flowers.name, SUM(order_items.price_each * order_items.quantity) as total_sale
                FROM flowers
                INNER JOIN order_items ON flowers.flower_id = order_items.flower_id
                GROUP BY flowers.flower_id, flowers.name
                ORDER BY SUM(order_items.price_each * order_items.quantity) DESC
                LIMIT 5
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