<?php include '../controller/database.php' ?>

<?php 
    session_start();
    header('Content-Type: application/json');   

    $raw = file_get_contents("php://input");
    $data = json_decode($raw, true);   

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $name = $data['name'];
        $description = $data['description'];
        $price = $data['price'];
        $stockQuantity = $data['stockQuantity'];
        $categoryID = $data['categoryID'];
        $shopID = $data['shopID'];

        $sql = "
            INSERT INTO product (ShopID, Name, Description, Price, StockQuantity, CategoryID, ImageURL)
            VALUES($shopID, '$name', '$description', $price, $stockQuantity, $categoryID, null)
        ";

        $data = mysqli_query($conn, $sql);   
        
        $response = [
            'message' => 'Successful'
        ];

        echo json_encode($response);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($data['productID'])) {
        $userID = $_SESSION['UserID'];
        $productID = $data['productID'];
        $categoryID = $data['categoryID'];
        $name = $data['name'];
        $description = $data['description'];
        $price = $data['price'];
        $stockQuantity = $data['stockQuantity'];
        
        $sql = "
            UPDATE product
            INNER JOIN shop ON shop.ShopID = product.ShopID
            SET product.Name = '$name', product.Description = '$description', product.Price = $price, product.StockQuantity = $stockQuantity , product.CategoryID = $categoryID
            WHERE shop.UserID = $userID and product.ProductID = $productID
        ";

            
        mysqli_query($conn, $sql);     
        
        $response = [
            'message' => 'Successful'
        ];

        echo json_encode($response);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($data['productID'])) {
        $productID = $data['productID'];

        $sql = "
                SELECT * 
                FROM `orderitem`
                where `orderitem`.`ProductID` = $productID
            ";

        $data = mysqli_query($conn, $sql);

        if (mysqli_num_rows($data) == 0){
            $sql= "
                SELECT * 
                FROM cartitem
                where cartitem.ProductID = $productID
            ";
            $check = mysqli_query($conn, $sql);
            if(mysqli_num_rows($check) > 0){
                $sql = "
                        DELETE FROM cartitem where cartitem.ProductID = $productID
                    ";
                $res1 = mysqli_query($conn, $sql);
            }

            $sql = "
                    DELETE FROM product WHERE product.ProductID = $productID 
                ";
            $res2 = mysqli_query($conn, $sql);
        }

        $response = [
            'message' => 'Successful'
        ];

        echo json_encode($response);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['shopID'])) {
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/public/img/";
        $file = $_FILES['image'];
        $shopID = $_POST['shopID'];
        $type = $_POST['type'];
        
        if ($file['error'] === 0) {
            $fileName = basename($file['name']);
            $fileTmp = $file['tmp_name'];
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
            $newName = 'shop-'. $type .'-' . $shopID . '.' . $fileExt;
            $targetFilePath = $targetDir . $newName;

            if ($fileExt != 'jpg') {
                echo "Only support jpg";
                exit;
            }

            if (move_uploaded_file($fileTmp, $targetFilePath)) {
                echo 'Image uploaded';
            } else {
                echo $shopID;
            }
        }
    }


?>