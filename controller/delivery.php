<?php include './database.php' ?>

<?php 
    session_start();
    header('Content-Type: application/json');

    $raw = file_get_contents("php://input");
    $data = json_decode($raw, true);   


?>

<?php 
    
?>