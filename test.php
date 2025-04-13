<?php
    $id = '';
    $name = '';
    $price = '';
    $quantity = '';
    $description = '';
    $categoryID = '';
    
    // ADD
    if(isset($_POST['add']) && $_POST['add'] == 'add'){
        // print_r($_POST);
        if(isset($_POST['nameNewProduct']) && isset($_POST['priceNew']) && isset($_POST['quantityNew']) && isset($_POST['descriptionNew']) && isset($_POST['categoryNewID'])){
            
            $id = generateNewID($conn);
            $name = $_POST['nameNewProduct'];
            $description = $_POST['descriptionNew'];
            $price = $_POST['priceNew'];
            $quantity = $_POST['quantityNew'];
            $categoryID = $_POST['categoryNewID'];
            

            $sql = "
                       SELECT shop.ShopID as ShopID FROM shop WHERE shop.UserID = $userID 
                    ";
            $data = mysqli_query($conn, $sql);
            $shopData = mysqli_fetch_assoc($data);
            $shopID = $shopData['ShopID'];

            $sql = "
                    INSERT INTO product (ProductID, ShopID, Name, Description, Price, StockQuantity, CategoryID, ImageURL)
                    VALUES($id, $shopID, '$name', '$description', $price, $quantity, $categoryID, null)
                ";
   
            $data = mysqli_query($conn, $sql);
            header("Location: seller.php");
                 
        }  
    }
    // DELETE
    if(isset($_POST['deleteBtn'])){
        
        
    }
?>

document.getElementById("imageUpload").addEventListener("change", function () {
            const file = this.files[0];
            const preview = document.getElementById("previewImage");

            if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = "block";
            };
            reader.readAsDataURL(file);
            } else {
            preview.src = "#";
            preview.style.display = "none";
            }
        });

       