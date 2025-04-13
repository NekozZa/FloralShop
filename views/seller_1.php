<?php include '../controller/database.php' ?>

<?php 
    session_start();

    if (isset($_SESSION['UserID'])) {
        $userID = $_SESSION['UserID'];

        $sql = "
            SELECT product.*
            FROM shop
            INNER JOIN product ON shop.ShopID = product.ShopID 
            WHERE shop.UserID = $userID
        ";

        $products = mysqli_query($conn, $sql);
    }
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MultiShop - Online Shop Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">


</head>

<body>
    <!-- Topbar Start -->
    <?php include './partials/topbar.php' ?>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <?php include './partials/navbar.php' ?>

    <div class="container-fluid px-5 shadow-sm border-bottom" style="height: auto">
        <div class="row mb-3">
            <div class="col-lg-3 ps-0 mb-3">
                <div class="border rounded p-2 d-flex" style="height: auto">
                    <div class="border rounded rounded-circle" style="height: 10vh; width: 10vh">

                    </div>

                    <div>
                        Ching chong
                    </div>
                </div>
            </div>

            <div class="col-lg-9 p-0 d-flex">
                <ul class="m-0 p-0" style="list-style: none">
                    <li class="mb-2">
                        <?php 
                            $sql = "
                                SELECT COUNT(product.ProductID) as TotalProducts
                                FROM shop
                                INNER JOIN product ON shop.ShopID = product.ShopID 
                                WHERE shop.UserID = $userID
                            ";
                    
                            $data = mysqli_query($conn, $sql);
                            $length = mysqli_fetch_assoc($data);
                        ?>
                        <i class="bi bi-box-seam"></i> Products: <?= $length['TotalProducts'] ?>
                    </li>
                    <li>
                        <?php 
                            $sql = "
                                SELECT AVG(productreview.Rating) as AvgRating
                                FROM shop
                                INNER JOIN product ON shop.ShopID = product.ShopID 
                                INNER JOIN productreview ON product.ProductID = productreview.ProductID
                                WHERE shop.UserID = $userID
                            ";

                            $data = mysqli_query($conn, $sql);
                            $rating = mysqli_fetch_assoc($data);
                        ?>
                        <i class="bi bi-star"></i> Rating: <?= number_format($rating['AvgRating'], 2, '.', '') ?>
                    </li>
                </ul>
                
                
            </div>
        </div>

        <div class="row" style>
            <ul class="m-0 p-0 d-flex" style="list-style: none">
                <li class="px-3 border-bottom border-primary">All</li>
                <li class="px-3">Phones</li>
                <li class="px-3">Laptop</li>
            </ul>
        </div>
    </div>

    <?php include './partials/drop_zone.php' ?>

    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Featured Products</span></h2>
        <div class="row px-xl-5">
            <?php if (mysqli_num_rows($products) > 0) { ?>
                <?php while ($product = mysqli_fetch_assoc($products)) { ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                        <div class="product-item bg-light mb-4">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="/public/img/product-1.jpg" alt="">
                                <div class="product-action">
                                    <!-- <a class="btn btn-outline-dark btn-square add-item-btn" data-product-i-d=<?= $product['ProductID'] ?>><i class="fa fa-shopping-cart"></i></a> -->
                                    
                                    <a class="btn btn-outline-dark btn-square inspect-item-btn" data-bs-toggle="modal"  data-bs-target="#editProduct"><i class="bi bi-pencil-square"></i></a>
                                    <a class="btn btn-outline-dark btn-square inspect-item-btn" href="/views/detail.php?productID=<?= $product['ProductID'] ?>"><i class="fa fa-search"></i></a>
                                    <a class="btn btn-outline-dark btn-square delete-btn" onclick="this.closest('form').submit(); return false;"><i class="bi bi-x"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href=""><?= $product['Name'] ?></a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5><?= $product['Price'] ?></h5><h6 class="text-muted ml-2"><del><?= $product['Price'] ?></del></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small>(99)</small>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!-- Modal -->
                    
                <!-- Modal -->

                <?php } ?>
            <?php } ?>
            <!-- Pop up add item -->
            
             <!-- Pop up list order -->           
            
            <!-- End of Pop up list order -->         

        </div>
    </div>

    <?php include './partials/footer.php' ?>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script>
        

    </script>

</body>
    
</html>