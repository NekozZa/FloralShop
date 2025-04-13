<?php include './database.php' ?>

<?php 
    session_start();
    header('Content-Type: application/json');

    $raw = file_get_contents("php://input");
    $data = json_decode($raw, true);   

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['UserID'])) {
        if (isset($data['productID']) && isset($data['rating']) && isset($data['comment'])) {
            $rating = $data['rating'];
            $comment = $data['comment'];
            $productID = $data['productID'];
            createNewReview($conn, $rating, $comment, $productID);

            echo json_encode([
                'rating' => $rating,
                'comment' => $comment,
                'productID' => $productID
            ]);
        }
    }
?>

<?php
    function createNewReview($conn, $rating, $comment, $productID) {
        $userID = $_SESSION['UserID'];

        $sql = "
            INSERT INTO productreview (UserID, ProductID, Rating, Comment, CreateDate)
            VALUES ($userID, $productID, $rating, '$comment', NOW())
        ";

        mysqli_query($conn, $sql);
    }
?>